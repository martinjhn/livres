<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UtilisateurController extends AbstractController
{
	/**
    * @IsGranted("ROLE_ADMIN", StatusCode=401, message="Accès refusé à cette page")
	* @Route("/admin/utilisateur/", name="utilisateur_index", methods={"GET"})
	*/
	public function index(UtilisateurRepository $utilisateurRepository): Response
	{
		return $this->render('utilisateur/index.html.twig', [
			'utilisateurs' => $utilisateurRepository->findAll(),
		]);
	}

	/**
    * @IsGranted("ROLE_ADMIN", StatusCode=401, message="Accès refusé à cette page")
	* @Route("/admin/utilisateur/new", name="utilisateur_new", methods={"GET","POST"})
	*/
	public function new(Request $request): Response
	{
		$utilisateur = new Utilisateur();
		$form = $this->createForm(UtilisateurType::class, $utilisateur);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($utilisateur);
			$entityManager->flush();

			return $this->redirectToRoute('utilisateur_index');
		}

		return $this->render('utilisateur/new.html.twig', [
			'utilisateur' => $utilisateur,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/utilisateur/{id}", name="utilisateur_show", methods={"GET"})
	 */
	public function show(Utilisateur $utilisateur): Response
	{
		return $this->render('utilisateur/show.html.twig', [
			'utilisateur' => $utilisateur,
		]);
	}

	/**
	 * @Route("/utilisateur/{id}/edit", name="utilisateur_edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, Utilisateur $utilisateur, UserPasswordEncoderInterface $passwordEncoder): Response
	{
		$form = $this->createForm(UtilisateurType::class, $utilisateur);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$hash = $passwordEncoder->encodePassword($utilisateur, $utilisateur->getPassword());
			$utilisateur->setPassword($hash);
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('utilisateur_index');
		}

		return $this->render('utilisateur/edit.html.twig', [
			'utilisateur' => $utilisateur,
			'form' => $form->createView(),
		]);
	}

	/**
    * @IsGranted("ROLE_ADMIN", StatusCode=401, message="Accès refusé à cette page")
	* @Route("/admin/utilisateur/{id}", name="utilisateur_delete", methods={"POST"})
	*/
	public function delete(Request $request, Utilisateur $utilisateur): Response
	{
		if ($this->isCsrfTokenValid('delete' . $utilisateur->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($utilisateur);
			$entityManager->flush();
		}

		return $this->redirectToRoute('utilisateur_index');
	}
}
