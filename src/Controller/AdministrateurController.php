<?php

namespace Geekco\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Geekco\CmsBundle\Entity\User;
use Geekco\CmsBundle\Form\UserType;

/**
 * @Route("/admin/administrateur")
 */
class AdministrateurController extends Controller
{

    /**
     * @Route("/", name="geekco_cms_administrateur_list")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        $admins = [];

        foreach ($users as $u)
        {
            if(in_array(strtoupper('ROLE_ADMIN'), $u->getRoles(), true)) {
                $admins[] = $u;
            }
        }

        return $this->render('@GeekcoCms/admin_user/list.html.twig', [
            'admins' => $admins
        ]);

    }

    /**
     * @Route("/creer", name="geekco_cms_administrateur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, [ 
           'validation_groups' => array('User', 'registration'), 
        ]);

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

        return $this->render('@GeekcoCms/admin_user/new.html.twig', [
            'form' => $form->createView()
        ]);



    }

    /**
     * @Route("/{id}", name="geekco_cms_administrateur_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request, UserPasswordEncoderInterface $encoder, User $user)
    {

        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(UserType::class, $user, [
           'validation_groups' => array('User'), 
        ]);

        $form->handleRequest($request);

        $plainPassword = $user->getPlainPassword();

        if (null !== $plainPassword)
        {
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
        }

        if ($form->isSubmitted() && $form->isValid())
        {

            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Votre profil a été modifié');
            return $this->redirectToRoute("geekco_cms_administrateur_list");
        }

        return $this->render('@GeekcoCms/admin_user/update.html.twig', [
            'form' => $form->createView()
        ]);


    }

}
