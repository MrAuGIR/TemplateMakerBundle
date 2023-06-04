<?php

namespace TemplateMakerBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use TemplateMakerBundle\Model\DataObject\Template;
use TemplateMakerBundle\Service\Transformer\Dispatcher;

class DefinitionTemplateController extends FrontendController
{
    public function __construct(
        private Dispatcher $dispatcher
    ){}

    #[Route("/template/template/{id}" ,name: "template_template_id", methods: ["GET"])]
    public function getTemplateDefinition(int $id, Request $request) : JsonResponse {

        $template = Template::getById($id);

        dd($template->getElements());

        return $this->json([$template->getElements()],200);
    }

    #[Route("/template/list/template", name: "template_list_template", methods: ["GET"])]
    public function getListTemplateDefinition(Request $request) : JsonResponse {

        return $this->json([],200);
    }

    #[Route("/template/create", name: "template_create_definition", methods: ["POST","GET"])]
    public function createNewTemplateDefinition(Request $request) : JsonResponse {


        $data = [
            "name" => "product14page",
            "class" => "Pimcore\Model\DataObject\Product",
            "elements" => [
                0 => [
                    "field" => "description",
                    "filter" => "raw",
                    "type" => "text",
                    "position" => [
                        'top' => "15mm",
                        'left' => "5mm",
                        'width' => "30mm",
                        'height' => "25mm"
                    ],
                    "style" => "font-size:12pt; font-weight:800"
                ],
                1 => [
                    "field" => "poids",
                    "filter" => null,
                    "type" => "numeric",
                    "position" => [
                        'top' => "1mm",
                        'left' => "5mm",
                        'width' => "11mm",
                        'height' => "11mm"
                    ],
                    "style" => "font-size:8pt; font-weight:400"
                ],
                2 => [
                    "field" => "mainPicture",
                    "type" => "image",
                    "position" => [
                        'top' => "15mm",
                        'left' => "25mm",
                        'width' => "25mm",
                        'height' => "25mm"
                    ],
                    "style" => ""
                ]
            ]
        ];

        $this->dispatcher->dispatch($data);

        return $this->json([],200);
    }
}
