<?php

namespace App\Controller;

use App\service\cart\CartService;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    protected $CartService;

    public function __construct(CartService $CartService){

        $this->CartService=$CartService;
    }
    
    #[Route('/cart', name: 'cart_index')]
    public function index(): Response
    {
        // infos complètes produits
        //pour simplifier on peut mettre cette phrase dans le return
        // $panierDetail=$this->CartService->getFullCart();
        
        //total panier 
        //somme total de chaQUE LIGNE DE PANIER
        //pour simplifier on peut mettre cette phrase dans le return
        // $totalCart=$this->CartService->getCartTotal();
        // dd($panier,$panierDetail);
        return $this->render('cart/index.html.twig', [
            'cartData'=>$this->CartService->getFullCart(),
            'total'=>$this->CartService->getCartTotal(),
        ]);
    }

    #[Route('/cart/add/{id}',name:'cart_add')]
    public function add(int $id):Response{

        $this->CartService->add($id);
   
        return $this->redirectToRoute('cart_index');    
    }

    #[Route('/cart/del/{id}', name:'cart_del')]
    public function del(int $id):Response{

        $this->CartService->del($id);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/decremente/{id}',name:'cart_decremente')]
    public function decremente(int $id):Response{
       
        $this->CartService->decremente($id);

        return $this->redirectToRoute('cart_index');
    }
}
