<?php

namespace fernandosa\Debugginator\Viola\Controllers;

use fernandosa\Debugginator\Viola\Services\TemplaterService;

class LogGenerationController
{

    private TemplaterService $templaterService;

    public function __construct()
    {
        $this->templaterService = new TemplaterService;
    }
    
    public function generateLog($errorDate = "", $appFolder, $logFilePath = "")
    {
        $logContent = $this->templaterService->replaceTemplateFields($errorDate, $appFolder);
        $this->templaterService->populateLogFile($logFilePath, $logContent);
    }
}
