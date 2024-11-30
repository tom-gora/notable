<?php

namespace App\Http\Controllers;

use cebe\markdown\Markdown;

class PandocOperationsController extends Controller {
    private $parser;

    public function __construct() {
        $this->parser = new Markdown();
    }

    public function stripMdToPlain(string $md) : string {

        $html = $this->parser->parse($md);
        dd($html);

        $raw = strip_tags($html);
        $raw = preg_replace([ "/-{2,}/", "/<[^>]*>/", "/~~/" ], '', $raw);
        return str_replace("\n", " ", $raw);

    }

}
