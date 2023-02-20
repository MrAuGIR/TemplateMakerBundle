<?php

namespace TemplateMakerBundle\Service\Transformer;

use TemplateMakerBundle\Model\DataObject\Template;

class Dispatcher
{
    public function getTemplate(array $data) : Template {

        $id = $data['id'] ?? null;

        if (empty($template = Template::getById($id))) {
            $template = new Template();
        }
        return $template;
    }

    public function dispatch(array $data) : void {

    }
}
