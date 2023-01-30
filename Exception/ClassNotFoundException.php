<?php

namespace TemplateMakerBundle\Exception;

use Pimcore\Model\Exception\NotFoundException;

class ClassNotFoundException extends NotFoundException
{
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
