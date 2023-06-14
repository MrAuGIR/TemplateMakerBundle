<?php

namespace TemplateMakerBundle\Service\Transformer;

use Pimcore\Model\AbstractModel;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TemplateMakerBundle\Exception\Validator\ElementValidationException;
use TemplateMakerBundle\Model\DataObject\Element;

class ElementTransformer implements TransformerInterface
{
    protected AbstractModel $model;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private ValidatorInterface $validator
    ){}

    /**
     * @param array $data
     * @return void
     * @throws ElementValidationException
     */
    public function transform(array $data): void
    {
        $this->setModel(new Element());
        $this->hydrateModel($data);

        // validation des elements
        $errors = $this->validator->validate($this->model);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            throw new ElementValidationException($errorsString);
        }

        $this->model->save();
    }

    /**
     * @return AbstractModel
     */
    public function getModel(): AbstractModel
    {
        return $this->model;
    }

    /**
     * @param AbstractModel $model
     * @return TransformerInterface
     */
    public function setModel(AbstractModel $model): TransformerInterface
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param array $data
     * @return void
     */
    private function hydrateModel(array $data) : void {

        $this->model->setValues([
            'field' => $data['field'],
            'filter' => $data['filter'] ?? '',
            'type' => $data['type'],
            'style' => $data['style'],
            'positions' => json_encode($data['position'])
        ]);

        if (isset($data['template_id']) ) {
            $this->model->setTemplate_id($data['template_id']);
        }
    }
}
