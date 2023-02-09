<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategoryFormType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatController extends AbstractController
{
    #[Route('/cat', name: 'app_cat')]
    public function index(CategorieRepository $catRepo): Response
    {
        $category=$catRepo->findAll();
        return $this->render('cat/index.html.twig', [
            'controller_name' => 'CatController',
            'category'=>$category,
        ]);
    }
    #[Route('/cat/modify/{id}', name:'modifier')]
    #[Route('/cat/create', name:'cat_create')]
    public function showCatModif(Categorie $category=null,Request $req,EntityManagerInterface $em){
        if(!$category){
            $category= new Categorie();
        }
        $form=$this->createForm(CategoryFormType::class,$category);
        $form->handleRequest($req);
        if($form->isSubmitted()&&$form->isValid()){
            $em->persist($category);
            $em->flush();

            return $this->redirectToroute('app_cat');
        }
    
        return $this->render('cat/catModif.html.twig',[
            'formCat'=>$form->createView(),
            'mode'=>$category->getId()!=null,
        ]);
    }
}
