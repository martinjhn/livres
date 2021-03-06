<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EmpruntController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN", StatusCode=401, message="Accès refusé à cette page")
     * @Route("admin/emprunt/", name="emprunt_index", methods={"GET"})
     */
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }

    /**
    * @IsGranted("ROLE_ADMIN", StatusCode=401, message="Accès refusé à cette page")
    * @Route("admin/emprunt/new", name="emprunt_new", methods={"GET","POST"})
    */
    public function new(Request $request): Response
    {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emprunt);
            $entityManager->flush();

            return $this->redirectToRoute('emprunt_index');
        }

        return $this->render('emprunt/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/emprunt/{id}", name="emprunt_show", methods={"GET"})
     */
    public function show(Emprunt $emprunt): Response
    {
        if($this->getUser()) {
            return $this->render('emprunt/show.html.twig', [
                'emprunt' => $emprunt,
            ]);
        }
    }

    /**
    * @IsGranted("ROLE_ADMIN", StatusCode=401, message="Accès refusé à cette page")
    * @Route("/admin/emprunt/{id}/edit", name="emprunt_edit", methods={"GET","POST"})
    */
    public function edit(Request $request, Emprunt $emprunt): Response
    {
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('emprunt_index');
        }

        return $this->render('emprunt/edit.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form->createView(),
        ]);
    }

    /**
    * @IsGranted("ROLE_ADMIN", StatusCode=401, message="Accès refusé à cette page")
    * @Route("/admin/emprunt/{id}", name="emprunt_delete", methods={"POST"})
    */
    public function delete(Request $request, Emprunt $emprunt): Response
    {
        if ($this->isCsrfTokenValid('delete' . $emprunt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emprunt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('emprunt_index');
    }
}
