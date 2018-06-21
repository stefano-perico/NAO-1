<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @Vich\Uploadable()
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Vich\UploadableField(
     *     mapping="image",
     *     fileNameProperty="image.name",
     *     size="image.size",
     *     mimeType="image.mimeType",
     *     originalName="image.originalName",
     *     dimensions="image.dimensions"
     * )
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     * @var EmbeddedFile
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $section;

    public function __construct()
    {
        $this->image = new EmbeddedFile();
    }

    /**
     * @param File|UploadedFile $image
     * @throws \Exception
     */
    public function setImageFile(?File $image =null)
    {
        $this->imageFile = $image;

        if (null !== $image){
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(EmbeddedFile $image)
    {
        $this->image = $image;
    }

    public function getImage(): ?EmbeddedFile
    {
        return $this->image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt):self
    {
        $this->alt = $alt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getSection()
    {
        return $this->section;
    }

    public function setSection(string $section):self
    {
        $this->section = $section;
        return $this;
    }

    /**
     * @ORM\PreFlush()
     * @ORM\PreUpdate()
     */
    public function originalNamePreFlush()
    {
        null === $this->alt || empty($this->alt) ?
            $this->alt = $this->image->getOriginalName() :
            null;
    }

    /**
     * @ORM\PreFlush()
     */
    public function sectionPreFlush()
    {
        null === $this->section || empty($this->section) ?
            $this->section = 'visitor' :
            null;
    }

}