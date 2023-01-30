<?php

namespace TemplateMakerBundle\Service\Definition;

use Pimcore\Tool;
use Pimcore\Model\DataObject\ClassDefinition;
use TemplateMakerBundle\Exception\ClassNotFoundException;

class ClassDefinitionManager
{
    /**
     * @return array
     */
    public static function getClassList() : array {
        $list = new ClassDefinition\Listing();
        $return = [];
        foreach ($list as $class) {
            $return[] = [
                'id' => $class->getId(),
                'name' => $class->getName(),
                'description' => $class->getDescription(),
                'url' => Tool::getHostUrl('http')."/template/class/".$class->getId()
            ];
        }
        return $return;
    }

    /**
     * @param string $id
     * @return ClassDefinition|null
     * @throws \Exception
     */
    public static function getClassDefinition(string $id) : ?ClassDefinition {

        $class = ClassDefinition::getById($id);
        if(empty($class)) {
            throw new ClassNotFoundException("Class with id ".$id." not found");
        }

        return $class;
    }
}
