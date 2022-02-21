<?php

namespace HTTPClient;

use Exception;

/**
 * Exception thrown in HTTP request
 */
class HTTPException extends Exception
{
    public function __construct($message = "Unknown error", $code = 0)
    {
        $error = error_get_last();

        $pattern = "/file_get_contents.*HTTP\/[\d.]+\s(\d{3})\s(.*)/";
        if ($error && preg_match($pattern, $error["message"], $errorMatch)) {
            if (isset($errorMatch[1]) && isset($errorMatch[2])) {
                $code = $errorMatch[1];
                $message = $errorMatch[2];
            }
        }

        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return __CLASS__ . ": $this->code $this->message\n";
    }
}
