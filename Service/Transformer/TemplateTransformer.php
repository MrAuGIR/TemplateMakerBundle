<?php

namespace TemplateMakerBundle\Service\Transformer;

use Pimcore\Model\AbstractModel;
use TemplateMakerBundle\Model\DataObject\Template;

class TemplateTransformer implements TransformerInterface
{
    private AbstractModel $model;
    /**
     * @param ElementTransformer $elementTransformer
     */
    public function __construct(
        private ElementTransformer $elementTransformer
    ){}


    /**
     * @param array $data
     * @return void
     */
    public function transform(array $data): void
    {
        $this->setModel(new Template());
        $this->model->setId(null); // create

        $this->model->setValue('name',$data['name'])
            ->setValue('class', $data['class']);

        $this->model->save();

        /**
         * @todo setter le nouvel id du template sur les elements
         */
        if (!empty($elements = $data["elements"])) {
            $this->model->setValue('elements',$this->transformElements($elements));
        }

        $this->model->save();
    }

    /**
     * @param array $elements
     * @return array
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
}
