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

}
