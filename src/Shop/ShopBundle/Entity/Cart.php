<?php
namespace Shop\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shop\ShopBundle\Entity\Repository\CartRepository")
 * @ORM\Table(name="cart")
 */
class Cart
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
     * @ORM\Column(type="integer")
     */
    protected $date;
    
       /**
     * @ORM\Column(type="integer")
     */
    protected $active;
       /**
     * @ORM\Column(type="integer")
     */
    protected $total;
 
 
   /**
     * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $cart_items;
    
    

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
     * Set user_id
     *
     * @param integer $userId
     * @return Cart
     */
    public function setUserId($userId)
    {
        $this->user = $userId;
    
        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set date
     *
     * @param integer $date
     * @return Cart
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return integer 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Cart
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
     * Set total
     *
     * @param string $total
     * @return Cart
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return string 
     */
    public function getTotal()
    {
        return $this->total;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cart_items = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add cart_items
     *
     * @param \Shop\ShopBundle\Entity\CartItem $cartItems
     * @return Cart
     */
    public function addCartItem(\Shop\ShopBundle\Entity\CartItem $cartItems)
    {
        $this->cart_items[] = $cartItems;
    
        return $this;
    }

    /**
     * Remove cart_items
     *
     * @param \Shop\ShopBundle\Entity\CartItem $cartItems
     */
    public function removeCartItem(\Shop\ShopBundle\Entity\CartItem $cartItems)
    {
        $this->cart_items->removeElement($cartItems);
    }

    /**
     * Get cart_items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCartItems()
    {
        return $this->cart_items;
    }

    /**
     * Set user
     *
     * @param \Shop\ShopBundle\Entity\User $user
     * @return Cart
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

}