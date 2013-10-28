<?php

namespace Shop\ShopBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Shop\ShopBundle\Entity\Address as Address;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Shop\ShopBundle\Form\Type\AddressFormType as addressform;

class CheckoutController extends Controller {

    public function checkoutBillingAction(Request $request) {

        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user->getBillingAddress() == null) {
            $address = new Address;
        } else {
            $address = $user->getBillingAddress();
        }

        $form = $this->createForm(new \Shop\ShopBundle\Form\Type\AddressFormType(), $address);
        if ('POST' === $request->getMethod()) {
            $post=$request->request->get('address_form_type');
            $for_shipping=$request->request->get('use_for_shipping');
            $em = $this->getDoctrine()->getManager();
            $cart = $em->getRepository('ShopShopBundle:Cart')->getGeneralCart($em, $user);
            $state = $em->getRepository('ShopShopBundle:State')->find('1');
            $order = $em->getRepository('ShopShopBundle:Order')->getOrder($em, $user,$cart,$state);
            $form->bind($request);
            if ($form->isValid()) {
                if ($address->getId() != null) {
                    $order->setBillingAddress($address);
                    $em->flush();
                } else {
//                    $address = new \Shop\ShopBundle\Entity\Address();
                    $user->setBillingAddress($address);
                    $em->persist($address);
                    $em->flush();
                }
                // not same shipping address
                if ($for_shipping == 0) {
                    return $this->redirect($this->generateUrl('shop_shop_checkout2'));

                    //same shipping address    
                } else if ($for_shipping == 1) {
                    $order->setShippingAddress($address);
                    $em->flush();
                    return $this->redirect($this->generateUrl('shop_shop_checkout3'));
                }
            }
        }
        return $this->render('ShopShopBundle:Checkout:BillingAddress.html.twig', array(
                    'form' => $form->createView()));
    }

    public function checkoutShippingAction(Request $request) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user->getShippingAddress() == null) {
            $address2 = new Address;
        } else {
            $address2 = $user->getShippingAddress();
        }

        $form = $this->createForm(new addressform, $address2);

        if ('POST' === $request->getMethod()) {
            $post=$request->request->get('address_form_type');
            $form->bind($request);
            $em = $this->getDoctrine()->getManager();
            if ($form->isValid()) {
                if ($address2->getId() != null) {
                    $em->flush();
                } else {
                    $user->setShippingAddress($address2);
                    $em->persist($address2);
                    $em->flush();
                }
                $order = $em->getRepository('ShopShopBundle:Order')->getOrder($em, $user);
                $order->setShippingAddress($address2);
                $em->flush();
                return $this->redirect($this->generateUrl('shop_shop_checkout3'));
            }
        }
        return $this->render('ShopShopBundle:Checkout:ShippingAddress.html.twig', array(
                    'form' => $form->createView()));
    }

    public function shippingMethodAction(Request $request) {
       
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ('POST' === $request->getMethod()) {
            $em = $this->getDoctrine()->getManager();
            $order = $em->getRepository('ShopShopBundle:Order')->getOrder($em, $user);
            $shippingMethod = $em->getRepository('ShopShopBundle:ShippingMethod')->find($_POST['shipping_method']);
            $order->setShippingmethod($shippingMethod);
            $em->flush();   
            return $this->redirect($this->generateUrl('shop_shop_checkout4'));
        }
        return $this->render('ShopShopBundle:Checkout:ShippingMethod.html.twig');
    }

    public function paymentMethodAction(Request $request) {
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ('POST' === $request->getMethod()) {
            $em = $this->getDoctrine()->getManager();
            $order = $em->getRepository('ShopShopBundle:Order')->getOrder($em, $user);
            $payment = $em->getRepository('ShopShopBundle:paymentMethod')->find($_POST['payment_method']);
            $order->setpaymentmethod($payment);
            $em->flush();  
            return $this->redirect($this->generateUrl('shop_shop_checkout5'));
        }
        return $this->render('ShopShopBundle:Checkout:PaymentMethod.html.twig');
    }

    public function reviewAction(Request $request) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('ShopShopBundle:Order')->getOrder($em, $user);
        
        if ('POST' === $request->getMethod()) {
            $o=$post=$request->request->get('order');
            $c=$post=$request->request->get('cancel');
            if($c!=null){
                $order->setActive(0);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice-success', 'Order deleted.');
                return $this->redirect($this->generateUrl('shop_shop_homepage'));
            }
            if($o!=null){
                $state = $em->getRepository('ShopShopBundle:State')->find($order->getState()->getId()+1);
                $order->processOrder($state);
                $items=$order->getCart()->getCartItems();
                foreach ($items as $item){
                    $item->getProduct()->setStock($item->getProduct()->getStock()-$item->getQuantity());
                }
                $em->flush();
                $em->getRepository(('ShopShopBundle:Cart'))->createCart($user,$em);
                 $this->get('session')->getFlashBag()->add('notice-success', 'Order placed, your order number is : '.$order->getid().'. You can check it anytime at your dashboard.');
                return $this->redirect($this->generateUrl('shop_shop_homepage'));
            }
               
        }
        return $this->render('ShopShopBundle:Checkout:Review.html.twig',array(
                    'order' => $order));
    }

}