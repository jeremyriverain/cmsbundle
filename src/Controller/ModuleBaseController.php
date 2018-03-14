<?php

namespace Geekco\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Geekco\CmsBundle\Entity\Module;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/admin/module-de-base")
 * @IsGranted("ROLE_SUPER_ADMIN")
 */
class ModuleBaseController extends Controller
{
    /**
     * @Route("/liste", name="geekco_cms_modulebase_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $modules = $em->getRepository(Module::class)->findBy([
            'isBase' => true
        ]);
        return $this->render('@GeekcoCms/modules-de-base/index.html.twig', [
            'modules' => $modules
        ]);
    }
   
    /**
     * @Route("/new", name="geekco_cms_modulebase_new")
     */
    public function newAction()
    {
        die;
    }
   
    /**
     * @Route("/update/{id}", name="geekco_cms_modulebase_update")
     */
    public function updateAction(Module $module)
    {
        if ($module->getIsBase() !== true )
        {
            throw new AccessDeniedException("Ce module n'est pas un module de base.");

        }
        die;
    }

}

