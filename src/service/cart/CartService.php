<?php
namespace App\service\cart;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

    class CartService {
        protected $session;

        public function __construct (RequestStack $request, ProduitRepository $prodRepo){
            $this->session=$request->getSession();
            $this->prodRepo=$prodRepo;
        }

        public function add(int $id){
    
            //panier= ['prodId'=>Qtité]
    
            //Obtenir le panier ou bien si panier not exist
            // on nous renvoie un tableau vide []
            $panier=$this->session->get('panier',[]);
    
            //Ajouter le produit dans le panier
            if(!empty($panier[$id])){
                $panier[$id]++;
            }
            else{
                $panier[$id]=1;
            }
            //replacer le panier dans $_SESSION
            $this->session->set('panier',$panier);
            //dd($session->get('panier',[]));
        }

        public function del(int $id){

            $panier=$this->session->get('panier',[]);
    
            if(!empty($panier[$id])){
                unset($panier[$id]);

                $this->session->set('panier',$panier);
            }
        }
        
        public function decremente(int $id){

            $panier=$this->session->get('panier',[]);
    
            if(!empty($panier[$id]==1)){
                unset($panier[$id]);
            }
            else{
                $panier[$id]--;
            }
            $this->session->set('panier',$panier);
        }

        public function getFullCart(): array{
            $panierDetail=[]; //Retoruner un panier vide.
            
            $panier=$this->session->get('panier',[]);

            foreach($panier as $prodId=>$qtite){
                $panierDetail[]=[
                    'prod'=>$this->prodRepo->find($prodId),//object Product avec les infos du produit
                    'qtite'=>$qtite,// quantité du produit dans le panier
                ];
            }
            return $panierDetail;
        }

        public function getCartTotal(){
            $totalCart=0;

            $panierDetail=$this->getFullCart();

            foreach($panierDetail as $item){

                $totalCart+=$item['prod']->getPrix()* $item['qtite'];
            }
            return $totalCart;
        }
    }