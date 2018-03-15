<?php

namespace Geekco\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Geekco\CmsBundle\Entity\Page;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AppController extends Controller
{
    private function renderAction(Request $request, $slug = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($slug === null) {
            $page = $em->getRepository(Page::class)->getPageWithModules('accueil');
            if (!$page) {
                return $this->render('@GeekcoCms/no-homepage.html.twig', [
                        
                ]);
            }
        } else {
            $page = $em->getRepository(Page::class)->getPageWithModules($slug);
        }

        if (!$page) {
            throw new NotFoundHttpException();
        }

        foreach ($page->getModules() as $m) {
            if ($m->getHasForm() === true) {
                $entityNamespace = $m->getOptions()['form']['entity_namespace'];
                $formNamespace = $m->getOptions()['form']['form_namespace'];

                $entity = new $entityNamespace();

                $formTypeHandlingNamespace = str_replace('Form', 'FormHandling', $formNamespace);

                $formTypeHandling = $this->container->get($formTypeHandlingNamespace);

                $form = $this->createForm($formNamespace, $entity);
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    if ($form->isValid()) {
                        $formTypeHandling->onSuccess($entity);
                        return $this->redirectToRoute('geekco_cms_homepage');
                    }
                }
            }
        }

        $options = ['page' => $page];
        if (isset($form)) {
            $options['form'] = $form->createView();
        }

        return $this->render("@GeekcoCms/page.html.twig", $options);
    }

    /**
     * @Route("/", name="geekco_cms_homepage")
     */
    public function homepageAction(Request $request)
    {
        return $this->renderAction($request);
    }

    /**
     * @Route("/page/{slug}", defaults={"slug" = "accueil"}, name="geekco_cms_index")
     */
    public function indexAction($slug, Request $request)
    {
        if ($slug === "accueil") {
            return $this->redirectToRoute("geekco_cms_homepage");
        }
        return $this->renderAction($request, $slug);
    }
}
