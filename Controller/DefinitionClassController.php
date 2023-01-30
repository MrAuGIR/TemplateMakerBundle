<?php

namespace TemplateMakerBundle\Controller;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\ModelInterface;
use Symfony\Component\HttpFoundation;
use Pimcore\Controller\FrontendController;
use Symfony\Component\Routing\Annotation\Route;
use TemplateMakerBundle\Exception\ClassNotFoundException;
use TemplateMakerBundle\Service\Definition\ClassDefinitionManager;

class DefinitionClassController extends FrontendController
{
    private array $data;
    #[Route("/template/list/class", name: "template_maker_list_class", methods: ["GET"])]
    public function getListClass(HttpFoundation\Request $request) : HttpFoundation\JsonResponse {

        $list = ClassDefinitionManager::getClassList();

        return $this->json(['classes' => $list],200);
    }

    #[Route("/template/class/{id}", name: "template_maker_get_definition_class", methods: ["GET"])]
    public function getDefinitionClass(string $id, HttpFoundation\Request $request) : HttpFoundation\JsonResponse {
        $object = DataObject::getById(2);
        try {
            $class = ClassDefinitionManager::getClassDefinition($id);

            foreach ($class->getFieldDefinitions() as $definition) {
                $this->processDefinition($definition,$object);
            }


        }catch (ClassNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()],404);
        }

        return $this->json([],200);
    }

    private function processDefinition(ClassDefinition\Data $definition, ModelInterface $object) : void {
        $this->data[] = $this->extractData($definition,$object);
    }

    private function extractData(ClassDefinition\Data $definition, ModelInterface $object) : array {

        $getter = 'get'. $definition->getName();

        if (!$values = $object->$getter()) {
            return [];
        }

        foreach ($values->getItems() as $fc) {
            $fields = [];
            foreach ($fc->getDefinition()->getFieldDefinitions() as $definition) {

                $fields[] = $definition;
            }
            $result[$fc->getFieldName()][] = array_merge([], ...$fields);
        }
        dd($result);

    }
}
