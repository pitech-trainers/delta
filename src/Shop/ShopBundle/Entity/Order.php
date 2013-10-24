<?php
namespace Shop\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shop\ShopBundle\Entity\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;
    /**
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="billing_address", referencedColumnName="id")
     */
    protected $billing_address;
    /**
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="shipping_address", referencedColumnName="id")
     */
    protected $shipping_address;
    /**
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="cart_items")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    protected $cart;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $date;
    /**
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     */
    protected $state;
    /**
     * @ORM\ManyToOne(targetEntity="ShippingMethod")
     * @ORM\JoinColumn(name="shipping_method", referencedColumnName="id")
     */
    protected $shipping_method;
    /**
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @ORM\JoinColumn(name="payment_method", referencedColumnName="id")
     */
    protected $payment_method;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $active;
    


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
     * Set date
     *
     * @param string $date
     * @return Order
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Order
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set user
     *
     * @param \Shop\ShopBundle\Entity\User $user
     * @return Order
     */
    public function setUser(\Shop\ShopBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Shop\ShopBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set billing_address
     *
     * @param \Shop\ShopBundle\Entity\Address $billingAddress
     * @return Order
     */
    public function setBillingAddress(\Shop\ShopBundle\Entity\Address $billingAddress = null)
    {
        $this->billing_address = $billingAddress;
    
        return $this;
    }

    /**
     * Get billing_address
     *
     * @return \Shop\ShopBundle\Entity\Address 
     */
    public function getBillingAddress()
    {
        return $this->billing_address;
    }

    /**
     * Set shipping_address
     *
     * @param \Shop\ShopBundle\Entity\Address $shippingAddress
     * @return Order
     */
    public function setShippingAddress(\Shop\ShopBundle\Entity\Address $shippingAddress = null)
    {
        $this->shipping_address = $shippingAddress;
    
        return $this;
    }

    /**
     * Get shipping_address
     *
     * @return \Shop\ShopBundle\Entity\Address 
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }

    /**
     * Set cart
     *
     * @param \Shop\ShopBundle\Entity\Cart $cart
     * @return Order
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
     * Set state
     *
     * @param \Shop\ShopBundle\Entity\State $stateId
     * @return Order
     */
    public function setState(\Shop\ShopBundle\Entity\State $state = null)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return \Shop\ShopBundle\Entity\State 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set shipping_method
     *
     * @param \Shop\ShopBundle\Entity\ShippingMethod $shippingMethod
     * @return Order
     */
    public function setShippingMethod(\Shop\ShopBundle\Entity\ShippingMethod $shippingMethod = null)
    {
        $this->shipping_method = $shippingMethod;
    
        return $this;
    }

    /**
     * Get shipping_method
     *
     * @return \Shop\ShopBundle\Entity\ShippingMethod 
     */
    public function getShippingMethod()
    {
        return $this->shipping_method;
    }

    /**
     * Set payment_method
     *
     * @param \Shop\ShopBundle\Entity\PaymentMethod $paymentMethod
     * @return Order
     */
    public function setPaymentMethod(\Shop\ShopBundle\Entity\PaymentMethod $paymentMethod = null)
    {
        $this->payment_method = $paymentMethod;
    
        return $this;
    }

    /**
     * Get payment_method
     *
     * @return \Shop\ShopBundle\Entity\PaymentMethod 
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }
    
    public function processOrder($state)
    {
        $this->state=$state;
    }
}