<?php

namespace TemplateMakerBundle\Model\DataObject;

use Pimcore\Model\AbstractModel;
use Pimcore\Model\Exception\NotFoundException;

class Template extends AbstractModel
{
    public ?int $id;

    public string $class;

    public string $name;

    /**
     * get Template by id
     *
     * @param int $id
     * @return null|self
     */
    public static function getById(int $id) : ?self {
        try {
            $obj = new self;
            $obj->getDao()->getById($id);
            return $obj;
        }
        catch (NotFoundException $ex) {
            \Pimcore\Logger::warn("Template with id $id not found");
        }
        return null;
    }

    public function getId() : ?int {
        return $this->id;
    }

    public function setId(?int $id) : self {
        $this->id = $id;
        return $this;
    }

    public function getClass() : string {
        return $this->class;
    }

    public function setClass(string $class) : self {
        $this->class = $class;
        return $this;
    }




}
