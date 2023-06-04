<?php

namespace TemplateMakerBundle\Service\Definition;

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

    /**
     * @param iterable $fields
     */
    public function __construct(#[TaggedIterator('class.definition.field')] iterable $fields)
    {
        $this->fields = $fields;
        $this->cacheFieldDefinition = [];
        $this->languages = Tool::getValidLanguages();
    }

    /**
     * @param ClassDefinition $definition
     * @param ModelInterface|null $object
     * @return array
     */
    public function process(ClassDefinition $definition, ?ModelInterface $object) : array {
        $fields = [];
        foreach ($definition->getFieldDefinitions() as $fieldDefinition) {
            $field = $this->extractDataFromField($fieldDefinition, $object);

            if (!empty($field)) {
                $fields = array_merge($fields,$field);
            }
        }
        return $fields;
    }

    /**
     * @param ClassDefinition\Data $definition
     * @param ModelInterface|null $object
     * @return array
     */
    public function extractDataFromField(ClassDefinition\Data $definition, ?ModelInterface $object) : array {

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
