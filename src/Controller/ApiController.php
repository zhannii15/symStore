<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/api/categorie', name: 'api_all_cat')]
    public function index(CategorieRepository $catRepo): Response
    {  
        // ***********Decomposition des etapes*******
         //données en brutes
        // $cats=$catRepo->findAll();
        // $jsonCat = [];
        // dd($cats);
        //Normalisation des données 
        // $normCats=$normalizer->normalize($cats,null,['groups'=>'read_cat']);
        // dd($normCats);

        //Sérialistaion des données normalisées
        // $jsonCat= json_encode($normCats);

        // ************Normalisation+Sérialition en 1 etape*********
        // $jsonCat= $serializer->serialize($cats,'json',['groups'=>'read_cat']);


        // Envoi de la reponse
        // $reponse= new Response($jsonCat,200,[
        //     'Content-Type' =>'application/json',
        // ]);

        // return $reponse;

        // ************En 1 étape****************
        return $this->json($catRepo->findAll(),200,[],['groups'=>'read_cat']);
    }

    #[Route('/api/categorie/{id}', name: 'api_one_cat')]
    // public function getOneCatApi(CategorieRepository $catRepo, SerializerInterface $seria, int $id):Response{
       
    //      $cats=$catRepo->find($id);
        
    //     $jsonCat=$seria->serialize($cats,'json',['groups'=>'read_cat']);
    //     $reponse= new Response($jsonCat,200,[
    //         'Content-Type' =>'application/json',
    //     ]);
    //     return $reponse;
    // }
    public function getOneCatApi(Categorie $category){

        return $this->json($category,200,[],['groups'=>'read_cat']);
    }

    #[Route('/api/produit', name: 'api_all_prod')]
    public function getAllProdApi(ProduitRepository $prodRepo){

        return $this->json($prodRepo->findAll(),200,[] ,['groups'=>'read_cat']);
    }

    #[Route('/api/produit/{id}', name:'api_one_prod')]
    public function getOneProdApi(Produit $prod){

        return $this->json($prod,200,[],['groups'=>'read_cat']);

    }
}
