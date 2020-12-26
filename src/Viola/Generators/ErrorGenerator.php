<?php

namespace fernandosa\Debugginator\Viola\Generators;


use fernandosa\Debugginator\Viola\Templates\TemplateRepository;

class ErrorGenerator
{

    private string $fullErrorTemplate = "";
    private string $externalFunctionLineTemplatePath = "";
    private string $internalFunctionLineTemplatePath= "";

    public function __construct()
    {
        $this->fullErrorTemplate = TemplateRepository::FULL_ERROR_TEMPLATE;
        $this->externalFunctionLineTemplate = TemplateRepository::EXTERNAL_FUNCTION_ERROR_TEMPLATE;
        $this->internalFunctionLineTemplate = TemplateRepository::INTERNAL_FUNCTION_ERROR_TEMPLATE;
    }

    public function generateStackTrace($errorDate = "", $appFolder) : string
    {
        $stackSize = rand(36,42);
        $internalLogLine = rand(3,10);
        $error = $this->fullErrorTemplate;
        $lines = "";
        // Create stack trace
        for ($i=0; $i < $stackSize; $i++) { 
            if($i == $internalLogLine) {
                $randomAppFolderIndex = array_rand($appFolder, 1);
                $line = $this->replaceInternalFunction($i, $appFolder[$randomAppFolderIndex]);
            } else {
                $line = $this->replaceExternalFunction($i);
            }
            $lines .= "{$line}\n";
        }
        return $lines;
    }

    /**
     * create non App\ folder stack trace call
     *
     * @param integer $stackLineNumber
     * @return string
     */
    private function replaceExternalFunction(int $stackLineNumber) : string
    {
        return "#{$stackLineNumber} {$this->externalFunctionLineTemplate}";
    }
    
    /**
     * create stack trace call pointed to App\ folder
     *
     * @param integer $stackLineNumber
     * @param string $fileName
     * @return string
     */
    private function replaceInternalFunction(int $stackLineNumber, string $fileName) : string
    {
        return "#{$stackLineNumber} [internal function]: {$fileName}->fooBar()";
    }    

}
