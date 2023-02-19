<?php

namespace TemplateMakerBundle\Service;

use Pimcore;
use TemplateMakerBundle\TemplateMakerBundle as ThisBundle;

class Tool
{
    CONST INSTALL_CLASSES_DIR = 'Resources/Install/classes/';

    CONST INSTALL_TABLE_CONFIG = "Resources/Install/tables/definitions.yaml";

    public function getBundlePath() : ?string {
        return  Pimcore::getContainer()->get("kernel")?->locateResource("@" . ThisBundle::BUNDLE_ID);
    }

    public function getInstallClassDir() : ?string {
        return $this->getBundlePath() . self::INSTALL_CLASSES_DIR;
    }

    public function getInstallTableConfig() : ?string {
        return $this->getBundlePath() . self::INSTALL_TABLE_CONFIG;
    }
}
