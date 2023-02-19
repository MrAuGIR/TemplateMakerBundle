<?php

namespace TemplateMakerBundle\Service;

use Pimcore\Db;
use Pimcore\Model\User\Permission\Definition;
use Pimcore\Extension\Bundle\Installer\AbstractInstaller;
use TemplateMakerBundle\TemplateMakerBundle as ThisBundle;

class Installer extends AbstractInstaller
{
    public function __construct(
        private DbTableInstaller $dbTableInstaller
    ){}

    /**
     * @return bool
     * @throws \Doctrine\DBAL\Exception
     */
    public function isInstalled() : bool {
        $db = Db::get();
        $check = $db->fetchOne('SELECT `key` FROM users_permission_definitions where `key` = ?', [ThisBundle::BUNDLE_EDIT_PERMISSION]);

        return (bool)$check;
    }

    public function canBeInstalled() : bool {
        return !$this->isInstalled();
    }

    public function needsReloadAfterInstall() : bool {
        return true;
    }

    public function install() : bool {

        $this->createTableDatabase();

        Definition::create(ThisBundle::BUNDLE_VIEW_PERMISSION);
        Definition::create(ThisBundle::BUNDLE_EDIT_PERMISSION);
        Definition::create(ThisBundle::BUNDLE_ADMIN_PERMISSION);

        return true;
    }

    private function createTableDatabase() : void {
        $this->dbTableInstaller->installTables();
    }
}
