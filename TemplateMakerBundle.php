<?php

namespace TemplateMakerBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class TemplateMakerBundle extends AbstractPimcoreBundle
{
    const COMPOSER_PACKAGE_NAME = "mraugir/bundle-template-maker";
    const BUNDLE_ID              = "TemplateMakerBundle";
    const BUNDLE_NAME            = "TemplateMakerBundle";
    const BUNDLE_DESCRIPTION     = "Template maker by MrAuGIR©";
    const BUNDLE_VERSION         = "1.0.0";
    const BUNDLE_REVISION        = 1;
    const PIMCORE_MIN_VERSION    = "10.0.0";
    const PUBLIC_CONFIG_FILE_PATH = PIMCORE_PROJECT_ROOT.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.'templateMakerBundle.yaml';
    const PRIVATE_CONFIG_FILE_PATH = PIMCORE_CONFIGURATION_DIRECTORY.DIRECTORY_SEPARATOR.'templateMakerBundle.yaml';

    const BUNDLE_VIEW_PERMISSION = 'template_maker_view';
    const BUNDLE_EDIT_PERMISSION = 'template_maker_edit';
    const BUNDLE_ADMIN_PERMISSION = 'template_maker_admin';

    public function getJsPaths()
    {
        return [
            '/bundles/templatemaker/js/pimcore/startup.js'
        ];
    }
}
