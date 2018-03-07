<?php

namespace Geekco\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Geekco\CmsBundle\Entity\User;
use Geekco\CmsBundle\Services\Mailer;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Geekco\CmsBundle\Form\UserResettingType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/renouvellement-mot-de-passe")
 */
class ResettingController extends Controller
{

    /**
     * @Route("/requete", name="geekco_cms_resetting_request")
     */
    public function request(Request $request, Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
              'constraints' => [
                  new Email(),
                  new NotBlank()
              ] 
            ])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->loadUserByUsername($form->getData()['email']);
            if (!$user)
            {
                $request->getSession()->getFlashBag()->add('error', "Cet email n'est pas enregistré en base.");
                return $this->redirectToRoute("geekco_cms_resetting_request");
            }
            elseif($user->getPasswordRequestedAt() !== null)
            {
                $request->getSession()->getFlashBag()->add('error', "Vous avez déjà demandé un token. Consultez votre boîte mail. Si vous ne l'avez pas reçu, consultez vos spams au cas où il aurait été traité comme un indésirable.");
                return $this->redirectToRoute("geekco_cms_connexion");
            }
            else
            {
                $user->setToken($tokenGenerator->generateToken());
                $user->setPasswordRequestedAt(new \Datetime());
                $em->flush();

                $bodyMail = $mailer->createBodyMail('@geekco_cms/resetting/mail.html.twig', [
                    'user' => $user
                ]);

                $mailer->sendMessage($this->getParameter('coordonnees')['email'], $user->getEmail(), 'renouvellement du mot de passe', $bodyMail);

                $request->getSession()->getFlashBag()->add('success', "Un mail va vous être envoyé afin que vous puissiez renouveller votre mot de passe. Le lien que vous recevrez sera valide 24h.");

                return $this->redirectToRoute("geekco_cms_connexion");
            }
        }

        return $this->render('@geekco_cms/resetting/request.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function isRequestInTime(\Datetime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null)
        {
            return false;        
        }

        $now = new \DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        $daySeconds = 60 * 60 * 24;
        $response = $interval > $daySeconds ? false : $reponse = true;
        return $response;
    }

    /**
     * @Route("/{id}/{token}", name="geekco_cms_resetting")
     */
    public function resetting(User $user, $token, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($token !== $user->getToken() || !$this->isRequestInTime($user->getPasswordRequestedAt()))
        {
            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(UserResettingType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setToken(null);
            $user->setPasswordRequestedAt(null);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Votre mot de passe a été enregistré.");

            return $this->redirectToRoute('geekco_cms_connexion');

        }

        return $this->render('@geekco_cms/resetting/index.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
