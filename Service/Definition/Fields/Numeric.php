<?php

namespace TemplateMakerBundle\Service\Definition\Fields;

use Pimcore\Model\DataObject\ClassDefinition\Data\TypeDeclarationSupportInterface;
use Pimcore\Model\ModelInterface;

class Numeric implements Field
{
    private const TYPE = "numeric";

    public function match(string $fieldClass = ''): bool
    {
        return static::TYPE === $fieldClass;
    }

    public function extract(TypeDeclarationSupportInterface $data, ?ModelInterface $object, array $languages = []): array
    {
        $name = $data->getName();
        $getter = 'get'.ucfirst($name);

        return [ $name => [
            'type' => static::TYPE,
            'value' => $object?->$getter() ?? null
        ]];
    }
}
