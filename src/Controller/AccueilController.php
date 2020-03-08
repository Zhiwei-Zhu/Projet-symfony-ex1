<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\Tache;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(EntityManagerInterface $entityManager, Request $request)
    {


        $utilisateurs= new  utilisateurs();
        $utilisateurs->setCreateAt(new \DateTime());

        $form = $this->createForm(UtilisateurType::class, $utilisateurs);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $utilisateur= $form->getData();


            $entityManager->persist($utilisateur);
            $entityManager->flush();
        }

        $UtilisateurRepo = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->findAll();
        $TacheRepo = $this->getDoctrine()
            ->getRepository(Tache::class);

        dump($UtilisateurRepo);

        $lenght= count($UtilisateurRepo);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilControllerController',
            'utilisateurs'=>$UtilisateurRepo,
            'lenght'=>$lenght,
            'form'=>$form->createView(),
            'tache' => $TacheRepo
        ]);
    }
}
