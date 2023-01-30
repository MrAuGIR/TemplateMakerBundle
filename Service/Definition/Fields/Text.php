<?php

namespace TemplateMakerBundle\Service\Definition\Fields;

use Pimcore\Model\DataObject\ClassDefinition\Data\TypeDeclarationSupportInterface;
use Pimcore\Model\ModelInterface;

class Text implements Field
{
    protected array $allowedFields = [
        'input',
        'textarea',
    ];

    public function match(string $fieldClass = ''): bool
    {
        return in_array($fieldClass,$this->allowedFields);
    }

    public function formate(ModelInterface $object, TypeDeclarationSupportInterface $data, array $languages): array
    {
        $getter = 'get'.$data->getName();
        return [
            $data->getName() => [
                'type' => 'text',
                'value' => $object->$getter() ?? null
            ]
        ];
    }
}
