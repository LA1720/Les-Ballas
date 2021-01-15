<?php

namespace App\Controller;

use App\Entity\Annonces;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request): Response
    {
        //on récupère le nom d'hôte depuis l'URL
        $hostname = $request->getSchemeAndHttpHost();

        //on initialise un tableau pour les urls
        $urls = [];

        //on ajoute les urls "statique"

        $urls[] = ['loc' => $this->generateUrl('app_home')];
        $urls[] = ['loc' => $this->generateUrl('app_register')];
        $urls[] = ['loc' => $this->generateUrl('app_verify_email')];
        $urls[] = ['loc' => $this->generateUrl('app_forgot_password_request')];
        $urls[] = ['loc' => $this->generateUrl('app_check_email')];
        $urls[] = ['loc' => $this->generateUrl('app_reset_password')];
        $urls[] = ['loc' => $this->generateUrl('app_login')];
        $urls[] = ['loc' => $this->generateUrl('app_logout')];
        $urls[] = ['loc' => $this->generateUrl('users')];
        $urls[] = ['loc' => $this->generateUrl('users_annonces_ajout')];
        $urls[] = ['loc' => $this->generateUrl('users_profil_modifier')];
        $urls[] = ['loc' => $this->generateUrl('users_pass_modifier')];

        //on ajoute les urls dynamiques(à adapter avec les 19.46)
        foreach ($this->getDoctrine()->getRepository(Annonces::class)->findAll() as $annonce) {
            $images = [
                'loc' => '/uploads/images/featured/' . $annonce->getFeaturedImage(),
                'title' => $annonce->getTitre()
            ];

            $urls[] = [
                'loc' => $this->generateUrl('annonce', [
                    'slug' => $annonce->getSlug()
                ])
            ];
        }
        dd($urls);


        return $this->render('sitemap/index.html.twig', [
            'controller_name' => 'SitemapController',
        ]);
    }
}
