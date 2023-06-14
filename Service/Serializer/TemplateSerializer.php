<?php

namespace TemplateMakerBundle\Service\Serializer;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use TemplateMakerBundle\Model\DataObject\Element;
use TemplateMakerBundle\Model\DataObject\Template;

class TemplateSerializer
{
    public function __construct(
        private ElementSerializer $elementSerializer
    ){}

    /**
     * @param Template $template
     * @return string
     */
    public function serialize(Template $template) : string {
        return json_encode($this->formateData($template));
    }

    /**
     * @param Template $template
     * @return array
     */
    public function formateData(Template $template) : array {
        return [
            'id' => $template->getId(),
            'name' => $template->getName(),
            'class' => $template->getClass(),
            'elements' => $this->getElementsFormate($template->getElements())
        ];
    }

    /**
     * @param Element[] $elements
     * @return array
     */
    private function getElementsFormate(array $elements) : array {
        $return = [];
        foreach ($elements as $element) {
            $return[] = $this->elementSerializer->formateData($element);
        }
        return $return;
    }
}
