<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\InscrireType;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

      /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {        $form = $this->createForm(ContactType::class);        
        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) { 
                $this->addFlash('notice','Bouton appuyé');   
                // Envoyer un email                
                $message = (new \Swift_Message($form->get('subject')->getData()))                        
                ->setFrom($form->get('email')->getData())                        
                ->setTo('h.fontaine5962@gmail.com')                        
                ->setBody($form->get('message')->getData());                
                $mailer->send($message);
                

            }          
        }
        return $this->render('contact/contact.html.twig', [            
            'form'=>$form->createView()        
            ]);
     
    }
/**
     * @Route("/inscrire", name="inscrire")
     */
    public function inscrire(Request $request,  UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(InscrireType::class, $user);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $mdpConf = $form->get('confirmation')->getData();
                $mdp = $user->getPassword();
                if($mdp == $mdpConf){
                    $user->setRoles(array('ROLE_USER'));
                    $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('notice', 'Inscription réussie');
                    return $this->redirectToRoute('app_login');
                }
                
                else{
                    $this->addFlash('notice', 'Erreur de mot de passe');
                    return $this->redirectToRoute('inscrire');
                }
            }
        }        

        return $this->render('accueil/inscrire.html.twig', [
           'form'=>$form->createView()
        ]);
    }


}
