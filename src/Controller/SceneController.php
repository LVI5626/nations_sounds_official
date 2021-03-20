<?php

namespace App\Controller;

use App\Entity\Scene;
use App\Form\SceneType;
use App\Repository\SceneRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArtistRepository;
use Container03Vr84x\getPartnerRepositoryService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class SceneController extends AbstractController
{
    /**
     * @Route("/scene", name="scene_index", methods={"GET"})
     * 
     * Require ROLE_USER for only this controller method.
     *
     * @IsGranted("ROLE_USER")
     */
    public function index(SceneRepository $sceneRepository, PartnerRepository $partnerRepository): Response
    {
        return $this->render('scene/index.html.twig', [
            'scenes' => $sceneRepository->findAll(),
            'partners' => $partnerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="scene_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $scene = new Scene();
        $form = $this->createForm(SceneType::class, $scene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($scene);
            $entityManager->flush();

            return $this->redirectToRoute('scene_index');
        }

        return $this->render('scene/new.html.twig', [
            'scene' => $scene,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/fr/scene/{name}", name="scene_show", methods={"GET"})
     */

    public function show(Scene $scene, PartnerRepository $partnerRepository, ArtistRepository $artistRepository): Response
    {
        $partner = $partnerRepository->findAll();
        //$artists = $artist->findAll();
        $artists = $artistRepository;
        return $this->render('scene/show.html.twig', [
            'scene' => $scene,
            'artists' => $artists,
            'partners' => $partnerRepository->findAll(),
        ]);
    }



    /**
     * @Route("/scene/{id}/edit", name="scene_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Scene $scene, PartnerRepository $partnerRepository): Response
    {
        $form = $this->createForm(SceneType::class, $scene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scene_index');
        }

        return $this->render('scene/edit.html.twig', [
            'scene' => $scene,
            'partners' => $partnerRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/scene/{id}", name="scene_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Scene $scene): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scene->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($scene);
            $entityManager->flush();
        }

        return $this->redirectToRoute('scene_index');
    }
}
