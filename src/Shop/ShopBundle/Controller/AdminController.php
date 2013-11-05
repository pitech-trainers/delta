<?php

namespace Shop\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller {
    
    public function userListAction(){
        
        $em = $this->getDoctrine()
                ->getManager();
        
         $users = $em->getRepository('ShopShopBundle:User')->findAll();
         $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                    $users, $this->get('request')->query->get('page', 1)/* page number */, 3/* limit per page */);
        
         return $this->render('ShopShopBundle:Admin:AdminUserList.html.twig', array('users'=>$pagination));
    }
    
    
    // trece user pe enabled = 0
    public function removeUserAction($id){
        $em = $this->getDoctrine()
                ->getManager();
        $user = $em->getRepository('ShopShopBundle:User')->find($id);
        $user->setEnabled(0);
        $em->flush();
        return $this->redirect($this->getRequest()->headers->get("referer"));
        
    }
    
} 