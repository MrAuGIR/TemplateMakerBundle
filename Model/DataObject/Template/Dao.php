<?php

namespace TemplateMakerBundle\Model\DataObject\Template;

use Doctrine\DBAL\Exception;
use Pimcore\Model\Dao\AbstractDao;
use Pimcore\Model\Exception\NotFoundException;
use TemplateMakerBundle\Model\DataObject\Element;

class Dao extends AbstractDao
{
    protected string $tableName = "template_maker_template";

    protected string $tableElement = "template_maker_element";

    /**
     * @param $id
     * @return void
     * @throws Exception
     */
    public function getById($id = null) : void {

        if ($id != null)  {
            $this->model->setId($id);
        }

        $data = $this->db->fetchAssociative('SELECT * FROM '.$this->tableName.' WHERE id = ?', [$this->model->getId()]);

        if(!$data["id"]) {
            throw new NotFoundException("Object with the ID " . $this->model->getId() . " doesn't exists");
        }

        $this->assignVariablesToModel($data);

        $this->extracteElements($data['id']);
    }

    /**
     * @param string $name
     * @return void
     * @throws Exception
     */
    public function getByName(string $name) : void {

        $this->model->setName($name);

        $data = $this->db->fetchAssociative('SELECT * FROM '.$this->tableName.' WHERE name = ?',[$this->model->getName()]);

        if (empty($data)) {
            throw new NotFoundException("Object with the NAME " . $this->model->getName() . " doesn't exists");
        }
        $this->assignVariablesToModel($data);

        $this->extracteElements($data['id']);
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function removeElements(int $id) : void {
        $this->db->delete($this->tableElement, ["template_id" => $this->model->getId()]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function save() : void {
        $vars = get_object_vars($this->model);

        $buffer = [];

        $validColumns = $this->getValidTableColumns($this->tableName);

        if(count($vars))
            foreach ($vars as $k => $v) {

                if(!in_array($k, $validColumns))
                    continue;

                $getter = "get" . ucfirst($k);

                if(!is_callable([$this->model, $getter]))
                    continue;

                $value = $this->model->$getter();

                if(is_bool($value))
                    $value = (int)$value;

                $buffer[$k] = $value;
            }

        if($this->model->getId() !== null) {
            $this->db->update($this->tableName, $buffer, ["id" => $this->model->getId()]);
            return;
        }

        $this->db->insert($this->tableName, $buffer);
        $this->model->setId($this->db->lastInsertId());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function delete() : void {
        $this->db->delete($this->tableName, ["id" => $this->model->getId()]);
        $this->removeElements($this->model->getId());
    }

    /**
     * @return string
     */
    public function getTableElement() : string {
        return $this->tableElement;
    }

    /**
     * @param array $elementsDao
     * @return array
     */
    private function hydrateElement(array $elementsDao) : array {
        $elements = [];
        foreach ($elementsDao as $element) {
            $elements[] = (new Element())->setValues($element);
        }
        return $elements;
    }

    /**
     * @param $id
     * @return void
     * @throws Exception
     */
    public function extracteElements($id): void
    {
        if (!empty($elements = $this->db->fetchAllAssociative("SELECT * FROM " . $this->tableElement . ' WHERE template_id = ?', [$id]))) {

            $elements = $this->hydrateElement($elements);
            $this->model->setValue('elements', $elements);
        }
    }

}
