<?php

namespace Geekco\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Geekco\CmsBundle\Entity\Menu;
use Geekco\CmsBundle\Form\MenuType;
use Geekco\CmsBundle\Entity\Page;

/**
 * @Route("/admin/menu")
 */
class MenuController extends Controller
{
    /**
     * @Route("/{name}", name="geekco_cms_menu_update")
     * @Method({"POST", "GET"})
     */
    public function update(Request $request, Menu $menu)
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository(Page::class)->findAll();

        if($form->isSubmitted())
        {
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Les changements ont été enregistrés.');
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }
        }

        return $this->render('@geekco_cms/menu/update.html.twig', [
            'form' => $form->createView(),
            'pages' => $pages
        ]);
    }

}
