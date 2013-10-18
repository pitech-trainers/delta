<?php

namespace Shop\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Shop\ShopBundle\Form\ProductType;

class PageController extends Controller {

    public function showproductAction($id, $productid) {

        $em = $this->getDoctrine()->getManager();
        $em->getRepository('ShopShopBundle:Product')->findAll();
        $user=$this->container->get('security.context')->getToken()->getUser();
        $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
        $category = $em->getRepository('ShopShopBundle:Category')->find($id);
        $products = $em->getRepository('ShopShopBundle:Product')->find($productid);

        foreach ($products as $product) {
            $categories = $em->getRepository('ShopShopBundle:Category')->getName($product->getId());
        }

        $random = $em->getRepository('ShopShopBundle:Product')->getRandom($id);

        $form = $this->createForm(new ProductType(), $products);
        
        return $this->render('ShopShopBundle:Product:product.html.twig', array(
                    'product' => $products, 'id' => $id, 'productid' => $productid, 'random' => $random, 'form' => $form->createView(),'cart'=>$cart
        ));
    }

}