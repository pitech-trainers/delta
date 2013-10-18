<?php

// src/Shop/ShopBundle/Entity/User.php

namespace Shop\ShopBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string" , length=10)
     */
    protected $gender;

    /**
     * @ORM\Column(type="string", length=20)
     * 
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="20",
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=20)
     * 
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="20",
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=20)
     * 
     * @Assert\Length(
     *     max="15",
     *     minMessage="The mobile is too short.",
     *     maxMessage="The mobile is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $mobile;
    
     /**
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="shipping_address", referencedColumnName="id")
     */
    private $shippingAddress;
    
     /**
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="billing_address", referencedColumnName="id")
     */
    
    private $billingAddress;
    

    
    public function __construct() {
        parent::__construct();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Set id
     *
     * @param integer $int
     * @return integer 
     */
    public function setId($int) {
        $this->id = $int;
        
        return $this->id;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender) {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return User
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * Set shippingAddress
     *
     * @param \Shop\ShopBundle\Entity\Address $shippingAddress
     * @return User
     */
    public function setShippingAddress(\Shop\ShopBundle\Entity\Address $shippingAddress = null)
    {
        $this->shippingAddress = $shippingAddress;
    
        return $this;
    }

    /**
     * Get shippingAddress
     *
     * @return \Shop\ShopBundle\Entity\Address 
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * Set billingAddress
     *
     * @param \Shop\ShopBundle\Entity\Address $billingAddress
     * @return User
     */
    public function setBillingAddress(\Shop\ShopBundle\Entity\Address $billingAddress = null)
    {
        $this->billingAddress = $billingAddress;
    
        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return \Shop\ShopBundle\Entity\Address 
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Set cart
     *
     * @param \Shop\ShopBundle\Entity\Cart $cart
     * @return User
     */
}