<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PartnerRepository;
use App\Repository\ArtistRepository;
use App\Repository\SceneRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;




class HomeController extends AbstractController
{
         /**
          * Require ROLE_USER for only this controller method.
          *
          * @IsGranted("ROLE_USER")
          */


    public function index(ArtistRepository $artistRepository, PartnerRepository $partnerRepository, SceneRepository $sceneRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'partners' => $partnerRepository->findAll(),
            'scenes' => $sceneRepository->findAll(),
            'artists' => $artistRepository->findBy([],['name'=>'ASC']),
            'show1' => $artistRepository->findBy(['date'=>'Vendredi', 'scene' => '1'],['hour'=>'ASC']),
        ]);
    }

    public function index2(ArtistRepository $artistRepository, PartnerRepository $partnerRepository, SceneRepository $sceneRepository): Response
    {
        return $this->render('indexfr.php', [
        ]);
    }

    public function indexeng(ArtistRepository $artistRepository, PartnerRepository $partnerRepository, SceneRepository $sceneRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'partners' => $partnerRepository->findAll(),
            'scenes' => $sceneRepository->findAll(),
            'artists' => $artistRepository->findBy([],['name'=>'ASC']),
            'show1' => $artistRepository->findBy(['date'=>'Vendredi', 'scene' => '1'],['hour'=>'ASC']),
        ]);
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(ArtistRepository $artistRepository, PartnerRepository $partnerRepository): Response
    {
        return $this->render('home/faq.html.twig', [
            'controller_name' => 'HomeController',
            'partners' => $partnerRepository->findAll(),
            'artists' => $artistRepository->findAll(),
        ]);
    }

        /**
     * @Route("/a-propos", name="a-propos")
     */
    public function propos(ArtistRepository $artistRepository, PartnerRepository $partnerRepository): Response
    {
        return $this->render('home/a_propos.html.twig', [
            'controller_name' => 'HomeController',
            'partners' => $partnerRepository->findAll(),
            'artists' => $artistRepository->findAll(),
        ]);
    }
    
}
