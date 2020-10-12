<?php

namespace App\Controller;


use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\UtilisateurRepository;
use App\Form\AjoutUtilisateurType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;


class UtilisateurController extends AbstractController
{
    /**
     * @Route("/ajouter_utilisateur", name="ajouter_utilisateur")
     */
    public function ajoutUtilisateur(Request $request)
    {
        $utilisateur = new Utilisateur();
       
        $form = $this->createForm(AjoutUtilisateurType::class,$utilisateur);        
        
        if ($request->isMethod('POST')){            
          $form -> handleRequest ($request);            
          if($form->isValid()){    
            $utilisateur->setDateinscription(new \DateTime());        
            $em = $this->getDoctrine()->getManager();              
            $em->persist($utilisateur);              
            $em->flush();        
          $this->addFlash('notice','Utilisateur ajouté'); 
         
          } 
          return $this->redirectToRoute('ajouter_utilisateur');
        }
        
     
        return $this->render('ajouter_utilisateur/ajouter_utilisateur.html.twig', [
          'form'=>$form->createView()
        ]);
    }



    /**
     * @Route("/liste_utilisateurs", name="liste_utilisateurs")
     */
    public function listeUtilisateurs(Request $request)
    {
      $em = $this->getDoctrine();
      $repoUtilisateur = $em-> getRepository(Utilisateur::class);
      $utilisateurs = $repoUtilisateur->findBy(array(),array('nom'=>'ASC'));
    return $this->render('liste_utilisateurs/liste_utilisateurs.html.twig', [
    'utilisateurs'=>$utilisateurs
  ]);
}


/**
     * @Route("/profile_utilisateur", name="profile_utilisateur")
     */
    public function profileUtilisateur(int $id,Request $request)
    {
      $em=$this->getDoctrine();
      $repoUtilisateur=$em->getRepository(Utilisateur::class);
      $utilisateur=$repoUtilisateur->find($id);

      $form = $this->createForm(ImageProfilType::class);

      $path =$this->getParameter('profile_directory').'/defaut.png';
      $data=file_get_contents($path)
      $base64='data:image/png;base64,'.base64_encode($data);

    return $this->render('profile_utilisateur/profile_utilisateur.html.twig', [
      'utilisateur'=>$utilisateur
      'form'=>$form->createView()
      'base64'=>$base64
  ]);
}




}
