<?php

namespace Shop\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shop\ShopBundle\Entity\Repository\ProductRepository")
 * @ORM\Table(name="products")
 * @ORM\HasLifecycleCallbacks()
 */
class Product {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="id")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category_id;

    /**
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @ORM\Column(type="integer",length=11)
     */
    private $author_id;

    /**
     * @ORM\Column(type="string")
     */
    private $isbn;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    private $appearance_year;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $short_description;

    /**
     * @ORM\Column(type="integer", length =11)
     */
    private $stock;

    /**
     * @ORM\Column(type="integer", length=1)
     */
    private $active;

    /**
     * @ORM\Column(type="string")
     */
    private $path;

    /**
     * @ORM\Column(type="string")
     */
    private $filename;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return Product
     */
    public function setCategoryId($categoryId) {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId() {
        return $this->category_id;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set author_id
     *
     * @param integer $authorId
     * @return Product
     */
    public function setAuthorId($authorId) {
        $this->author_id = $authorId;

        return $this;
    }

    /**
     * Get author_id
     *
     * @return integer 
     */
    public function getAuthorId() {
        return $this->author_id;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     * @return Product
     */
    public function setIsbn($isbn) {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string 
     */
    public function getIsbn() {
        return $this->isbn;
    }

    /**
     * Set appearance_year
     *
     * @param integer $appearanceYear
     * @return Product
     */
    public function setAppearanceYear($appearanceYear) {
        $this->appearance_year = $appearanceYear;

        return $this;
    }

    /**
     * Get appearance_year
     *
     * @return integer 
     */
    public function getAppearanceYear() {
        return $this->appearance_year;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set short_description
     *
     * @param string $shortDescription
     * @return Product
     */
    public function setShortDescription($shortDescription) {
        $this->short_description = $shortDescription;

        return $this;
    }

    /**
     * Get short_description
     *
     * @return string 
     */
    public function getShortDescription() {
        return $this->short_description;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Product
     */
    public function setStock($stock) {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock() {
        return $this->stock;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Product
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Product
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Product
     */
    public function setFilename($filename) {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename() {
        return $this->filename;
    }


}