<?php

namespace TemplateMakerBundle\Model\DataObject;

use Pimcore\Model\AbstractModel;
use Pimcore\Model\Exception\NotFoundException;

class Element extends AbstractModel
{
    public ?int $id;

    public ?int $templateId;

    public ?string $field;

    public ?array $positions;

    public ?string $styles;

    public ?string $filter;

    public ?string $type;

    public ?string $dataTransformer;

    /**
     * get Element by id
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
            \Pimcore\Logger::warn("Element with id $id not found");
        }
        return null;
    }

    /**
     * @param int $id
     * @return self|null
     */
    public static function getByTemplateId(int $id) : ?self {
        try {
            $obj = new self;
            $obj->getDao()->getByTemplateId($id);
            return $obj;
        } catch (NotFoundException $ex) {
            \Pimcore\Logger::warn("Element with id $id not found");
        }
        return null;
    }

    public function getId() : ?int {
        return $this->id ?? null;
    }

    public function setId(?int $id) : self {
        $this->id = $id;
        return $this;
    }

    public function getField() : ?string {
        return $this->field;
    }

    public function getPositions() : ?array {
        return $this->positions;
    }

    public function setPositions(?array $position) : self {
        $this->positions = $position;
        return $this;
    }

    public function getStyles() : ?string {
        return $this->styles;
    }

    public function setStyles(?string $styles) : self {
        $this->styles = $styles;
        return $this;
    }

    public function getType() : ?string {
        return $this->type;
    }

    public function setField(string $field) : self {
        $this->field = $field;
        return $this;
    }

    public function setType(?string $type) : self {
        $this->type = $type;
        return $this;
    }

    public function getFilter() : ?string {
        return $this->filter;
    }

    public function setFilter(?string $filter) : self {
        $this->filter = $filter;
        return $this;
    }

    public function getData_transformer() : ?string {
        return $this->dataTransformer;
    }

    public function setData_transformer(?string $transformer) : self {
        $this->dataTransformer = $transformer;
        return $this;
    }

    public function getTemplate_id() : ?int {
        return $this->templateId;
    }

    public function setTemplate_id(?int $id) : self {
        $this->templateId = $id;
        return $this;
    }
}
