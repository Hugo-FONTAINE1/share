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
    public function profileUtilisateur(int $id, Request $request)
    {
     
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateur = $repoUtilisateur->find($id);
        if ($utilisateur==null){
            $this->addFlash('notice','Utilisateur introuvable');
            return $this->redirectToRoute('accueil');
        }
        $form = $this->createForm(ImageProfilType::class);
        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form->get('photo')->getData();
                try{    
                    $fileName = $utilisateur->getId().'.'.$file->guessExtension();
                    $file->move($this->getParameter('profile_directory'),$fileName); // Nous déplaçons lefichier dans le répertoire configuré dans services.yaml
                    $em = $em->getManager();
                    $utilisateur->setPhoto($fileName);
                    $em->persist($utilisateur);
                    $em->flush();
                    $this->addFlash('notice', 'Fichier inséré');

                } catch (FileException $e) {                // erreur durant l’upload            }
                    $this->addFlash('notice', 'Problème fichier inséré');
                }
            }
        }    

        if($utilisateur->getPhoto()==null){
          $path = $this->getParameter('profile_directory').'/defaut.png';
        }
        else{
            $path = $this->getParameter('profile_directory').'/'.$utilisateur->getPhoto();
        }    
        $data = file_get_contents($path);
        $base64 = 'data:image/png;base64,' . base64_encode($data);

        return $this->render('utilisateur/user_profile.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
            'base64' => $base64
        ]);
    }



}
