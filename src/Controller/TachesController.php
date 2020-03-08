<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheformType;
use App\Form\UpdateformType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TachesController extends AbstractController
{
    /**
     * @Route("/taches", name="taches")
     */
    public function index(EntityManagerInterface $entityManager,Request $request)
    {
        $taches= new  tache();
        $form = $this->createForm(TacheformType::class, $taches);
        $taches->setEtat(false);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $tache= $form->getData();

            $entityManager->persist($tache);
            $entityManager->flush();
        }

        $TachesRepo = $this->getDoctrine()
            ->getRepository(Tache::class)
            ->findAll();
            dump($TachesRepo);
        return $this->render('taches/index.html.twig', [
            'controller_name' => 'TachesController',
            'taches' => $TachesRepo,
            'formtache'=> $form->createView()
        ]);
    }
    /**
     * @Route("taches/updatetache/{id}", name="updatetache")
     */
    public function update($id ,EntityManagerInterface $entityManager,Request $request)
    {
        $tache = $this->getDoctrine()
            ->getRepository(Tache::class)->find($id);

        $form2 = $this->createForm(UpdateformType::class, $tache);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()){
            $tache= $form2->getData();

            $entityManager->persist($tache);
            $entityManager->flush();
        }


        return $this->render('taches/updatetache.html.twig', [
            'controller_name' => 'TachesController',
            'form'=> $form2->createView(),
        ]);
    }
}
