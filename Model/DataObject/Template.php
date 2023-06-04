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
     * @var Element[]
     */
    public array $elements;

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

    /**
     * @return int|null
     */
    public function getId() : ?int {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id) : self {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass() : string {
        return $this->class;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setClass(string $class) : self {
        $this->class = $class;
        return $this;
    }

    /**
     * @return Element[]
     */
    public function getElements() : array {
        return $this->elements;
    }

    /**
     * @param Element[] $elements
     * @return $this
     */
    public function setElements(array $elements) : self {
        $this->elements = $elements;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name) : self {
        $this->name = $name;
        return $this;
    }

}
