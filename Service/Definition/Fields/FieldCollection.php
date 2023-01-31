<?php

namespace TemplateMakerBundle\Service\Definition\Fields;

use Pimcore\Model\DataObject\ClassDefinition\Data\TypeDeclarationSupportInterface;
use Pimcore\Model\ModelInterface;

class FieldCollection implements Field
{

    public function match(string $fieldClass = ''): bool
    {
        // TODO: Implement match() method.
    }

    public function extract(TypeDeclarationSupportInterface $data, ?ModelInterface $object, array $languages = []): array
    {
        // TODO: Implement extract() method.
    }
}
