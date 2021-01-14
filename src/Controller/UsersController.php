<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use App\Form\EditProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig');
    }

    /**
     * @Route("/users/annonces/ajout", name="users_annonces_ajout")
     */
    public function ajoutAnnonces(Request $request)
    {
        $annonce = new Annonces;

        $form = $this->createForm(AnnoncesType::class, $annonce);

        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $annonce->setUsers($this->getUser());
            $annonce->setActive(false);

            $em=$this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

        return $this->redirectToRoute('users');    
        }

        return $this->render('users/annonces/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

        /**
     * @Route("/users/profil/modifier", name="users_profil_modifier")
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $this->getUser());
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');   
        return $this->redirectToRoute('users');    
        }

        return $this->render('users/editprofile.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
