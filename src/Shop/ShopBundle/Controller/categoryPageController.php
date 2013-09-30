<?php

namespace Shop\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class categoryPageController extends Controller
{
    public function showcategoryAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('ShopShopBundle:Category')->find($id);
        
        return $this->render('ShopShopBundle:Category:category.html.twig', array(
                    'category' => $category, 'id'=>$id
        ));
       
    }
}
