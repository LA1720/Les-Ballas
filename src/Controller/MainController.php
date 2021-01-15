<?php

namespace App\Controller;

use App\Form\SearchAnnonceType;
use App\Repository\AnnoncesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    

/**

     * @Route("/", name="app_home")

     */

    public function index(AnnoncesRepository $annoncesRepo, Request $request)

    {

        $annonces = $annoncesRepo->findBy(['active' => true], ['created_at' => 'desc'], 5);

        $form = $this->createForm(SearchAnnonceType::class);

        

        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // On recherche les annonces correspondant aux mots clés

            $annonces = $annoncesRepo->search(

                $search->get('mots')->getData(),

                $search->get('categorie')->getData()

            );

        }

        return $this->render('main/index.html.twig', [

            'annonces' => $annonces,

            'form' => $form->createView()

        ]);

    }


}
