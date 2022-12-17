<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Chaton;
use App\Entity\Proprietaire;
use App\Form\CategorieSupprimerType;
use App\Form\CategorieType;
use App\Form\ChatonSupprimerType;
use App\Form\ChatonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatonsController extends AbstractController
{
    /**
     * @Route("/chatons/{id}", name="app_chatons")
     */
    public function index($id, ManagerRegistry $doctrine): Response
    {
        $categorie = $doctrine->getRepository(Categorie::class)->find($id);
        if (!$categorie) {
            throw $this->createNotFoundException("Aucune catégorie avec l'id $id");
        }

        return $this->render('chatons/index.html.twig', [
            'categorie' => $categorie,
            'chaton' => $categorie->getChatons(),

        ]);
    }

    /**
     * @Route("/chatons/modifier/{id}", name="app_chatons_modifier")
     */
    public function modifier($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $chaton = $doctrine->getRepository(Chaton::class)->find($id);
        if (!$chaton) {
            throw $this->createNotFoundException("Pas de chaton avec l'id $id");
        }
        $form = $this->createForm(ChatonType::class, $chaton);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist(($chaton));
            $em->flush();

            return $this->redirectToRoute("app_categories");
        }
        return $this->render("chatons/modifier.html.twig",[
            "chaton"=>$chaton,
            "formulaire"=>$form->createView()
        ]);
    }
    /**
     * @Route("/chaton/ajouter", name="app_chaton_ajouter")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $chaton= new Chaton();
        $form=$this->createForm(ChatonType::class, $chaton);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist(($chaton));
            $em->flush();

            return $this->redirectToRoute("app_categories");
        }

        return $this->render("chatons/ajouter.html.twig",[
            "formulaire"=>$form->createView()
        ]);
    }

    /**
     * @Route("/chaton/supprimer/{id}", name="app_chaton_supprimer")
     */
    public function supprimer($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $chaton = $doctrine->getRepository(Chaton::class)->find($id);
        if (!$chaton){
            throw $this->createNotFoundException("Pas de catégories avec l'id $id");
        }
        $form=$this->createForm(ChatonSupprimerType::class, $chaton);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->remove(($chaton));
            $em->flush();

            return $this->redirectToRoute("app_categories");
        }

        return $this->render("chatons/supprimer.html.twig",[
            "chaton"=>$chaton,
            "formulaire"=>$form->createView()
        ]);

    }

}
