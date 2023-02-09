<?php

namespace App\Controller;

use id;
use App\Entity\Produit;
use App\Form\ProduitFormType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProdController extends AbstractController
{
    #[Route('/', name: 'prod_index')]
    #[Route('/prod', name: 'prod_index')]
    public function index(ProduitRepository $prodRepo): Response
    {
        $produit=$prodRepo->findAll();
        return $this->render('prod/index.html.twig', [
            'controller_name' => 'ProdController',

            'produit'=>$produit,
        ]);
    }
    #[isGranted('ROLE_ADMIN')]

    #[Route('/prod/modify/{id}', name:'modify')]
    #[Route('/prod/create', name:'create')]
    public function showProdModif(Produit $produit=null,Request $req,EntityManagerInterface $em){
        try{
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            if(!$produit){
                $produit= new Produit();
            }
            $form=$this->createForm(ProduitFormType::class,$produit);
            $form->handleRequest($req);
            if($form->isSubmitted()&&$form->isValid()){
                $em->persist($produit);
                $em->flush();

                return $this->redirectToroute('prod_index');
            }
        
            return $this->render('prod/prodModif.html.twig',[
                'formProd'=>$form->createView(),
                'mode'=>$produit->getId()!=null,
            ]);
        }
        catch(AccessDeniedException $ex){
            return $this->render('errors/denied.html.twig');
        }
    }
}
