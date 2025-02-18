<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Sleep;
use Symfony\Component\Console\Command\SignalableCommandInterface;

class Bore extends Command implements SignalableCommandInterface {
    protected $signature = 'bore';

    protected $description = 'Expose local dev server via my self-hosted bore instance';

    protected array $conf = [];

    protected string $hot_path;

    protected string $hot_preserve;

    protected string $l_cmd;

    protected string $v_cmd;

    protected array $log = [];

    protected bool $should_exit = false;

    protected bool $should_report_hot = true;

    //----------------------------------

    /*interface implementation*/
    public function getSubscribedSignals() : array {
        return [SIGINT, SIGTERM];
    }

    public function handleSignal(int $signal, int|false $previousExitCode = 0) : int|false {

        $this->warn($this->log['w'] . 'Closing the tunnels.');
        $this->should_exit = true;
        return false;
    }

    //----------------------------------

    /*constructor*/
    public function __construct() {
        parent::__construct();
        $this->hot_path = public_path('hot');
        $this->conf = [
            'laravel_port' => config('bore.l'),
            'vite_port' => config('bore.v'),
            'bore_ip' => config('bore.ip'),
            'bore_secret' => config('bore.secret'),
        ];

        foreach ($this->log as $key => $value) {
            $this->log[$key] = str_pad($value, 20, ' ', STR_PAD_RIGHT);
        }
        $this->log = [
            'i' => '[INFO]:',
            'w' => '[WARNING]:',
            'e' => '[ERROR]:',
            'l' => '[ARTISAN SERVE]:',
            'v' => '[VITE]:',
        ];

        foreach ($this->log as $key => $value) {
            $this->log[$key] = str_pad($value, 15, ' ', STR_PAD_RIGHT);
        }
    }

    //----------------------------------

    /*logic*/
    public function init() : array {

        // retrieve values from configured env
        $this->info($this->log['i'] . 'Checking config...');
        $errs = [];
        foreach ($this->conf as $k => $v) {
            if ($v === null || $v === '') {
                array_push($errs, $k);
            }
        }
        // bail if any missing
        if (!empty($errs)) {
            $this->error($this->log['e'] . 'Config for bore is missing values for: ' . implode(', ', $errs));
            exit();
        }

        $this->info($this->log['i'] . 'Required config values have been found 😅');

        // construc commands for both processes to spin up
        $this->l_cmd = 'bore local -s ' . $this->conf['bore_secret'] . ' -t ' . $this->conf['bore_ip'] . ' ' . $this->conf['laravel_port'] . ' -p ' . $this->conf['laravel_port'];
        $this->v_cmd = 'bore local -s ' . $this->conf['bore_secret'] . ' -t ' . $this->conf['bore_ip'] . ' ' . $this->conf['vite_port'] . ' -p ' . $this->conf['vite_port'];

        $this->info($this->log['i'] . 'Setting the tunnels up...');

        $l_tunnel = Process::start($this->l_cmd);
        $v_tunnel = Process::start($this->v_cmd);

        Sleep::for(1)->seconds();

        if (!$l_tunnel->running() || !$v_tunnel->running()) {
            $l_last_err = $l_tunnel->latestErrorOutput();
            $v_last_err = $v_tunnel->latestErrorOutput();
            $this->error($this->log['e'] . 'Failed to setup the tunnes. Details:');
            if ($l_last_err) {
                $this->error($this->log['l'] . $l_last_err);
            }
            if ($v_last_err) {
                $this->error($this->log['v'] . $v_last_err);
            }
            exit();
        }

        $this->info($this->log['l'] . 'This dev server is tunneled to via http://' . $this->conf['bore_ip'] . ':' . $this->conf['laravel_port']);
        $this->info($this->log['v'] . 'This dev server is tunneled to via http://' . $this->conf['bore_ip'] . ':' . $this->conf['vite_port']);
        $this->line('');
        $this->line('');
        $this->info($this->log['i'] . 'Close with CTRL + C');
        $this->line('');

        return [0 => $l_tunnel, 1 => $v_tunnel];
    }

    /**
     * @param  array<int,mixed>  $tunnels
     */
    public function checkAndReport(array $tunnels) : void {
        $lastMessages = ['l' => '', 'v' => ''];
        $l_last_msg = $tunnels[0]->latestOutput();
        $v_last_msg = $tunnels[1]->latestOutput();
        if ($l_last_msg !== $lastMessages['l']) {
            $this->line($this->log['l'] . $l_last_msg);
            $lastMessages['l'] = $l_last_msg;
        }
        if ($v_last_msg !== $lastMessages['v']) {
            $this->line($this->log['v'] . $v_last_msg);
            $lastMessages['v'] = $v_last_msg;
        }
    }

    /**
     * @param  mixed  $tunnels
     */
    public function keepHot($tunnels) : mixed {

        $this->info($this->log['i'] . 'Attempting to adjust and watch hot file.');
        while (true) {

            if ($this->should_exit) {
                break;
            }

            if (file_exists($this->hot_path)) {
                $this->hot_preserve ??= file_get_contents($this->hot_path);
            }

            if (file_put_contents($this->hot_path, 'http://' . $this->conf['bore_ip'] . ':' . $this->conf['vite_port'])) {
                if ($this->should_report_hot) {
                    $this->info($this->log['i'] . 'Hot reload file is setup for tunnel access 😎');
                    $this->should_report_hot = false;
                }
            }
            $this->checkAndReport($tunnels);
            Sleep::for(5)->seconds();

        }

        return function () {

            if (file_exists($this->hot_path)) {
                file_put_contents($this->hot_path, $this->hot_preserve);
            }

            $this->info($this->log['i'] . 'Restored original contents of hot file.');
        };
    }

    //----------------------------------
    /*artisan handler*/
    public function handle() : void {
        $tunnels = $this->init();
        $cleanup = $this->keepHot($tunnels);

        $cleanup();

    }
}
