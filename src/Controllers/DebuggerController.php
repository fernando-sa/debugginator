<?php

namespace fernandosa\Debugginator\Controllers;

use fernandosa\Debugginator\Services\ParserService;
use fernandosa\Debugginator\Helpers\FileManipulationHelper;

class DebuggerController
{
    public function index()
    {
        $debugger = new ParserService;
        $debugger->readLogFiles(['2020-11-01', '2020-12-31']);

    }
}
