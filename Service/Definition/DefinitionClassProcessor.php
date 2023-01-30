<?php

namespace TemplateMakerBundle\Service\Definition;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class DefinitionClassProcessor
{
    public function __construct(#[TaggedIterator('class.definition.field')] iterable $fields)
    {

    }
}
