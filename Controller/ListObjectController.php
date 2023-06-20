<?php

namespace TemplateMakerBundle\Controller;

use Pimcore\Db;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ListObjectController extends \Pimcore\Controller\FrontendController
{
    #[Route("/template/list/object/{className}", name: "template_list_object_by_class", methods: ["GET"])]
    public function getListIdByClass(string $className) : JsonResponse {

        $result = $this->getElementsIdByClass($className);

        return new JsonResponse(['ids' => $result],200,[],false);
    }

    /**
     * @param string $class
     * @return array
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    private function getElementsIdByClass(string $class) : array {
        $db = Db::get();

        $sql = "SELECT o.o_id FROM objects as o WHERE o.o_className = :className";
        $stmt =$db->prepare($sql);
        $stmt->bindParam('className',$class,\PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchFirstColumn();
    }
}
