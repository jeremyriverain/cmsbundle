<?php

namespace Geekco\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/admin")
 */
class CmsController extends Controller
{
    /**
     * @Route("/", name="geekco_cms_admin")
     */
    public function index()
    {
        return $this->render('@GeekcoCms/index.html.twig', [
                
        ]);
    }
}
