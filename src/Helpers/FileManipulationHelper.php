<?php

namespace fernandosa\Debugginator\Helpers;

use fernandosa\Debugginator\Services\ParserService;

// TODO: create parserService only once
class FileManipulationHelper
{
    private const INTERNAL_FUNCTION_IDENTIFIER = "internal function";

    /**
     * getFilesNames
     *
     * @return array
     */
    public function getFilesNames(): array
    {
        return scandir(storage_path() . (ParserService::class)::LOGS_PATH);
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
            if ( ! $this->fileIsLog($fileName)) {
                unset($filesNames[$key]);
                continue;
            }

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

}