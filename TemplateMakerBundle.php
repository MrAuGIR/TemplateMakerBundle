<?php

namespace TemplateMakerBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class TemplateMakerBundle extends AbstractPimcoreBundle
{
    public function getJsPaths()
    {
        return [
            '/bundles/templatemaker/js/pimcore/startup.js'
        ];
    }
}