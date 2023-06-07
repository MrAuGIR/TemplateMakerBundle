<?php

namespace TemplateMakerBundle\Service\Transformer;

use Pimcore\Model\AbstractModel;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TemplateMakerBundle\Exception\Validator\ElementValidationException;
use TemplateMakerBundle\Exception\Validator\TemplateValidationException;
use TemplateMakerBundle\Model\DataObject\Template;

class TemplateTransformer implements TransformerInterface
{
    private AbstractModel $model;

    /**
     * @param ElementTransformer $elementTransformer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private ElementTransformer $elementTransformer,
        private ValidatorInterface $validator
    ){}


    /**
     * @param array $data
     * @return void
     * @throws TemplateValidationException
     */
    public function transform(array $data): void
    {
        $this->model = $this->getOrCreate($data['name']);
        $this->model
            ->setValue('name',$data['name'])
            ->setValue('class', $data['class']);

        // validation de l'objet
        $errors = $this->validator->validate($this->model);
        if (count($errors)>0) {
            $errorsString = (string) $errors;
            throw new TemplateValidationException($errorsString);
        }

        $this->model->save();

        if (!empty($elements = $data["elements"])) {
            $this->model->getDao()->removeElements($this->model->getId());
            $this->model->setValue('elements',$this->transformElements($elements));
        }

        $this->model->save();
    }

    /**
     * @param array $elements
     * @return array
     * @throws ElementValidationException
     */
    private function transformElements(array $elements) : array {
        $return = [];
        foreach ($elements as $element) {
            $element['template_id'] = $this->model->getId();
            $this->elementTransformer->transform($element);
            $return[] = $this->elementTransformer->getModel();
        }
        return $return;
    }

    /**
     * @return AbstractModel
     */
    public function getModel(): AbstractModel {
        return $this->model;
    }

    /**
     * @param AbstractModel $model
     * @return TransformerInterface
     */
    public function setModel(AbstractModel $model): TransformerInterface {
        $this->model = $model;
        return $this;
    }

    /**
     * @param string $name
     * @return Template
     */
    private function getOrCreate(string $name) : Template {
        if (empty($template = Template::getByName($name))) {
            $template = new Template();
            $template->setId(null);
        }
        return $template;
    }
}
