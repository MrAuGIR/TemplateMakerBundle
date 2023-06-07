<?php

namespace TemplateMakerBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use TemplateMakerBundle\Exception\TemplateNotFoundException;
use TemplateMakerBundle\Model\DataObject\Template;
use TemplateMakerBundle\Service\Serializer\TemplateSerializer;
use TemplateMakerBundle\Service\Transformer\Dispatcher;

class DefinitionTemplateController extends FrontendController
{
    /**
     * @param Dispatcher $dispatcher
     * @param TemplateSerializer $serializer
     */
    public function __construct(
        private Dispatcher $dispatcher,
        private TemplateSerializer $serializer
    ){}

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("/template/template/{id}" ,name: "template_template_id", methods: ["GET"])]
    public function getTemplateDefinition(int $id, Request $request) : JsonResponse {
        try {
            if (empty($template = Template::getById($id))) {
                throw new TemplateNotFoundException(sprintf("Template with %s not found",$id));
            }
            $data = $this->serializer->serialize($template);

        } catch (TemplateNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()],404);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()],500);
        }

        return new JsonResponse($data,200,[],true);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("/template/list/template", name: "template_list_template", methods: ["GET"])]
    public function getListTemplateDefinition(Request $request) : JsonResponse {
        $data = [];
        $list = new Template\Listing();
        $list->load();

        try {
            foreach ($list as $template) {
                $data[] = $this->serializer->formateData($template);
            }
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()],500);
        }
        return $this->json($data,200);
    }


    /**
     * @param Request $request
     * @param string|null $name
     * @return JsonResponse
     */
    #[Route("/template/update/{name}", name: "template_update_definition", methods: ["PUT"])]
    #[Route("/template/create", name: "template_create_definition", methods: ["POST"])]
    public function createNewTemplateDefinition(Request $request, ?string $name) : JsonResponse {
        try {
            $data = $request->getContent();
            if (empty($data = json_decode($data,true))) {
                throw new \JsonException("Invalid Json Format exception");
            }

            $this->dispatcher->dispatch($data);

        }catch(\Exception $e) {
            return $this->json(['error' => $e->getMessage()],500);
        }

        return $this->json(['message' => ""],200);
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
