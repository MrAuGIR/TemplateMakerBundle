<?php

namespace TemplateMakerBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefinitionTemplateController extends \Pimcore\Controller\FrontendController
{
    #[Route("/template/template/{id}" ,name: "template_template_id", methods: ["GET"])]
    public function getTemplateDefinition(int $id, Request $request) : JsonResponse {

        return $this->json([],200);
    }

    #[Route("/template/list/template", name: "template_list_template", methods: ["GET"])]
    public function getListTemplateDefinition(Request $request) : JsonResponse {

        return $this->json([],200);
    }

    #[Route("/template/create", name: "template_create_definition", methods: ["POST"])]
    public function createNewTemplateDefinition(Request $request) : JsonResponse {

        return $this->json([],200);
    }
}
