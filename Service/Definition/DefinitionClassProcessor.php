<?php

namespace TemplateMakerBundle\Service\Definition;

use Pimcore\Model\DataObject\ClassDefinition\Data\TypeDeclarationSupportInterface;
use Pimcore\Tool;
use Pimcore\Model\ModelInterface;
use Pimcore\Model\DataObject\ClassDefinition;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use TemplateMakerBundle\Service\Definition\Fields\Field;

class DefinitionClassProcessor
{
    /** @var Field[] */
    private iterable $fields;
    private array $cacheFieldDefinition;

    private array $languages;

    public function __construct(#[TaggedIterator('class.definition.field')] iterable $fields)
    {
        $this->cacheFieldDefinition = [];
        $this->languages = Tool::getValidLanguages();
    }

    public function process(ClassDefinition $definition, ?ModelInterface $object) : array {
        $fields = [];
        foreach ($definition->getFieldDefinitions() as $fieldDefinition) {
            $field = $this->extractDataFromField($fieldDefinition, $object);
            if (!empty($field)) {
                $fields[] = $field;
            }
        }
        return $fields;
    }

    private function extractDataFromField(ClassDefinition\Data $definition, ?ModelInterface $object) : array {

        $type = $definition->getFieldtype();

        if (isset($this->cacheFieldDefinition[$type])) {
            return $this->cacheFieldDefinition[$type]->extract($definition,$object,$this->languages);
        }

        foreach ($this->fields as $field) {

            if (!$field->match($type)) {
                continue;
            }

            $this->cacheFieldDefinition[$type] = $field;
            return $this->cacheFieldDefinition[$type]->extract(data: $definition,object: $object,languages: $this->languages);
        }
        return [];
    }
}
