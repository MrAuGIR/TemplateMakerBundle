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


    #[Route("/template/update/{name}", name: "template_update_definition", methods: ["PUT"])]
    #[Route("/template/create", name: "template_create_definition", methods: ["POST"])]
    public function createNewTemplateDefinition(Request $request, ?string $name) : JsonResponse {

        $data = $request->getContent();
        $data = json_decode($data,true);

        $this->dispatcher->dispatch($data);

        return $this->json([],200);
    }

    /**
     * @param string $name
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("/template/delete/{name}", name: "template_delete_definition", methods: ['DELETE'])]
    public function deleteTemplateDefinition(string $name, Request $request) : JsonResponse {

        try {
            if (!empty($template = Template::getByName($name))) {
                $template->getDao()->delete();
            }
        }catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()],500);
        }
        return $this->json(['message' => sprintf("Template with %s deleted ",$template->getId())],200);
    }
}
