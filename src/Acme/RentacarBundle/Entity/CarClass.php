<?php

namespace Acme\RentacarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Acme\RentacarBundle\Entity\CarClass
 *
 * @ORM\Table(name="car_class")
 * @ORM\Entity
 */
class CarClass
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var string $carTypes
     *
     * @ORM\Column(name="car_types", type="string", length=100, nullable=false)
     */
    private $carTypes;

    /**
     * @var string $seats
     *
     * @ORM\Column(name="seats", type="string", length=20, nullable=false)
     */
    private $seats;

    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var decimal $price3
     *
     * @ORM\Column(name="price3", type="decimal", nullable=false)
     */
    private $price3;

    /**
     * @var decimal $price6
     *
     * @ORM\Column(name="price6", type="decimal", nullable=false)
     */
    private $price6;

    /**
     * @var decimal $price12
     *
     * @ORM\Column(name="price12", type="decimal", nullable=false)
     */
    private $price12;

    /**
     * @var decimal $price24
     *
     * @ORM\Column(name="price24", type="decimal", nullable=false)
     */
    private $price24;

    /**
     * @var decimal $insurancePrice
     *
     * @ORM\Column(name="insurance_price", type="decimal", nullable=false)
     */
    private $insurancePrice;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;


    /**
     * Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set carTypes
     *
     * @param string $carTypes
     */
    public function setCarTypes($carTypes)
    {
        $this->carTypes = $carTypes;
    }

    /**
     * Get carTypes
     *
     * @return string 
     */
    public function getCarTypes()
    {
        return $this->carTypes;
    }

    /**
     * Set seats
     *
     * @param string $seats
     */
    public function setSeats($seats)
    {
        $this->seats = $seats;
    }

    /**
     * Get seats
     *
     * @return string 
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set price3
     *
     * @param decimal $price3
     */
    public function setPrice3($price3)
    {
        $this->price3 = $price3;
    }

    /**
     * Get price3
     *
     * @return decimal 
     */
    public function getPrice3()
    {
        return $this->price3;
    }

    /**
     * Set price6
     *
     * @param decimal $price6
     */
    public function setPrice6($price6)
    {
        $this->price6 = $price6;
    }

    /**
     * Get price6
     *
     * @return decimal 
     */
    public function getPrice6()
    {
        return $this->price6;
    }

    /**
     * Set price12
     *
     * @param decimal $price12
     */
    public function setPrice12($price12)
    {
        $this->price12 = $price12;
    }

    /**
     * Get price12
     *
     * @return decimal 
     */
    public function getPrice12()
    {
        return $this->price12;
    }

    /**
     * Set price24
     *
     * @param decimal $price24
     */
    public function setPrice24($price24)
    {
        $this->price24 = $price24;
    }

    /**
     * Get price24
     *
     * @return decimal 
     */
    public function getPrice24()
    {
        return $this->price24;
    }

    /**
     * Set insurancePrice
     *
     * @param decimal $insurancePrice
     */
    public function setInsurancePrice($insurancePrice)
    {
        $this->insurancePrice = $insurancePrice;
    }

    /**
     * Get insurancePrice
     *
     * @return decimal 
     */
    public function getInsurancePrice()
    {
        return $this->insurancePrice;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * __toString().
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->name;
    }
}