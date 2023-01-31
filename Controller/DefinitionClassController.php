<?php

namespace TemplateMakerBundle\Controller;

use Pimcore\Model\DataObject;
use Symfony\Component\HttpFoundation;
use Pimcore\Controller\FrontendController;
use Symfony\Component\Routing\Annotation\Route;
use TemplateMakerBundle\Exception\ClassNotFoundException;
use TemplateMakerBundle\Service\Definition\ClassDefinitionManager;
use TemplateMakerBundle\Service\Definition\DefinitionClassProcessor;

class DefinitionClassController extends FrontendController
{
    public function __construct(
      private DefinitionClassProcessor $processor
    ){}

    private array $data;
    #[Route("/template/list/class", name: "template_maker_list_class", methods: ["GET"])]
    public function getListClass(HttpFoundation\Request $request) : HttpFoundation\JsonResponse {

        $list = ClassDefinitionManager::getClassList();

        return $this->json(['classes' => $list],200);
    }

    #[Route("/template/class/{idClass}", name: "template_maker_get_definition_class", methods: ["GET"])]
    #[Route("/template/class/{idClass}/{idObject}", name: "template_maker_get_definition_class_width_data", methods: ["GET"])]
    public function getDefinitionClass(string $idClass,?int $idObject, HttpFoundation\Request $request) : HttpFoundation\JsonResponse {
        $object = ($idObject)? DataObject::getById($idObject) : null;

        try {
            $class = ClassDefinitionManager::getClassDefinition($idClass);

            $data = $this->processor->process($class,$object);


        }catch (ClassNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()],404);
        }

        return $this->json($data,200);
    }
}
