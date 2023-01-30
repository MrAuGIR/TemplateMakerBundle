<?php

namespace TemplateMakerBundle\Controller;

use Symfony\Component\HttpFoundation;
use Pimcore\Controller\FrontendController;
use Symfony\Component\Routing\Annotation\Route;
use TemplateMakerBundle\Exception\ClassNotFoundException;
use TemplateMakerBundle\Service\Definition\ClassDefinitionManager;

class DefinitionClassController extends FrontendController
{
    #[Route("/template/list/class", name: "template_maker_list_class", methods: ["GET"])]
    public function getListClass(HttpFoundation\Request $request) : HttpFoundation\JsonResponse {

        $list = ClassDefinitionManager::getClassList();

        return $this->json(['classes' => $list],200);
    }

    #[Route("/template/class/{id}", name: "template_maker_get_definition_class", methods: ["GET"])]
    public function getDefinitionClass(string $id, HttpFoundation\Request $request) : HttpFoundation\JsonResponse {

        try {
            $class = ClassDefinitionManager::getClassDefinition($id);
        }catch (ClassNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()],404);
        }

        return $this->json([],200);
    }
}
