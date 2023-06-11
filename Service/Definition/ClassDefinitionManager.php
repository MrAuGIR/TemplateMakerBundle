<?php

namespace TemplateMakerBundle\Service\Definition;

use Doctrine\DBAL\Exception;
use Pimcore\Db;
use Pimcore\Tool;
use Pimcore\Model\DataObject\ClassDefinition;
use TemplateMakerBundle\Exception\ClassNotFoundException;
use TemplateMakerBundle\Model\DataObject\Template;

class ClassDefinitionManager
{
    public static array $cacheDefinitions = [];

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
                'url' => Tool::getHostUrl('http')."/template/class/".$class->getId(),
                'numbTemplate' => self::getNumberTemplateLinked($class->getName())
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

        if (isset(static::$cacheDefinitions[$id])) {
            return static::$cacheDefinitions[$id];
        }

        if (empty($class = ClassDefinition::getById($id))) {
            throw new ClassNotFoundException("Class with id ".$id." not found");
        }
        static::$cacheDefinitions[$id] = $class;
        return $class;
    }

    /**
     * @param string $className
     * @return int
     * @throws Exception
     * @todo utiliser une requete preparé
     */
    public static function getNumberTemplateLinked(string $className) : int {
        $listing = new Template\Listing();

        $db = Db::get();
        $data = $db->fetchAllAssociative("SELECT * FROM template_maker_template as tmt WHERE tmt.class LIKE '%$className'");

        return count($data);
    }
}
