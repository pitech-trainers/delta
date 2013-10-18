<?php

namespace Shop\ShopBundle\EventListener;

use Shop\ShopBundle\Entity\Cart;
use Shop\ShopBundle\Entity\CartItem;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class LoginListener {

    protected $doctrine;

    public function __construct(Doctrine $doctrine) {
        $this->doctrine = $doctrine;
    }

    public function onLogin(InteractiveLoginEvent $event) {
        $em = $this->doctrine
                ->getManager();
        $user = $event->getAuthenticationToken()->getUser();
        $items=null;
        if(isset($_SESSION['cart'])){
            $cartid=$_SESSION['cart'];
            $cart=$em->getRepository('ShopShopBundle:Cart')->find($cartid);
            $items=$cart->getCartItems();
        }
        $em->getRepository(('ShopShopBundle:Cart'))->createCart($user,$em,$items);
    }

}