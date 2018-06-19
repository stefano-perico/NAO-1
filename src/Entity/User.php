<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity(fields={"firstName","lastName"})
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=35, nullable=false)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=35, nullable=false)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $registrationDate;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="author")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="author")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $image;

    public function __construct()
    {
        if ($this->registrationDate === null){
            $this->setRegistrationDate(new \DateTime());
        }
        $this->articles = new ArrayCollection();
        $this->event = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = md5($password);

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary):self
    {
        $this->summary = $summary;
        return $this;
    }

    public function setRegistrationDate(\DateTime $registrationDate):self
    {
        $this->registrationDate = $registrationDate;
        return $this;
    }

    public function getRegistrationDate(): ?\DateTime
    {
        return $this->registrationDate;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setAuthor($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->event->contains($event)) {
            $this->event->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getAuthor() === $this) {
                $event->setAuthor(null);
            }
        }

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function __toString() {
        return $this->firstName.' '.$this->lastName;
    }

}
