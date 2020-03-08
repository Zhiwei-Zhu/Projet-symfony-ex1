<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Entity\Utilisateurs;
use App\Form\UpdateformType;
use App\Form\UtilisateurType;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur/{id}", name="utilisateur")
     */
    public function index(EntityManagerInterface $entityManager, Request $request,$id)
    {
        $utilisateurs = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)->find($id);

        $form = $this->createForm(UtilisateurType::class, $utilisateurs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $utilisateur= $form->getData();

            $entityManager->flush();
        }

        $taches = $this->getDoctrine()
            ->getRepository(Tache::class)->findBy(
                ['utilisateur' => [
                    'id' => $id
                ]]);

        $lenght= count($taches);

        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
            'form'=> $form->createView(),
            'lenght' => $lenght,
            'taches' => $taches,
            'utilisateur' =>$utilisateurs
        ]);
    }
    /**
     * @Route("/utilisateur/remove/{id}", name="remove")
     */
    public function remove($id, EntityManagerInterface $entityManager){

        $tache = $this->tacheRepository = $this->getDoctrine()
            ->getRepository(Tache::class)->find($id);
        $entityManager->remove($tache);
        $entityManager->flush();
        return $this->redirectToRoute('accueil');
    }
    /**
     * @Route("/utilisateur/update/{id}", name="update")
     */
    public function update($id, EntityManagerInterface $entityManager, Request $request){

        $tache =$this->getDoctrine()->getRepository(Tache::class)->find($id);


            $tache->setEtat(true);

            $entityManager->persist($tache);
            $entityManager->flush();

        return $this->redirectToRoute('accueil');
    }
}

