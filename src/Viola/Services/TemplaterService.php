<?php

namespace fernandosa\Debugginator\Viola\Services;

use fernandosa\Debugginator\Viola\Generators\ErrorGenerator;
use fernandosa\Debugginator\Viola\Templates\TemplateRepository;

class TemplaterService
{

    private ErrorGenerator $errorGenerator;

    public function __construct()
    {
        $this->errorGenerator = new ErrorGenerator;
    }

    public function replaceTemplateFields($errorDate = "", $appFolder)
    {
        if($errorDate == "") {
            $errorDate = date('Y-m-d h:i:s');
        }
        $fullErrorTemplate = TemplateRepository::FULL_ERROR_TEMPLATE;
        $fullErrorTemplate = str_replace("#DATE", $errorDate, $fullErrorTemplate);

        $stackTrace = $this->errorGenerator->generateStackTrace($errorDate, $appFolder);
        $fullErrorTemplate = str_replace("#LINES", $stackTrace, $fullErrorTemplate);

        return $fullErrorTemplate;
    }
    public function populateLogFile($logFilePath = "", $logFileContent)
    {
        if($logFilePath == "") {
            $today = date('Y-m-d');
            $logFilePath = 'laravel-' . $today . ".log";
        }
        $logStoragePath = storage_path() . "/logs/";
        file_put_contents($logStoragePath . $logFilePath, $logFileContent, FILE_APPEND | LOCK_EX);
        dd('aas');
    }
}
