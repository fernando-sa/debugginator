<?php

namespace fernandosa\Debugginator\Services;

class DebuggerService
{
    public function index()
    {
        $reader = new ParserService;
        $reader->readLogFiles();

    }
}
