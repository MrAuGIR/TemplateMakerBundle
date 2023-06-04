<?php

namespace TemplateMakerBundle\Service\Transformer;

use Pimcore\Model\AbstractModel;
use TemplateMakerBundle\Model\DataObject\Element;

class ElementTransformer implements TransformerInterface
{
    protected AbstractModel $model;
    /**
     * @param array $data
     * @return void
     */
    public function transform(array $data): void
    {
        $this->setModel(new Element());
        $this->hydrateModel($data);
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

    private function hydrateModel(array $data) : void {

        $this->model->setValues([
            'field' => $data['field'],
            'filter' => $data['filter'] ?? '',
            'type' => $data['type'],
            'style' => $data['style'],
            'position' => json_encode($data['position'], true)
        ]);

        if (isset($data['template_id']) ) {
            $this->model->setTemplate_id($data['template_id']);
        }
    }
}
