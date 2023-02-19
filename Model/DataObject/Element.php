<?php

namespace TemplateMakerBundle\Model\DataObject;

use Pimcore\Model\AbstractModel;
use Pimcore\Model\Exception\NotFoundException;

class Element extends AbstractModel
{
    public ?int $id;

    public ?array $positions;

    public ?string $styles;

    public ?string $filter;

    public ?string $type;

    public ?string $dataTransformer;

    /**
     * get score by id
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
            \Pimcore\Logger::warn("Vote with id $id not found");
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

    public function setType(?string $type) : self {
        $this->type = $type;
        return $this;
    }

    public function getFilter() : ?string {
        return $this->filter;
    }

    public function setFiler(?string $filter) : self {
        $this->filter = $filter;
        return $this;
    }

    public function getDataTransformer() : ?string {
        return $this->dataTransformer;
    }

    public function setDataTransformer(?string $transformer) : self {
        $this->dataTransformer = $transformer;
        return $this;
    }
}
