<?php

namespace App\Controller;


use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Theme;
use App\Form\AjoutThemeType;
use App\Form\ModifThemeType;
use App\Repository\ThemeRepository;


class ThemeController extends AbstractController
{
    /**
     * @Route("/theme", name="ajout_theme")
     */
    public function ajoutTheme(Request $request)
    {
        $theme = new Theme();
       
        $form = $this->createForm(AjoutThemeType::class,$theme);        
        
        if ($request->isMethod('POST')){            
          $form -> handleRequest ($request);            
          if($form->isValid()){              
            $em = $this->getDoctrine()->getManager();              
            $em->persist($theme);              
            $em->flush();        
          $this->addFlash('notice','Thème ajouté'); 
         
          } 
          return $this->redirectToRoute('ajout_theme');
        }
        
     
        return $this->render('theme/ajout_theme.html.twig', [
          'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/modif_theme/{id}", name="modif_theme", requirements={"id"="\d+"})
     */
    public function modifTheme(int $id, Request $request)
    {
      $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);
        $theme = $repoTheme->find($id);

        if($theme==null){
            $this->addFlash('notice', "Ce thème n'existe pas");
            return $this->redirectToRoute('liste_themes');
        }

        $form = $this->createForm(ModifThemeType::class,$theme);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($theme);
                $em->flush();    

                $this->addFlash('notice', 'Thème modifié');

            }
            return $this->redirectToRoute('liste_themes');
        }        

        return $this->render('modif_theme/modif_theme.html.twig', [
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/liste_themes", name="liste_themes")
     */
    public function listeThemes(Request $request)
  
    {
      $em = $this->getDoctrine();
      $repoTheme = $em-> getRepository(Theme::class);

      if ($request->get('supp')!=null){
        $theme = $repoTheme->find($request->get('supp'));
        if($theme!=null){
            $em->getManager()->remove($theme);
            $em->getManager()->flush();
        }    
        return $this->redirectToRoute('liste_themes');
    }

      $themes = $repoTheme->findBy(array(),array('libelle'=>'ASC'));
    return $this->render('liste_themes/liste_themes.html.twig', [
    'themes'=>$themes
  ]);
}


}
