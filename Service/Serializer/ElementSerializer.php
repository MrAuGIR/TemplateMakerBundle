<?php

namespace TemplateMakerBundle\Service\Serializer;

use TemplateMakerBundle\Model\DataObject\Element;

class ElementSerializer
{
    /**
     * @param Element $element
     * @return string
     */
    public function serialize(Element $element) : string {
        return json_encode($this->formateData($element));
    }

    /**
     * @param Element $element
     * @return array
     */
    public function formateData(Element $element) : array {
        return [
            'field' => $element->getField(),
            'filter' => $element->getFilter(),
            'type' => $element->getType(),
            'position' => json_decode($element->getPositions(),true),
            'style' => $element->getStyles()
        ];
    }
}
