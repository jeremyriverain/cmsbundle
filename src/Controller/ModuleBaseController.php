<?php

namespace Geekco\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Geekco\CmsBundle\Entity\Module;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Geekco\CmsBundle\Form\ModuleBaseType;

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
        $modules = $em->getRepository(Module::class)->findBy([ 'isBase' => true ], ['id' => 'DESC']);
        return $this->render('@GeekcoCms/modules-de-base/index.html.twig', [
            'modules' => $modules
        ]);
    }

    /**
     * @Route("/new", name="geekco_cms_modulebase_new")
     */
    public function newAction(Request $request)
    {
        $module = new Module();
        $module->setIsBase(true);

        $form = $this->createForm(ModuleBaseType::class, $module);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "<i class='material-icons'>check</i> Le module a été créé");
            return $this->redirectToRoute("geekco_cms_modulebase_list");
        }

        return $this->render('@GeekcoCms/modules-de-base/new.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/update/{id}", name="geekco_cms_modulebase_update")
     */
    public function updateAction(Module $module, Request $request)
    {
        if ($module->getIsBase() !== true )
        {
            throw new AccessDeniedException("Ce module n'est pas un module de base.");

        }
        $form = $this->createForm(ModuleBaseType::class, $module);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "<i class='material-icons'>check</i> Modifications enregistrées");
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        return $this->render('@GeekcoCms/modules-de-base/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

}

