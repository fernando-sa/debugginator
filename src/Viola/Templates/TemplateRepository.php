<?php

namespace fernandosa\Debugginator\Viola\Templates;


class TemplateRepository
{
    /**
     * public string const
     */
    public const FULL_ERROR_TEMPLATE = '[#DATE 00:59:38] local.ERROR: Undefined class constant "LOGS_PATH" {"exception":"[object] (Error(code: 0): Undefined class constant "LOGS_PATH" at /home/fernando/code/bug/packages/fernandosa/debugginator/src/Services/ParserService.php:58)[stacktrace]#LINES)"}
    ';

    /**
     * public string const
     */
    public const EXTERNAL_FUNCTION_ERROR_TEMPLATE = '/FAKE_TEXT/FAKE_TEXT/FAKE_TEXT/FAKE_TEXT/FAKE_TEXT.php(00): FAKE_TEXT\\FAKE_TEXT\\FAKE_TEXT\\FAKE_TEXT->FAKE_TEXT()';

    /**
     * public string const
     */
    public const INTERNAL_FUNCTION_ERROR_TEMPLATE = '[internal function]: #FILE_NAME->#METHOD_NAME()';
}
