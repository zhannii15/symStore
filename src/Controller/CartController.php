<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(ProduitRepository $prodRepo, RequestStack $request ): Response
    {
        //transformer le prodId et Qtité en nameProd
        // balai => (1.5*3) =4.50€
        //il faut les infos sur les produits contenus dans le panier
        $panierDetail=[]; //contiendra les infos de chaque produit du panier
        $session=$request->getSession();
        $panier=$session->get('panier',[]);

        // parcourier le tableau du panier

        foreach($panier as $prodId=>$qtite){
            $panierDetail[]=[
                'prod'=>$prodRepo->find($prodId),//object Product avec les infos du produit
                'qtite'=>$qtite,// quantité du produit dans le panier
            ];
        }
        //total panier 
        //somme total de chaQUE LIGNE DE PANIER
        $total=0;
        foreach($panierDetail as $item){
            $total+=$item['prod']->getPrix()* $item['qtite'];
        }
        // dd($panier,$panierDetail);

        return $this->render('cart/index.html.twig', [
            'cartData'=>$panierDetail,
            'total'=>$total,
        ]);
    }
    #[Route('/cart/add/{id}',name:'cart_add')]
    public function add(int $id, RequestStack $request):Response{
        //Obtenir la session($_SESSION[])
        $session=$request->getSession();

        //panier= ['prodId'=>Qtité]

        //Obtenir le panier ou bien si panier not exist
        // on nous renvoie un tableau vide []
        $panier=$session->get('panier',[]);

        //Ajouter le produit dans le panier
        if(!empty($panier[$id])){
            $panier[$id]++;
        }
        else{
            $panier[$id]=1;
        }
        //replacer le panier dans $_SESSION
        $session->set('panier',$panier);
        //dd($session->get('panier',[]));
        return $this->redirectToRoute('cart_index');    
    }
    #[Route('/cart/del/{id}', name:'cart_del')]
    public function del(int $id, RequestStack $req):Response{
        $session=$req->getSession();
        $panier=$session->get('panier',[]);

        if(!empty($panier[$id])){
            unset($panier[$id]);
            $session->set('panier',$panier);
        }
        // dd($session->get('panier',[]));
        return $this->redirectToRoute('cart_index');
    }
    #[Route('/cart/decremente/{id}',name:'cart_decremente')]
    public function decremente(int $id,RequestStack $requ):Response{
        $session=$requ->getSession();
        $panier=$session->get('panier',[]);

        if(!empty($panier[$id])){
            $panier[$id]--;
        }
        else{
            $panier[$id]=0;
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('cart_index');
    }
}
