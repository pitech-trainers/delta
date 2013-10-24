<?php

namespace Shop\ShopBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Shop\ShopBundle\Entity\Address as address;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Shop\ShopBundle\Form\Type\AddressFormType as addressform;

class DashboardController extends Controller
{
    public function show_shippingAction(Request $request)
    {

        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
            if($user->getShippingAddress()== null){            
                $ADDRESS=new address;              
            }else{
                $ADDRESS =$user->getShippingAddress();
            }

            $form = $this->createForm(new addressform, $ADDRESS);
            $em = $this->getDoctrine()->getManager();
            $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
            if ('POST' === $request->getMethod()) {
            $post=$request->request->get('address_form_type');
            $form->bind($request);
            if ($form->isValid()) {
                if($ADDRESS->getId() != null){
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('notice-success', 'Shipping adress saved');
                    
                }else{
                    $address = new \Shop\ShopBundle\Entity\Address();
                    $address->setAddress($post['address']);
                    $address->setCity($post['city']);
                    $address->setCountry($post['country']);
                    $address->setFirstname($post['firstname']);
                    $address->setLastname($post['lastname']);
                    $address->setEmail($post['email']);
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
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
            if($user->getBillingAddress()== null){            
                $ADDRESS=new address;              
            }else{
                $ADDRESS =$user->getBillingAddress();
            }

            $form = $this->createForm(new \Shop\ShopBundle\Form\Type\AddressFormType(), $ADDRESS);
            $em = $this->getDoctrine()->getManager();
            $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
            if ('POST' === $request->getMethod()) {
            $post=$request->request->get('address_form_type');
            $form->bind($request);
            if ($form->isValid()) {
                if($ADDRESS->getId() != null){
                    $em->flush();
                     $this->get('session')->getFlashBag()->add('notice-success', 'Billing adress saved');
                    
                }else{
                    $address = new \Shop\ShopBundle\Entity\Address();
                    $address->setAddress($post['address']);
                    $address->setCity($post['city']);
                    $address->setCountry($post['country']);
                    $address->setFirstname($post['firstname']);
                    $address->setLastname($post['lastname']);
                    $address->setEmail($post['email']);
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
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
            $em = $this->getDoctrine()->getManager();
            $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
            $orders = $em->getRepository('ShopShopBundle:Order')->getAllForUser($user);
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                    $orders, $this->get('request')->query->get('page', 1)/* page number */, 3/* limit per page */
        );
            return $this->render('ShopShopBundle:Dashboard:orders.html.twig',array('orders'=>$pagination,'user'=>$user,'cart'=>$cart));
    }
    
    public function viewOrderAction($ordid)
    {

        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
            $em = $this->getDoctrine()->getManager();
            $cart=$em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em,$user);
            $order = $em->getRepository('ShopShopBundle:Order')->getByIdForUser($user,$ordid);
            return $this->render('ShopShopBundle:Dashboard:review.html.twig',array('order'=>$order,'user'=>$user,'cart'=>$cart));
    }
}
