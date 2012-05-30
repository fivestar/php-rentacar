<?php

namespace Acme\RentacarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\RentacarBundle\Entity\Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="Acme\RentacarBundle\Entity\ReservationRepository")
 */
class Reservation
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var datetime $departureAt
     *
     * @ORM\Column(name="departure_at", type="datetime", nullable=false)
     * @Assert\NotBlank(groups={"reservation_location"})
     * @Assert\DateTime(groups={"reservation_location"})
     */
    private $departureAt;

    /**
     * @var datetime $returnAt
     *
     * @ORM\Column(name="return_at", type="datetime", nullable=false)
     * @Assert\NotBlank(groups={"reservation_location"})
     * @Assert\DateTime(groups={"reservation_location"})
     */
    private $returnAt;

    /**
     * @var boolean $useInsurance
     *
     * @ORM\Column(name="use_insurance", type="boolean", nullable=false)
     */
    private $useInsurance;

    /**
     * @var decimal $carSubtotal
     *
     * @ORM\Column(name="car_subtotal", type="decimal", nullable=true)
     */
    private $carSubtotal;

    /**
     * @var decimal $optionSubtotal
     *
     * @ORM\Column(name="option_subtotal", type="decimal", nullable=true)
     */
    private $optionSubtotal;

    /**
     * @var decimal $totalAmount
     *
     * @ORM\Column(name="total_amount", type="decimal", nullable=true)
     */
    private $totalAmount;

    /**
     * @var text $note
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var CarClass
     *
     * @ORM\ManyToOne(targetEntity="CarClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="car_class_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(groups={"reservation_car"})
     */
    private $carClass;

    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departure_location_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(groups={"reservation_location"})
     */
    private $departureLocation;

    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="return_location_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank(groups={"reservation_location"})
     */
    private $returnLocation;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->departureAt = new \DateTime();
        $this->departureAt->setTime(0, 0);
        $this->returnAt = new \DateTime('+1 day');
        $this->returnAt->setTime(0, 0);
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
     * Set departureAt
     *
     * @param datetime $departureAt
     */
    public function setDepartureAt($departureAt)
    {
        $this->departureAt = $departureAt;
    }

    /**
     * Get departureAt
     *
     * @return datetime 
     */
    public function getDepartureAt()
    {
        return $this->departureAt;
    }

    /**
     * Set returnAt
     *
     * @param datetime $returnAt
     */
    public function setReturnAt($returnAt)
    {
        $this->returnAt = $returnAt;
    }

    /**
     * Get returnAt
     *
     * @return datetime 
     */
    public function getReturnAt()
    {
        return $this->returnAt;
    }

    /**
     * Set useInsurance
     *
     * @param boolean $useInsurance
     */
    public function setUseInsurance($useInsurance)
    {
        $this->useInsurance = $useInsurance;
    }

    /**
     * Get useInsurance
     *
     * @return boolean 
     */
    public function getUseInsurance()
    {
        return $this->useInsurance;
    }

    /**
     * Set carSubtotal
     *
     * @param decimal $carSubtotal
     */
    public function setCarSubtotal($carSubtotal)
    {
        $this->carSubtotal = $carSubtotal;
    }

    /**
     * Get carSubtotal
     *
     * @return decimal 
     */
    public function getCarSubtotal()
    {
        return $this->carSubtotal;
    }

    /**
     * Set optionSubtotal
     *
     * @param decimal $optionSubtotal
     */
    public function setOptionSubtotal($optionSubtotal)
    {
        $this->optionSubtotal = $optionSubtotal;
    }

    /**
     * Get optionSubtotal
     *
     * @return decimal 
     */
    public function getOptionSubtotal()
    {
        return $this->optionSubtotal;
    }

    /**
     * Set totalAmount
     *
     * @param decimal $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * Get totalAmount
     *
     * @return decimal 
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set note
     *
     * @param text $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Get note
     *
     * @return text 
     */
    public function getNote()
    {
        return $this->note;
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
     * Set user
     *
     * @param Acme\RentacarBundle\Entity\User $user
     */
    public function setUser(\Acme\RentacarBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Acme\RentacarBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set carClass
     *
     * @param Acme\RentacarBundle\Entity\CarClass $carClass
     */
    public function setCarClass(\Acme\RentacarBundle\Entity\CarClass $carClass)
    {
        $this->carClass = $carClass;
    }

    /**
     * Get carClass
     *
     * @return Acme\RentacarBundle\Entity\CarClass 
     */
    public function getCarClass()
    {
        return $this->carClass;
    }

    /**
     * Set departureLocation
     *
     * @param Acme\RentacarBundle\Entity\Location $departureLocation
     */
    public function setDepartureLocation(\Acme\RentacarBundle\Entity\Location $departureLocation)
    {
        $this->departureLocation = $departureLocation;
    }

    /**
     * Get departureLocation
     *
     * @return Acme\RentacarBundle\Entity\Location 
     */
    public function getDepartureLocation()
    {
        return $this->departureLocation;
    }

    /**
     * Set returnLocation
     *
     * @param Acme\RentacarBundle\Entity\Location $returnLocation
     */
    public function setReturnLocation(\Acme\RentacarBundle\Entity\Location $returnLocation)
    {
        $this->returnLocation = $returnLocation;
    }

    /**
     * Get returnLocation
     *
     * @return Acme\RentacarBundle\Entity\Location 
     */
    public function getReturnLocation()
    {
        return $this->returnLocation;
    }

    /**
     * Calculate amount.
     */
    public function calculateAmount()
    {
        $diff = $this->returnAt->diff($this->departureAt);

        $hours = ($diff->days * 24) + $diff->h + ($diff->i ? 1 : 0);
        $days = floor($hours / 24);
        $hours = $hours % 24;

        // car subtotal
        $carSubtotal = 0;
        if ($days > 0) {
            $carSubtotal += ($days * $this->carClass->getPrice24());
        }
        if ($hours > 12) {
            $carSubtotal += $this->carClass->getPrice24();
        } elseif ($hours > 6) {
            $carSubtotal += $this->carClass->getPrice12();
        } elseif ($hours > 3) {
            $carSubtotal += $this->carClass->getPrice6();
        } elseif ($hours > 0) {
            $carSubtotal += $this->carClass->getPrice3();
        }

        // option subtotal
        $optionSubtotal = 0;
        if ($this->useInsurance) {
            $optionSubtotal += ($days + ($hours > 0 ? 1 : 0)) * $this->carClass->getInsurancePrice();
        }

        $this->carSubtotal = $carSubtotal;
        $this->optionSubtotal = $optionSubtotal;
        $this->totalAmount = $carSubtotal + $optionSubtotal;
    }
}