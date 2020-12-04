<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends FrontendController
{
    /**
     * @Template
     * @param Request $request
     * @return array
     */
    public function defaultAction(Request $request)
    {
        return [];
    }

    /**
     * @Route("/examples", name="examples")
     *
     * @param Request $request
     * @return Response
     */
    public function examplesAction(Request $request)
    {
        return [];
    }
}
