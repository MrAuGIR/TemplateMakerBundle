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

        $element = Element::getById(1);

        dd($element);


        return new Response('Hello world from template_maker');
    }
}
