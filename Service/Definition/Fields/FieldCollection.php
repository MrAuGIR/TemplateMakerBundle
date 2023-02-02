<?php

namespace TemplateMakerBundle\Service\Definition\Fields;

use Pimcore\Model\DataObject\ClassDefinition\Data\TypeDeclarationSupportInterface;
use Pimcore\Model\ModelInterface;
use TemplateMakerBundle\Service\Definition\DefinitionClassProcessor;

class FieldCollection implements Field
{
    public function __construct(private DefinitionClassProcessor $processor){}
    public static string $classSupported = 'fieldcollections';

    public function match(string $fieldClass = ''): bool
    {
        return static::$classSupported === $fieldClass;
    }

    public function extract(TypeDeclarationSupportInterface $data, ?ModelInterface $object, array $languages = []): array
    {
        $getter = 'get'. $data->getName();

        if (!$values = $object?->$getter()) {
            return [];
        }

        $return = [];
        foreach ($values->getItems() as $item) {
            $fields = [];
            foreach ($item->getDefinition()->getFieldDefinitions() as $definition) {

                $field = $this->processor->extractDataFromField($definition,$item);

                if (!empty($field)) {
                    $fields[] = $field;
                }
            }
            $return[$item->getFieldName()] = $fields;
        }
        return $return;
    }
}
