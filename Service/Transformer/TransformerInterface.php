<?php

namespace TemplateMakerBundle\Service\Transformer;

use Pimcore\Model\AbstractModel;

interface TransformerInterface
{
    /**
     * @return AbstractModel
     */
    public function getModel() : AbstractModel;

    /**
     * @param AbstractModel $model
     * @return self
     */
    public function setModel(AbstractModel $model) : self;

    /**
     * @param array $data
     * @return void
     */
    public function transform(array $data) : void;
}
