<?php


namespace App\Exceptions;

use Throwable;

class ApiException extends \RuntimeException
{
    /**
     * ApiException constructor.
     * @param array $errorConst
     * @param Throwable|null $previous
     */
    public function __construct(array $errorConst, string $ext = '', Throwable $previous = null)
    {
        $code = $errorConst[0];
        $message = $ext == '' ? $errorConst[1] : $errorConst[1] . '(' . $ext . ')';
        parent::__construct($message, $code, $previous);
    }
}