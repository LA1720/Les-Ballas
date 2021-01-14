<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/admin/categories", name="admin_categories_")
     * @package App\Controller\Admin
     */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll()
        ]);
    }

    /**
     * @Route("/ajout", name="ajout")
     */
    public function ajoutCategorie(Request $request, EntityManagerInterface $em): Response
    {

        $categorie = new Categories;
        
        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isvalid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('admin_categories_home');

        }



        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function ModifierCategorie(Request $request, Categories $categorie, EntityManagerInterface $em): Response
    {

        
        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isvalid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('admin_categories_home');

        }



        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer", methods="DELETE")
     */
    public function supprimer(Categories $categorie)
    {
    
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        
        
        $this->addFlash('message', 'Catégorie supprimée avec succès');
        return $this->redirectToRoute('admin_categories_home');
       
    }
}
