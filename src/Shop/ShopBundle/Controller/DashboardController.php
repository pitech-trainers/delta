<?php

namespace Shop\ShopBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Shop\ShopBundle\Entity\Address as Address;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Shop\ShopBundle\Form\Type\AddressFormType as addressform;

class DashboardController extends Controller
{
    public function show_shippingAction(Request $request)
    {

        $user = $this->container->get('security.context')->getToken()->getUser();
            if($user->getShippingAddress()== null){            
                $address=new Address;              
            }else{
                $address =$user->getShippingAddress();
            }

            $form = $this->createForm(new addressform, $address);
            $em = $this->getDoctrine()->getManager();
            $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
            if ('POST' === $request->getMethod()) {
            $post=$request->request->get('address_form_type');
            $form->bind($request);
            if ($form->isValid()) {
                if($address->getId() != null){
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('notice-success', 'Shipping adress saved');
                    
                }else{
                    $user->setShippingAddress($address);
                    $em->persist($address);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('notice-success', 'Shipping adress saved');
                }
  
            }else{
                $this->get('session')->getFlashBag()->add('notice-failure', 'Cannot save shipping information.');
            }
        }
            return $this->render('ShopShopBundle:Dashboard:shipping.html.twig', array(
                    'form' => $form->createView(),'cart'=>$cart));
    }
    
    public function show_billingAction(Request $request)
    {

        $user = $this->container->get('security.context')->getToken()->getUser();
            if($user->getBillingAddress()== null){            
                $address=new Address;              
            }else{
                $address =$user->getBillingAddress();
            }

            $form = $this->createForm(new \Shop\ShopBundle\Form\Type\AddressFormType(), $address);
            $em = $this->getDoctrine()->getManager();
            $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
            if ('POST' === $request->getMethod()) {
            $post=$request->request->get('address_form_type');
            $form->bind($request);
            if ($form->isValid()) {
                if($address->getId() != null){
                    $em->flush();
                     $this->get('session')->getFlashBag()->add('notice-success', 'Billing adress saved');
                    
                }else{
                    $user->setBillingAddress($address);
                    $em->persist($address);
                    $em->flush();
                     $this->get('session')->getFlashBag()->add('notice-success', 'Billing adress saved');
                }
            }else{
                $this->get('session')->getFlashBag()->add('notice-failure', 'Cannot save billing information.');
            }
        }
            return $this->render('ShopShopBundle:Dashboard:billing.html.twig', array(
                    'form' => $form->createView(),'cart'=>$cart));
    }
    public function show_ordersAction()
    {

        $user = $this->container->get('security.context')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();
            $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
            $orders = $em->getRepository('ShopShopBundle:Order')->getAllForUser($user);
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                    $orders, $this->get('request')->query->get('page', 1)/* page number */, 3/* limit per page */
        );
            return $this->render('ShopShopBundle:Dashboard:orders.html.twig',array('orders'=>$pagination,'user'=>$user,'cart'=>$cart));
    }
    
    public function viewOrderAction($order_id)
    {

            $user = $this->container->get('security.context')->getToken()->getUser();      
            $em = $this->getDoctrine()->getManager();
            $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
            $order = $em->getRepository('ShopShopBundle:Order')->getByIdForUser($user,$order_id);
            return $this->render('ShopShopBundle:Dashboard:review.html.twig',array('order'=>$order,'user'=>$user,'cart'=>$cart));
    }
}
