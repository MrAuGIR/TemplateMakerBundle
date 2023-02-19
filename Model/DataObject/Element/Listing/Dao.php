<?php

namespace TemplateMakerBundle\Model\DataObject\Element\Listing;

use Doctrine\DBAL\Query\QueryBuilder;
use Pimcore\Model\Listing\Dao\AbstractDao;
use Pimcore\Model\Listing\Dao\QueryBuilderHelperTrait;
use TemplateMakerBundle\Model\DataObject\Element;

class Dao extends AbstractDao
{
    use QueryBuilderHelperTrait;

    protected string $tableName = "template_maker_element";

    protected int $totalCount;

    public function getTableName() : string {
        return $this->tableName;
    }

    public function getQueryBuilder() : ?QueryBuilder {
        $queryBuilder = $this->db->createQueryBuilder();
        $field = $this->getTableName().'.id';
        $queryBuilder->select([sprintf('SQL_CALC_FOUND_ROWS %s as id', $field)]);
        $queryBuilder->from($this->getTableName());

        $this->applyListingParametersToQueryBuilder($queryBuilder);

        return $queryBuilder;
    }

    /**
     * @inheritDoc
     */
    public function load()
    {
        // load id's
        $list = $this->loadIdList();

        $objects = array();
        foreach ($list as $o_id) {
            if ($object = Element::getById($o_id)) {
                $objects[] = $object;
            }
        }
        $this->model->setData($objects);

        return $objects;
    }

    public function loadIdList() : array {
        $query = $this->getQueryBuilder();

        $objectIds = $this->db->fetchFirstColumn((string) $query, $this->model->getConditionVariables(), $this->model->getConditionVariableTypes());
        $this->totalCount = (int) $this->db->fetchOne('SELECT FOUND_ROWS()');

        return array_map('intval', $objectIds);
    }

    /**
     * Get Count.
     *
     * @return int
     *
     * @throws \Exception
     */
    public function getCount() : int {
        if ($this->model->isLoaded()) {
            return count($this->model->getData());
        } else {
            $idList = $this->loadIdList();

            return count($idList);
        }
    }

    /**
     * @inheritDoc
     */
    public function getTotalCount() : int {
        $queryBuilder = $this->getQueryBuilder();
        $this->prepareQueryBuilderForTotalCount($queryBuilder, $this->getTableName() . '.id');

        $totalCount = $this->db->fetchOne((string) $queryBuilder, $this->model->getConditionVariables(), $this->model->getConditionVariableTypes());

        return (int) $totalCount;
    }
}
