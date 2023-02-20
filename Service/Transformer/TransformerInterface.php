<?php

namespace TemplateMakerBundle\Service\Transformer;

interface TransformerInterface
{
    public function transform(array $data) : void;
}
