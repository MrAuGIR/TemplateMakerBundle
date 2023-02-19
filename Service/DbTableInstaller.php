<?php

namespace TemplateMakerBundle\Service;

use Pimcore\Db;
use Symfony\Component\Yaml\Yaml;

class DbTableInstaller
{
    public function __construct(
      private Tool $tool
    ){}

    public function installTables() : void {
        $query = "CREATE TABLE IF NOT EXISTS `%s` (%s) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        $tableConf =  Yaml::parseFile($this->tool->getInstallTableConfig());

        foreach ($tableConf['definitions'] as $tableName => $columns) {
            $data = [];

            foreach ($columns as $param => $definition) {
                $data[] = "`$param` $definition";
            }

            $params = implode(",", $data);

            $stmt = Db::getConnection()->prepare(sprintf($query, $tableName, $params));
            $stmt->execute();
        }
    }
}
