<?php

namespace Shop\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shop\ShopBundle\Form\ProductType;

class categoryPageController extends Controller
{
    public function showcategoryAction($id,$range,$stock)
    {   
        if($range=='1,00-49,00')
            {
            $sql1=" AND p.price BETWEEN 1 AND 50 ";
        }elseif ($range=='50,00-100,00') 
            {
             $sql1=" AND p.price BETWEEN 50 AND 100 ";
        }elseif ($range=='100,00-above') {
            $sql1=" AND p.price > 100 ";
        }else{
            $sql1="";
        }
        
        if($stock== 'available'){
            $sql2=' AND p.stock > 0 ';
        }elseif ($stock== 'soon') {
            $sql2=' AND p.stock = 0 ';
        }else{
            $sql2="";
        }
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('ShopShopBundle:Product')->findAll();
        $user=$this->container->get('security.context')->getToken()->getUser();
        $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
        $category = $em->getRepository('ShopShopBundle:Category')->find($id);
        $products = $em->createQuery("SELECT p FROM ShopShopBundle:Product p WHERE p.category_id=".$id.$sql1.$sql2);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $products, $this->get('request')->query->get('page', 1)/* page number */, 9/* limit per page */
        );
        $form = $this->createForm(new ProductType());
        
        return $this->render('ShopShopBundle:Category:category.html.twig', array(
                    'category' => $category, 'id'=>$id, 'products'=> $pagination ,'range'=>$range,'stock'=>$stock,'form'=> $form->createView(),'cart'=>$cart
        ));
       
    }
}