<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LibrairieController extends AbstractController
{
    /**
     * @Route("/librairie", name="librairie")
     */
    public function index(LivreRepository $repository): Response
    {
        $livres = $repository->findAll();
        // dd($livres);
        return $this->render('librairie/index.html.twig', [
            'livres' => $livres,
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('librairie/home.html.twig');
    }

    // /**
    //  * @Route("/librairie/delete/{id}", name="delete_livre")
    //  */
    // public function deleteLivre(Livre $livre, EntityManagerInterface $manager)
    // {
    //     try {
    //         $this->denyAccessUnlessGranted('ROLE_ADMIN');

    //         $manager->remove($livre);
    //         $manager->flush();
    //     } catch (AccessDeniedException $exception) {
    //         $this->addFlash("error", "Vous n'avez pas accès à cette ressource");
    //     } finally {
    //         return $this->redirectToRoute('librairie');
    //     }
    // }

    // /**
    //  * @Route("/librairie/edit/{id}", name="edit_livre")
    //  * @Route("/librairie/new", name="new_livre")
    //  * @IsGranted("ROLE_ADMIN", statusCode=401, message="Accès refusé à cette page")
    //  */
    // public function createAndEditLivre(Livre $livre = null, Request $requete, EntityManagerInterface $manager)
    // {
    //     if (!$livre) {
    //         $livre = new Livre();
    //     }

    //     $form = $this->createForm(LivreType::class, $livre);

    //     $form->handleRequest($requete);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $livre->setTitre();
    //         $livre->setAuteur();
    //         $livre->setAnnee();
    //         $manager->persist($livre);
    //         $manager->flush();
    //         return $this->redirectToRoute('librairie');
    //     }

    //     return $this->render('librairie/editLivre.html.twig', [
    //         'form' => $form->createView(),
    //         'mode' => $livre->getId() != null,
    //     ]);
    // }
}
