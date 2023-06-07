<?php

namespace TemplateMakerBundle\Service\Transformer;

use TemplateMakerBundle\Exception\Validator\TemplateValidationException;
use TemplateMakerBundle\Model\DataObject\Template;

class Dispatcher
{
    /**
     * @param TemplateTransformer $templateTransformer
     */
    public function __construct(
        private TemplateTransformer $templateTransformer
    ){}

    /**
     * @param array $data
     * @return Template
     */
    public function getTemplate(array $data) : Template {

        $id = $data['id'] ?? null;

        if (empty($template = Template::getById($id))) {
            $template = new Template();
        }
        return $template;
    }

    /**
     * @param array $data
     * @return void
     * @throws TemplateValidationException
     */
    public function dispatch(array $data) : void {

        $this->templateTransformer->transform($data);
    }
}
