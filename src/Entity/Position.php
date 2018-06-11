<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PositionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Position
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VillesFranceFree")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="ville_id", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatetedAt;

    public function getId()
    {
        return $this->id;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getAddress(): ?VillesFranceFree
    {
        return $this->address;
    }

    public function setAddress(?VillesFranceFree $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function getUpdatetedAt()
    {
        return $this->updatetedAt;
    }

    /**
     * @ORM\PreFlush()
     */
    public function PreFlushDate()
    {
        null === $this->date || empty($this->date) ?
            $this->date = new \DateTime():
            null;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function PreUpdateDate()
    {
        $this->updatetedAt = new \DateTime();
    }
}
