<?php

namespace TemplateMakerBundle\Service\Definition\Fields;

use Pimcore\Model\DataObject\ClassDefinition\Data\TypeDeclarationSupportInterface;
use Pimcore\Model\ModelInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('class.definition.field')]
interface Field
{
    public function match(string $fieldClass = '') : bool;

    public function formate(ModelInterface $object, TypeDeclarationSupportInterface $data, array $languages) : array;
}
