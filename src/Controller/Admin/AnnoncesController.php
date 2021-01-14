<?php

namespace App\Controller\Admin;


use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/admin/annonces", name="admin_annonces_")
     * @package App\Controller\Admin
     */
class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AnnoncesRepository $annoncesRepository): Response
    {
        return $this->render('admin/annonces/index.html.twig', [
            'annonces' => $annoncesRepository->findAll()
        ]);
    }

     /**
     * @Route("/activer/{id}", name="activer")
     */
    public function activer(Annonces $annonce)
    {
        $annonce->setActive(($annonce->getActive())?false:true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($annonce);
        $em->flush();

        return new Response("true");
    }

     /**
     * @Route("/supprimer/{id}", name="supprimer", methods="DELETE")
     */
    public function supprimer(Annonces $annonce)
    {
    
        $em = $this->getDoctrine()->getManager();
        $em->remove($annonce);
        $em->flush();
        
        
        $this->addFlash('message', 'Annonce supprimée avec succès');
        return $this->redirectToRoute('admin_annonces_home');
       
    }

    


    
   
}
