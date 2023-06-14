<?php

namespace TemplateMakerBundle\Exception\Validator;

use Throwable;

class TemplateValidationException extends \Exception
{

    const PREFIX = "The template contain some contrait violation ";
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = self::PREFIX.$message;
    }
}
