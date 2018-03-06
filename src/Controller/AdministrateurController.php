<?php

namespace Geekco\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/administrateur")
 */
class AdministrateurController extends Controller
{

    private function getUserNamespace() {
       return  $this->getParameter('cms.user_namespace');
    }
    
    private function getUserTypeNamespace() {
       return  $this->getParameter('cms.userType_namespace');
    }

    /**
     * @Route("/", name="geekco_cms_administrateur_list")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $userNamespace = $this->getUserNamespace();

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository($userNamespace)->findAll();
        $admins = [];
        foreach ($users as $u)
        {
            if(in_array(strtoupper('ROLE_ADMIN'), $u->getRoles(), true)) {
                $admins[] = $u;
            }
        }

        return $this->render('@geekco_cms/admin_user/list.html.twig', [
            'admins' => $admins
        ]);

    }

    /**
     * @Route("/creer", name="geekco_cms_administrateur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $userNamespace = $this->getUserNamespace();
        $user = new $userNamespace();

        $userTypeNamespace = $this->getUserTypeNamespace();

        $form = $this->createForm($userTypeNamespace, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $plainPassword = $user->getPlainPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
            $user->setRoles(['ROLE_ADMIN']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "<i class='material-icons'>check</i>L'administrateur a été créé.");
            return $this->redirectToRoute("geekco_cms_administrateur_list");
        }

        return $this->render('@geekco_cms/admin_user/new.html.twig', [
            'form' => $form->createView()
        ]);



    }

    /**
     * @Route("/{id}", name="geekco_cms_administrateur_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request, UserPasswordEncoderInterface $encoder, $id)
    {

        $em = $this->getDoctrine()->getManager();
        
        $userNamespace = $this->getUserNamespace();
        $user =  $em->getRepository($userNamespace)->find($id);

        if (!$user)
        {
            throw new NotFoundHttpException();
        }

        $userTypeNamespace = $this->getUserTypeNamespace();

        $form = $this->createForm($userTypeNamespace, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $plainPassword = $user->getPlainPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Votre profil a été modifié');
            return $this->redirectToRoute("geekco_cms_administrateur_list");
        }

        return $this->render('@geekco_cms/admin_user/update.html.twig', [
            'form' => $form->createView()
        ]);


    }

}
