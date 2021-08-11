<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends FrontendController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function defaultAction(Request $request)
    {
        return $this->redirect('/admin');
    }
    
    /**
     * @Template
     * @param Request $request
     * @return array
     */
    public function contentAction(Request $request)
    {
        return [];
    }
}
