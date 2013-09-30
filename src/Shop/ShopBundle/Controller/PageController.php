<?php

namespace Shop\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function showproductAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('ShopShopBundle:Product')->find($id);
        
        return $this->render('ShopShopBundle:Product:product.html.twig', array(
                    'product' => $product, 'id'=>$id
        ));
       
    }
}
