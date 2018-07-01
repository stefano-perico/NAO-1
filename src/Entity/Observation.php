<?php

namespace App\Entity;

use App\Validator\Species;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObservationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Observation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Position", cascade={"Persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $checked = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $verifiedBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Taxref")
     * @ORM\JoinColumn(nullable=false)
     * @Species()
     */
    private $species;

    public function getId()
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }

    public function getVerifiedBy(): ?User
    {
        return $this->verifiedBy;
    }

    public function setVerifiedBy(?User $verifiedBy): self
    {
        $this->verifiedBy = $verifiedBy;

        return $this;
    }

    /**
     * @ORM\PreFlush()
     */
    public function PreFlushDate()
    {
        $this->date === null ?
            $this->date = new \DateTime():
            null;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function PreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getSpecies(): ?Taxref
    {
        return $this->species;
    }

    public function setSpecies(?Taxref $species): self
    {
        $this->species = $species;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCountSpecies()
    {
        $species = $this->getSpecies();
        $species->count();
    }

}
