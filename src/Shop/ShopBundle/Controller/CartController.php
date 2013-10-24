<?php

namespace Shop\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Shop\ShopBundle\Entity\CartItem;
use Shop\ShopBundle\Entity\Cart;

class CartController extends Controller {

    public function cartPageAction() {
        $em = $this->getDoctrine()
                ->getManager();
        $cart = $this->init($em);
        $em->getRepository('ShopShopBundle:Product')->findAll();

        return $this->render('ShopShopBundle:CartView:cart.html.twig', array('cart' => $cart));
    }

// add functional, vede daca nu exista cart item, adauga, altfel update la quantity. Adaugat si modificare la Total cart 18:48 16.10.2013
    public function addAction() {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ShopShopBundle:Product')->find($_POST['id']);
        if (isset($_POST['quantity'])) {
            if ($_POST['quantity'] >= 1 && $_POST['quantity'] <= $product->getStock()) {
                $this->get('session')->getFlashBag()->add('notice-success', 'Product added to cart');
                $quantity = $_POST['quantity'];
            } else if ($_POST['quantity'] != '') {
                $this->get('session')->getFlashBag()->add('notice-failure', 'Invalid quantity in stock 1 product added.');
                $quantity = 1;
            } else {
                $this->get('session')->getFlashBag()->add('notice-success', 'Product added to cart');
                $quantity = 1;
            }
        }

        $cart = $this->init($em);
        $cartItem = new CartItem();
        $cartItem = $cartItem->newItem($product, $_POST['price'], $_POST['title'], $cart, $quantity);
        if (!$this->updateAction($quantity)) {
            $cart->addCartItem($cartItem);
            $em->flush();
            $this->updateCartTotal();

            return $this->redirect($this->getRequest()->headers->get("referer"));
        } else {
            $em->flush();

            return $this->redirect($this->getRequest()->headers->get("referer"));
        }
    }

// trimite id cartitem(vezi ruta din category.html.twig), executa query care cauta in CartItem si sterge dupa id. Functionala la 20:07, 15.10.2013
    public function removeAction($id) {
        $em = $this->getDoctrine()->getManager();
        $cart = $this->init($em);
        $em->getRepository('ShopShopBundle:CartItem')->removeItems($id);
        if (sizeof($cart->getCartItems()) == 0) {
            $cart->setTotal(0);
        }
        $this->updateCartTotal();

        return $this->redirect($this->getRequest()->headers->get("referer"));
    }

// porneste din pagina de cart, lucreaza in functie de submitul selectat. Clear sterge cartItems prin query,
//  update face update la cartitemul selectat.
    public function updateCartAction() {
        $em = $this->getDoctrine()->getManager();
        $cart = $this->init($em);
        $i = 0;
//        $em->getRepository('ShopShopBundle:Product')->findAll();
        if (isset($_POST['clear'])) {

            $em->getRepository('ShopShopBundle:CartItem')->clearCart($cart->getId());
            $this->updateCartTotal();
        } elseif (isset($_POST['update'])) {
            foreach ($_POST['prodid'] as $i){
                 $cartitem= $em->getRepository('ShopShopBundle:CartItem')->find($i);
                 $qty=(int)$_POST['prodqty'][$i];
                 if ($qty > $cartitem->getProductId()->getStock()){
                     $qty=$cartitem->getProductId()->getStock();
                     $this->get('session')->getFlashBag()->add('notice-failure', 'Invalid quantity for product: \''.$cartitem->getProductId()->getTitle().'\' maximum of stock added.');
                 }else{
                     $this->get('session')->getFlashBag()->add('notice-success', 'Updated quantity for product : \''.$cartitem->getProductId()->getTitle().'\'');
                 }
                 $cartitem->setQuantity($qty);
            }
            $this->updateCartTotal();
            $em->flush();
        }

        return $this->redirect($this->getRequest()->headers->get("referer"));
    }

// trece totalul pe 0 si recalculeaza in functie de ce obiecte sunt in cart. Merge asa ca nu stie sa faca scadere. functional 14:23, 17.10.2013    
    public function updateCartTotal() {
        $em = $this->getDoctrine()->getManager();
        $cart = $this->init($em);
        $total = 0;
        foreach ($cart->getCartItems() as $item) {
            $total = $total + $item->getQuantity() * $item->getPrice();
        }
        $cart->setTotal($total);
        $em->flush();

        return $cart->getTotal();
    }

    // modificat, verifica daca produsul e in cart si ii modifica atributul quantity. Verifica daca ce ii ceri e peste ce exista in stock. 
    // functional 14:27, 17.10.2013 
    public function updateAction($add = false) {
        $i = 0;
        $total = 0;
        $em = $this->getDoctrine()->getManager();
        $cart = $this->init($em);
        foreach ($cart->getCartItems() as $item) {
            $i++;
            if ($add == false) { //// in ramura asta nu intra niciodata?
                //  add vine tot timpul cu valoarea lui quantity, care e 1 din pagina de category si cat ii dai in forma pe pagina de produs 
                // merge fara probleme desi e un die in el.
                if ($item->getProductId()->getId() == $_POST['id'][$i]) {
                    $item->setQuantity($_POST['quantity'][$i]);
                    $total = $total + $item->getQuantity($_POST['quantity'][$i]) * $item->getPrice($_POST['quantity'][$i]);
                    $cart->setTotal($total);
                    $em->flush();
                    return $this->redirect($this->getRequest()->headers->get("referer"));
                }
            } elseif ($item->getProductId()->getId() == $_POST['id']) {
                if ($item->getQuantity() + $add > $item->getProductId()->getStock() || $item->getQuantity() == $item->getProductId()->getStock()) {
                    $this->get('session')->getFlashBag()->add('notice-failure', 'Insufficient quantity in stock.');
                } else {
                    $this->get('session')->getFlashBag()->add('notice-success', 'Product added to cart');
                    $item->setQuantity($item->getQuantity() + $add);
                    $this->updateCartTotal();
                }

                return true;
            }
        }
    }

    protected function init($em) {
        $cart = $em->getRepository('ShopShopBundle:Cart')->getCartForUser($this->getUser());
        if (sizeof($cart) != 0) {
            $cart = $cart[0];
        } elseif (isset($_SESSION['cart'])) {
            $cart = $em->getRepository('ShopShopBundle:Cart')->findBy(array('id' => $_SESSION['cart']));
            $cart = $cart[0];
        } else {
            $items = array();
            $cart = $em->getRepository('ShopShopBundle:Cart')->createCart(null, $em, $items);
            $_SESSION['cart'] = $cart->getId();
        }

        return $cart;
    }

    public function processFormAction() {
        if (isset($_POST['update_cart_action'])) {
            if ($_POST['update_cart_action'] == 'update_qty') {
                return $this->updateAction();
            } else {
                return $this->removeAction();
            }
        }
        if (isset($_POST['remove'])) {

            return $this->removeAction();
        }
    }

}