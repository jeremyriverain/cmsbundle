<?php

namespace Geekco\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Geekco\CmsBundle\Entity\Module;
use Symfony\Component\HttpFoundation\JsonResponse;
use Geekco\CmsBundle\Form\ModuleType;
use Symfony\Component\HttpFoundation\Request;
use Geekco\CmsBundle\Services\ModuleManager;

/**
 * @Route("/admin/module")
 */
class ModuleController extends Controller
{

    /**
     * @Route("/clone-child")
     * @Method({"POST"})
     */
    public function cloneChildModule(Request $request, ModuleManager $moduleManager)
    {
        if (!$request->isXmlHttpRequest())
        {
            throw new NotFoundHttpException();
        }

        $em = $this->getDoctrine()->getManager();
        $module = $em->getRepository(Module::class)->findOneBy([
            'name' => $request->request->get('name'),
            'isBase' => true
        ]);

        $original = $em->getRepository(Module::class)->find($request->request->get('original'));

        if($module && $original){
            if(!$module->getChildren()->isEmpty()){
                $child = $module->getChildren()->first();

                $newChild = $moduleManager->copy($child);

                $em->persist($newChild);

                $original->addChild($newChild);

                $em->flush();

                return new JsonResponse([
                    'success' => true,
                ]);
            }
        }
        return new JsonResponse([
            'success' => false,
        ]);

    }

    /**
     * @Route("/update/{id}", name="geekco_cms_module_update")
     */
    public function update(Module $module, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid())
            {
                $resource = $module->getResource();
                $resource->setUpdatedAt(new \Datetime('now'));

                if (!$module->getChildren()->isEmpty())
                {
                    foreach ($module->getChildren() as $childModule)
                    {
                        $childResource = $childModule->getResource();
                        $childResource->setUpdatedAt(new \Datetime('now'));
                    }
                }

                $em->flush();
                $request->getSession()->getFlashBag()->add('success',"Les changements ont été enregistrés.");
                if ($request->isXmlHttpRequest())
                {
                    return new JsonResponse([
                        'success' => true
                    ]);
                }
                return $this->redirectToRoute("geekco_cms_module_update", [
                    'id' => $module->getId()
                ]);
            }
        }
        return $this->render('@geekco_cms/modules/index.html.twig', [
            'form' => $form->createView(),
            'page' => $module->getPage()
        ]);
    }


}


