<?php

namespace TemplateMakerBundle\Service\Definition\Fields;

use Pimcore\Model\DataObject\ClassDefinition\Data\TypeDeclarationSupportInterface;
use Pimcore\Model\ModelInterface;
use Pimcore\Tool;

class Image implements Field
{
    private const TYPE = "image";

    private string $baseUrl;

    public function __construct(){
        $this->baseUrl = Tool::getHostUrl();
    }

    public function match(string $fieldClass = ''): bool
    {
        return static::TYPE === $fieldClass;
    }

    public function extract(TypeDeclarationSupportInterface $data, ?ModelInterface $object, array $languages = []): array
    {
        $name = $data->getName();
        $getter = 'get'.$name;

        return [ $name => [
                'type' => static::TYPE,
                'id' => $object?->getId(),
                'path' => $this->baseUrl. $object?->$getter()?->getFullPath() ?? ''
            ]
        ];
    }
}
