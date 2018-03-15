<?php

namespace Geekco\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Geekco\CmsBundle\Services\FilterManager;
use Geekco\CmsBundle\Entity\Page;
use Geekco\CmsBundle\Form\PageType;
use Geekco\CmsBundle\Services\ModuleManager;
use Geekco\CmsBundle\Entity\Module;
use Geekco\CmsBundle\Entity\Tag;

/**
 * @Route("/admin/page")
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="geekco_cms_page_list")
     * @Method({"GET"})
     */
    public function listAction(Request $request, FilterManager $filterManager)
    {
        $em = $this->getDoctrine()->getManager();

        $filterResponse = $filterManager->validate(Page::class, $request->get('orderby'), $request->get('direction'));

        if ($filterResponse['success'] === true) {
            $pages = $em->getRepository(Page::class)->findBy([], [
                $filterResponse['orderby'] => $filterResponse['direction']
            ]);
        } else {
            $pages = $em->getRepository(Page::class)->findAll();
        }
        return $this->render('@GeekcoCms/page/list.html.twig', [
            'pages' => $pages,
            'filterResponse' => $filterResponse,
        ]);
    }

    /**
     * @Route("/creer", name="geekco_cms_page_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "<i class='material-icons'>check</i>La page a été créée.");
            return $this->redirectToRoute("geekco_cms_page_list", [
                'orderby' => 'created',
                'direction' => 'DESC'
            ]);
        }

        return $this->render('@GeekcoCms/page/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/title/{id}", requirements={"id"="\d+"}, name="geekco_cms_page_update_title")
     * @Method({"GET", "POST"})
     */
    public function updateTitle(Request $request, Page $page, ValidatorInterface $validator)
    {
        if ($request->isXmlHttpRequest()) {
            if ($page->getSlug() === 'accueil') {
                throw new NotFoundHttpException();
            }

            $name = $request->request->get('name');
            $page->setName($name);

            $errors = $validator->validate($page);

            if (count($errors) > 0) {
                $array = [];
                foreach ($errors as $e) {
                    $array[] = $e->getMessage();
                }

                return new JsonResponse([
                    'errors' => $array,
                    'success' => false
                ]);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Changements enregistrés');
            return new JsonResponse([
                'success' => true
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @Route("/{id}",  requirements={"id"="\d+"}, name="geekco_cms_page_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request, Page $page, ModuleManager $moduleManager)
    {
        $em = $this->getDoctrine()->getManager();

        $modules = $em->getRepository(Module::class)->findBy(['page' => $page], ['position' => 'ASC']);

        $pages = $em->getRepository(Page::class)->findBy([], ['name' =>  'ASC']);

        $bases = $moduleManager->getPotentialModules($page);

        return $this->render('@GeekcoCms/page/update.html.twig', [
            'page' => $page,
            'bases' => $bases,
            'pages' => $pages,
            'modules' => $modules,
        ]);
    }

    /**
     * @Route("/ajouter-module", name="geekco_cms_page_addmodule")
     */
    public function addModule(Request $request, ModuleManager $moduleManager)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository(Page::class)->find($request->request->get('pageId'));
        $module = $em->getRepository(Module::class)->find($request->request->get('moduleId'));
        if (!$page || !$module) {
            throw new NotFoundHttpException();
        }

        if ($module->getDeletable() === false) {
            throw new \Exception("Le module ne pouvant pas être supprimé, il ne peut pas non plus être dupliqué!");
        }

        $newModule = $moduleManager->addModuleToPage($module, $page);
        if ($newModule instanceof Module) {
            $em->persist($newModule);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Le module a été ajouté à la page.");
            return new JsonResponse([
                'success' => true,
            ]);
        } else {
            return new JsonResponse([
                'success' => false,
                'message' => $newModule
            ]);
        }
    }

    /**
     * @Route("/get-tags/{id}")
     */
    public function getTags(Page $page, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }
        $tags = $page->getTags();
        $reponse = [];
        foreach ($tags as $t) {
            $reponse[] = $t->getValue();
        }
        return new JsonResponse($reponse);
    }

    /**
     * @Route("/tag/{id}")
     * @Method({"POST"})
     */
    public function addTag(Request $request, Page $page)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository(Tag::class)->findOneBy([
            'categorie' => 'page',
            'value' => $request->request->get('value')
        ]);
        if (!$tag) {
            $tag = new Tag();
            $tag->setValue($request->request->get('value'));
            $tag->setCategorie('page');
            $em->persist($tag);
        }

        $em = $this->getDoctrine()->getManager();
        $page->addTag($tag);
        $em->flush();
        return new JsonResponse([
            'success' => true
        ]);
    }

    /**
     * @Route("/tag/{id}")
     * @Method({"DELETE"})
     */
    public function removeTag(Request $request, Page $page)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository(Tag::class)->findOneBy(['categorie'=>'page','value'=>$request->request->get('value')]);
        if ($tag) {
            $page->removeTag($tag);
            if ($tag->getPages()->isEmpty()) {
                $em->remove($tag);
            }
            $em->flush();
            return new JsonResponse([
                'success' => true
            ]);
        } else {
            return new JsonResponse([
                'success' => false
            ]);
        }
    }
}
