<?php

namespace fernandosa\Debugginator\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use fernandosa\Debugginator\Helpers\FileManipulationHelper;

class ParserService
{
    /**
     * Indexed internal function log entries
     * 
     * @var array
     */
    private array $indexedDirectories;

    /**
     * helper to manipulate files.
     * 
     * @var fernandosa\Debugginator\Helpers\FileManipulationHelper;
     */
    private FileManipulationHelper $fileManipulationHelper;

    /**
     * TODO: Make this customizable;
     * 
     * @var string
     */
    public const LOGS_PATH = "/logs/";
    public const APP_NAMESPACE = "App";


    public function __construct()
    {
        $this->fileManipulationHelper = new fileManipulationHelper();
    }

    /**
     * read log files
     *
     * @param array $dateRange format: Y-m-d
     * @return void
     */
    public function readLogFiles(array $dateRange = []): void
    {
        
        $this->validateDateRange($dateRange);
        $filesNames = $this->fileManipulationHelper->getFilesNames($dateRange);
        
        $logInfos = $this->fileManipulationHelper->parseText($filesNames);
        $this->indexedDirectories($logInfos);

        dd($this->indexedDirectories);
    }

    /**
     * getInternalFunctionLogs
     *
     * @return array
     */
    public function getInternalFunctionLogs(): array
    {
        return $this->internalFunctionLogs;
    }

    /**
     * getFilesNames
     *
     * @return array
     */
    private function getFilesNames(): array
    {
        return scandir(storage_path() . self::LOGS_PATH);
    }



    public function indexedDirectories(array $logInfos)
    {

        foreach ($logInfos as $j => $logFile) {
            foreach ($logFile as $key => $info) {
                $info = strstr($info, self::APP_NAMESPACE . '\\');
                $info = preg_split('@\\\@', $info, NULL, PREG_SPLIT_NO_EMPTY);
                $info = str_replace("\n", "", $info);
                foreach ($info as $key => $i) {
                    $name = array_map(
                        function ($keys) use ($key, $info)
                        {
                            $result = "";
                            if($keys >= $key){
                                for($i = 0;$i<=$keys;$i++){
                                    $result .= $info[$i] . "/";
                                }
                                return $result;
                            }
                        },
                        array_keys($info)
                    );

                    if( ! isset($this->indexedDirectories[$key][$name[$key]]))
                        $this->indexedDirectories[$key][$name[$key]] = 0;
                    $this->indexedDirectories[$key][$name[$key]]++;
                }
            }
        }
    }

    public function validateDateRange(array $dateRange) : void
    {
        if($dateRange == []){
            return;
        }
        if(count($dateRange) !== 2){
            throw new Exception("Date range array must have 0 or 2 values");
        }
        return;
    }
}
