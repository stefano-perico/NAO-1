<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="date")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $UpdatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="event")
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100")
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VillesFranceFree")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="ville_id")
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $image;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location):self
    {
        $this->location = $location;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image):self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @ORM\PreFlush()
     */
    public function publishedAt()
    {
        $this->getPublishedAt() === null || empty($this->publishedAt) ?
            $this->setPublishedAt(new \DateTime()):
            null;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updatedAt()
    {
        $this->getUpdatedAt() === null ?
            $this->setUpdatedAt(new \DateTime()):
            null;
    }

    /**
     * @ORM\PreFlush()
     */
    public function slug()
    {
        $this->slug === null || empty($this->slug) ?
            $this->slug = str_replace(' ','_',$this->getTitle()):
            null;
    }

}
