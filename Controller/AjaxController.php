<?php

namespace Geekco\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use GeekcoBundle\Entity\Util;

/**
 * @Route("/admin/ajax")
 */
class AjaxController extends Controller
{

    /**
     * @Route("/switch", name="geekco_cms_ajax_switch")
     * @Method({"POST"})
     */
    public function switchAction(Request $request)
    {

        if ($request->isXmlHttpRequest())
        {
            try {
                $namespaceParent = $request->request->get('namespaceParent');
                $id = $request->request->get('id');
                $method = $request->request->get('method');
                $value = filter_var($request->request->get('value') == 'true', FILTER_VALIDATE_BOOLEAN);

                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository($namespaceParent)->find($id);

                $reflectionMethod = new \ReflectionMethod($namespaceParent, $method);

                $reflectionMethod->invoke($entity, $value);
                $em->flush();

                return new JsonResponse([
                    "success" => true,
                ]);
            }
            catch(\Throwable $e) {

                return new JsonResponse([
                    "success" => false,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ]);

            }  
        }
        throw new NotFoundHttpException();

    }

    /**
     * @Route("/", name="geekco_cms_ajax_delete")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request)
    {
        try {
            if ($request->isXmlHttpRequest())
            {
                $namespace = $request->request->get('namespace');

                $id = $request->request->get('id');

                $em = $this->getDoctrine()->getManager();

                $entity = $em->getRepository($namespace)->find($id);

                if (!$entity)
                {
                    return new JsonResponse([
                        "success"=> false
                    ]);
                }

                if(property_exists($namespace, 'deletable'))
                {
                    if($entity->getDeletable() === false)
                    {
                        return new JsonResponse([
                            "success" => false,
                            'message' => "Cette entité ne peut pas être supprimée.",
                            'code' => 403
                        ]);
                    }
                }

                $em->remove($entity);

                $em->flush();

                return new JsonResponse([
                    "success" => true,
                ]);     
            }
        }
        catch(\Throwable $e)
        {
            return new JsonResponse([
                "success" => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }

        throw new NotFoundHttpException();
    }

    /**
     * @Route("/position", name="geekco_cms_ajax_position")
     * @Method({"POST"})
     */
    public function positionAction(Request $request) {
        if (!$request->isXmlHttpRequest())
        {
            throw new NotFoundHttpException();
        }
        $namespace = $request->request->get('namespace');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($namespace);
        $items = $request->request->get('items');

        foreach ($items as $i)
        {
            $e = $repo->find($i['id']);
            if (!$e)
            {
                throw new NotFoundHttpException();
            }
            $e->setPosition($i['position']);
        }

        $em->flush();

        return new JsonResponse([
            'success' => true
        ]);
    }
    
    /**
     * @Route("/propriete", name="geekco_cms_ajax_propertyupdater")
     */
    public function propertyUpdaterAction(Request $request, ValidatorInterface $validator)
    {
        $namespace = $request->request->get('namespace');
        $id = $request->request->get('id');
        $method = $request->request->get('method');
        $value = $request->request->get('value');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository($namespace)->find($id);

        $reflectionMethod = new \ReflectionMethod($namespace, $method);

        $reflectionMethod->invoke($entity, $value);
        
        $errors = $validator->validate($entity);

			if (count($errors) > 0) {
                $array = [];
                foreach ($errors as $e)
                {
                    $array[] = $e->getMessage();
                }

				return new JsonResponse([
                    'errors' => $array,
                    'success' => false  
                ]);
			}

        $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Les modifications sont enregistrées.");

        return new JsonResponse([
            'success' => true
        ]);
    }

}
