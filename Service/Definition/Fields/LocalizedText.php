<?php

namespace TemplateMakerBundle\Service\Definition\Fields;

use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\ClassDefinition\Data\TypeDeclarationSupportInterface;
use Pimcore\Model\ModelInterface;
use TemplateMakerBundle\Service\Definition\DefinitionClassProcessor;

class LocalizedText implements Field
{
    private const TYPE = "localizedfields";

    public function __construct(private DefinitionClassProcessor $processor){}

    public function match(string $fieldClass = ''): bool
    {
        return static::TYPE === $fieldClass;
    }

    public function extract(TypeDeclarationSupportInterface $data, ?ModelInterface $object, array $languages = []): array
    {
        $localizedData = [];
        $fields = [];
        foreach ($data->getChildren() as $child) {
            $localizedData[] = $this->valuesByLanguages($child,$object,$languages);
        }
        $localizedData[] = array_merge(...$localizedData);

        foreach ($data->getReferencedFields() as $field) {
            $fields[] = $this->processor->extractDataFromField($field,$object);
        }

        return array_merge($localizedData, ...$fields);
    }

    private function valuesByLanguages(Data $data, ?ModelInterface $object, array $languages) : array {
        $localized = [];
        $name = $data->getName();
        $getter = 'get'.$name;

        foreach ($languages as $locale) {
            $value = $object?->$getter($locale) ?? '';
            $localized[$name][$locale] = $value;
        }
        return $localized;
    }
}
