<?php

namespace fernandosa\Debugginator\Helpers;

use fernandosa\Debugginator\Services\ParserService;

// TODO: create parserService only once
class FileManipulationHelper
{
    private const INTERNAL_FUNCTION_IDENTIFIER = "internal function";

    /**
     * get files names in storage/logs/
     *
     * @param array $dateRange
     * @return array
     */
    public function getFilesNames(array $dateRange): ?array
    {
        $filesNames = scandir(storage_path() . (ParserService::class)::LOGS_PATH);
        $filesNames = $this->filterNonLogFiles($filesNames);
        if($dateRange !== []) {
            $filesNames = $this->filterFilesByDate($dateRange, $filesNames);
        }
        return $filesNames;
    }

    /**
     * parseText
     *
     * @param array $filesNames
     * @return void
     */
    public function parseText(array $filesNames): array
    {
        foreach ($filesNames as $key => $fileName) {
            $fileContent = $this->getContentFromFile($fileName);
            $fileInternalCalls = $this->filterFileContent($fileContent);
            
            
            $logInfos[] =  $fileInternalCalls;
        }

        return $logInfos;
    }    

    /**
     * fileIsLog
     *
     * Check if file is has .log extension name
     * 
     * @param string $name
     * @return bool
     */
    private function fileIsLog(string $name): bool
    {
        return substr($name, -4) === '.log';
    }

    private function getContentFromFile($fileName): array
    {
        return file(storage_path() . (ParserService::class)::LOGS_PATH . $fileName);
    }

    private function filterFileContent(array $fileContent): array
    {
        $fileContent = preg_grep('/'. self::INTERNAL_FUNCTION_IDENTIFIER . '/', $fileContent);
        $fileContent = preg_grep('/' . (ParserService::class)::APP_NAMESPACE . '/', $fileContent);

        return $fileContent;
    }

    private function filterFilesByDate(array $dateRange, array $filesNames) : array
    {
        $startDate = $dateRange[0];
        $endDate = $dateRange[1];
        foreach ($filesNames as $key => $fileName) {
            $date = $this->getDateFromLogFile($fileName);
            if ( ! ($date >= $startDate) && ($date <= $endDate)){
                unset($filesNames[$key]);
            }
        }
        dd($filesNames);
        return $filesNames;
    }
    
    private function getDateFromLogFile(string $logFileName) : string
    {
        $newFileName = str_replace('laravel-', '', $logFileName);
        $newFileName = str_replace('.log', '', $newFileName);
        return $newFileName;
    }

    private function filterNonLogFiles(array $filesNames) : array
    {
        foreach ($filesNames as $key => $fileName) {
            if ( ! $this->fileIsLog($fileName)) {
                unset($filesNames[$key]);
            }
        }
        return $filesNames;
    }
}