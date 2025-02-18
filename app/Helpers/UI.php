<?php

namespace App\Helpers;

class UI {
    // CONST:
    // links to display in a sidebar menu (using iconify and to define an icon only a string to template in is enough)
    public static array $SIDEBAR_LINKS = [
        ['/home', 'Home', 'solar--home-bold-duotone', true],
        ['/transcripts', 'Transcripts', 'hugeicons--quill-write-02', false],
        ['/snapshots', 'Snapshots', 'solar--eye-scan-bold-duotone', false],
        ['/favourites', 'Favourites', 'solar--stars-minimalistic-line-duotone', false],
        ['/archive', 'Archive', 'solar--inbox-archive-line-duotone', false],
        ['/settings', 'Settings', 'solar--settings-line-duotone', false],
    ];

    public static array $TOPBAR_LINKS = [
        'auth_true' => [
            ['/profile', 'Profile'],
        ],
        'auth_false' => [
            ['showLogin', 'Login'],
            ['showRegister', 'Register'],
        ],
    ];

    public static function isHome() : bool {
        return request()->is('home');
    }

    // determine if link in menu is to the currently displayed view to set as prop > style and and model behavior conditionally
    public static function isCurrent(string $link) : bool {
        return request()->is('/') ? request()->is($link) : request()->is(ltrim($link, '/'));
    }

    public static function getTheme() : string {
        if (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark') {
            return 'dark';
        }

        return '';
    }

    public static function getSidebarState() : bool {
        if (isset($_COOKIE['sidebar']) && strpos($_COOKIE['sidebar'], 'expanded') !== false) {
            return true;
        }

        return false;
    }

    public static function getCurrentTitle() : string {
        $route = request()->route()->uri;
        if ($route === '/') {
            return 'Home';
        }

        $current = array_filter(UI::$SIDEBAR_LINKS, function ($link) use ($route) {
            $current = strpos($link[0], $route);

            return $current;
        });
        $current = reset($current);
        if (empty($current)) {
            return 'Home';
        }
        return $current[1];

    }

    /**
     * @param  mixed  $strText
     * @param  mixed  $limit
     */
    public static function textTruncToWord($strText, $limit) : string {
        if (str_word_count($strText, 0) <= $limit) {
            return $strText;
        }
        $words = str_word_count($strText, 2);
        $pos = array_keys($words);
        return substr($strText, 0, $pos[$limit]) . '...';
    }
}
