<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;

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
                ->setTo('theo.herbin59710@outlook.fr')                        
                ->setBody($form->get('message')->getData());                
                $mailer->send($message);
                

            }          
        }
        return $this->render('contact/contact.html.twig', [            
            'form'=>$form->createView()        
            ]);
     
        }


}
