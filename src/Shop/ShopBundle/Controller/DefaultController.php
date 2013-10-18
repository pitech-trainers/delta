<?php

namespace Shop\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ShopShopBundle:Product')->getLatestProducts();

        foreach($products as $product){
             $categories = $em->getRepository('ShopShopBundle:Category')->getName($product->getId());
             
        }
           

        return $this->render('ShopShopBundle:Homepage:index.html.twig', array(
                    'products' => $products
        ));
    }
    public function searchAction($txt) {

        $em = $this->getDoctrine()->getManager();
        $products = $em->createQuery("SELECT p FROM ShopShopBundle:Product p WHERE p.title like %".$txt."%");
        
        $x = empty($products);
        if ($x) {
            $response = "No suggestion" ."</br>";
            echo $response;
        }

        foreach ($products as $prod) {
            $response = "<li> <a href=". url("product/prodInfo", array("pid"=>$prod->getId())) . "><h6>".  $prod->getTitle(). "</h6></a></li>";
            echo $response."</br>";
        }
        
    }
    

       

}
