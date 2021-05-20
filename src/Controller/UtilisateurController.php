<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", StatusCode=401, message="Accès refusé à cette page")
    */
    public function editForm() {
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        catch(AccessDeniedException $ex) {
            $this->addFlash('error', "Vous n'avez pas accès à cette ressource");
        }
        finally 
        {
            return $this->redirectToRoute("#") ;
        }
    }
}
