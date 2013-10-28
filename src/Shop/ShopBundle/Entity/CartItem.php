<?php

namespace Shop\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Shop\ShopBundle\Entity\Repository\CartItemRepository")
 * @ORM\Table(name="cart_items")
 */
class CartItem {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="cart_items")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    protected $cart;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product", referencedColumnName="id")
     */
    protected $product;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @ORM\Column(type="string")
     */
    protected $price;

    public function newItem($product, $price = null, $title = null, $cart = null, $quantity) {
        $cartItem = new CartItem();
        $cartItem->setPrice($price);
        $cartItem->setTitle($title);
        $cartItem->setQuantity($quantity);
        $cartItem->setCart($cart);
        $cartItem->setProduct($product);
        return $cartItem;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return CartItem
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return CartItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return CartItem
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set cart
     *
     * @param \Shop\ShopBundle\Entity\Cart $cart
     * @return CartItem
     */
    public function setCart(\Shop\ShopBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;
    
        return $this;
    }

    /**
     * Get cart
     *
     * @return \Shop\ShopBundle\Entity\Cart 
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set product_id
     *
     * @param \Shop\ShopBundle\Entity\Product $productId
     * @return CartItem
     */


    /**
     * Set product
     *
     * @param \Shop\ShopBundle\Entity\Product $product
     * @return CartItem
     */
    public function setProduct(\Shop\ShopBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Shop\ShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}