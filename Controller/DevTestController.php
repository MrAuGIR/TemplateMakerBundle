<?php

namespace TemplateMakerBundle\Controller;

use ActiveWireframeBundle\Model\Elements;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TemplateMakerBundle\Model\DataObject\Element;

class DevTestController extends FrontendController
{
    /**
     * @Route("/template_maker")
     */
    public function indexAction(Request $request)
    {

        $list = new Element\Listing();
        $list->setCondition("template_id = ?", [1]);
        $elements = $list->load();

        dd($elements);


        return new Response('Hello world from template_maker');
    }
}
