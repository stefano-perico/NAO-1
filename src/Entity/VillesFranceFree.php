<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VillesFranceFree
 *
 * @ORM\Table(name="villes_france_free", uniqueConstraints={@ORM\UniqueConstraint(name="ville_code_commune_2", columns={"ville_code_commune"}), @ORM\UniqueConstraint(name="ville_slug", columns={"ville_slug"})}, indexes={@ORM\Index(name="ville_departement", columns={"ville_departement"}), @ORM\Index(name="ville_nom", columns={"ville_nom"}), @ORM\Index(name="ville_nom_reel", columns={"ville_nom_reel"}), @ORM\Index(name="ville_code_commune", columns={"ville_code_commune"}), @ORM\Index(name="ville_code_postal", columns={"ville_code_postal"}), @ORM\Index(name="ville_longitude_latitude_deg", columns={"ville_longitude_deg", "ville_latitude_deg"}), @ORM\Index(name="ville_nom_soundex", columns={"ville_nom_soundex"}), @ORM\Index(name="ville_nom_metaphone", columns={"ville_nom_metaphone"}), @ORM\Index(name="ville_population_2010", columns={"ville_population_2010"}), @ORM\Index(name="ville_nom_simple", columns={"ville_nom_simple"})})
 * @ORM\Entity(repositoryClass="App\Repository\VillesFranceFreeRepository")
 * @ORM\Entity
 */
class VillesFranceFree
{
    /**
     * @var int
     *
     * @ORM\Column(name="ville_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $villeId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_departement", type="string", length=3, nullable=true)
     */
    private $villeDepartement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_slug", type="string", length=255, nullable=true)
     */
    private $villeSlug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_nom", type="string", length=45, nullable=true)
     */
    private $villeNom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_nom_simple", type="string", length=45, nullable=true)
     */
    private $villeNomSimple;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_nom_reel", type="string", length=45, nullable=true)
     */
    private $villeNomReel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_nom_soundex", type="string", length=20, nullable=true)
     */
    private $villeNomSoundex;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_nom_metaphone", type="string", length=22, nullable=true)
     */
    private $villeNomMetaphone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_code_postal", type="string", length=255, nullable=true)
     */
    private $villeCodePostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_commune", type="string", length=3, nullable=true)
     */
    private $villeCommune;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_code_commune", type="string", length=5, nullable=false)
     */
    private $villeCodeCommune;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ville_arrondissement", type="smallint", nullable=true, options={"unsigned"=true})
     */
    private $villeArrondissement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_canton", type="string", length=4, nullable=true)
     */
    private $villeCanton;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ville_amdi", type="smallint", nullable=true, options={"unsigned"=true})
     */
    private $villeAmdi;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ville_population_2010", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $villePopulation2010;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ville_population_1999", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $villePopulation1999;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ville_population_2012", type="integer", nullable=true, options={"unsigned"=true,"comment"="approximatif"})
     */
    private $villePopulation2012;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ville_densite_2010", type="integer", nullable=true)
     */
    private $villeDensite2010;

    /**
     * @var float|null
     *
     * @ORM\Column(name="ville_surface", type="float", precision=10, scale=0, nullable=true)
     */
    private $villeSurface;

    /**
     * @var float|null
     *
     * @ORM\Column(name="ville_longitude_deg", type="float", precision=10, scale=0, nullable=true)
     */
    private $villeLongitudeDeg;

    /**
     * @var float|null
     *
     * @ORM\Column(name="ville_latitude_deg", type="float", precision=10, scale=0, nullable=true)
     */
    private $villeLatitudeDeg;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_longitude_grd", type="string", length=9, nullable=true)
     */
    private $villeLongitudeGrd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_latitude_grd", type="string", length=8, nullable=true)
     */
    private $villeLatitudeGrd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_longitude_dms", type="string", length=9, nullable=true)
     */
    private $villeLongitudeDms;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_latitude_dms", type="string", length=8, nullable=true)
     */
    private $villeLatitudeDms;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ville_zmin", type="integer", nullable=true)
     */
    private $villeZmin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ville_zmax", type="integer", nullable=true)
     */
    private $villeZmax;

    /**
     * @return int
     */
    public function getVilleId(): int
    {
        return $this->villeId;
    }

    /**
     * @param int $villeId
     * @return VillesFranceFree
     */
    public function setVilleId(int $villeId): VillesFranceFree
    {
        $this->villeId = $villeId;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleDepartement(): ?string
    {
        return $this->villeDepartement;
    }

    /**
     * @param null|string $villeDepartement
     * @return VillesFranceFree
     */
    public function setVilleDepartement(?string $villeDepartement): VillesFranceFree
    {
        $this->villeDepartement = $villeDepartement;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleSlug(): ?string
    {
        return $this->villeSlug;
    }

    /**
     * @param null|string $villeSlug
     * @return VillesFranceFree
     */
    public function setVilleSlug(?string $villeSlug): VillesFranceFree
    {
        $this->villeSlug = $villeSlug;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleNom(): ?string
    {
        return $this->villeNom;
    }

    /**
     * @param null|string $villeNom
     * @return VillesFranceFree
     */
    public function setVilleNom(?string $villeNom): VillesFranceFree
    {
        $this->villeNom = $villeNom;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleNomSimple(): ?string
    {
        return $this->villeNomSimple;
    }

    /**
     * @param null|string $villeNomSimple
     * @return VillesFranceFree
     */
    public function setVilleNomSimple(?string $villeNomSimple): VillesFranceFree
    {
        $this->villeNomSimple = $villeNomSimple;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleNomReel(): ?string
    {
        return $this->villeNomReel;
    }

    /**
     * @param null|string $villeNomReel
     * @return VillesFranceFree
     */
    public function setVilleNomReel(?string $villeNomReel): VillesFranceFree
    {
        $this->villeNomReel = $villeNomReel;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleNomSoundex(): ?string
    {
        return $this->villeNomSoundex;
    }

    /**
     * @param null|string $villeNomSoundex
     * @return VillesFranceFree
     */
    public function setVilleNomSoundex(?string $villeNomSoundex): VillesFranceFree
    {
        $this->villeNomSoundex = $villeNomSoundex;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleNomMetaphone(): ?string
    {
        return $this->villeNomMetaphone;
    }

    /**
     * @param null|string $villeNomMetaphone
     * @return VillesFranceFree
     */
    public function setVilleNomMetaphone(?string $villeNomMetaphone): VillesFranceFree
    {
        $this->villeNomMetaphone = $villeNomMetaphone;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleCodePostal(): ?string
    {
        return $this->villeCodePostal;
    }

    /**
     * @param null|string $villeCodePostal
     * @return VillesFranceFree
     */
    public function setVilleCodePostal(?string $villeCodePostal): VillesFranceFree
    {
        $this->villeCodePostal = $villeCodePostal;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleCommune(): ?string
    {
        return $this->villeCommune;
    }

    /**
     * @param null|string $villeCommune
     * @return VillesFranceFree
     */
    public function setVilleCommune(?string $villeCommune): VillesFranceFree
    {
        $this->villeCommune = $villeCommune;
        return $this;
    }

    /**
     * @return string
     */
    public function getVilleCodeCommune(): string
    {
        return $this->villeCodeCommune;
    }

    /**
     * @param string $villeCodeCommune
     * @return VillesFranceFree
     */
    public function setVilleCodeCommune(string $villeCodeCommune): VillesFranceFree
    {
        $this->villeCodeCommune = $villeCodeCommune;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVilleArrondissement(): ?int
    {
        return $this->villeArrondissement;
    }

    /**
     * @param int|null $villeArrondissement
     * @return VillesFranceFree
     */
    public function setVilleArrondissement(?int $villeArrondissement): VillesFranceFree
    {
        $this->villeArrondissement = $villeArrondissement;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleCanton(): ?string
    {
        return $this->villeCanton;
    }

    /**
     * @param null|string $villeCanton
     * @return VillesFranceFree
     */
    public function setVilleCanton(?string $villeCanton): VillesFranceFree
    {
        $this->villeCanton = $villeCanton;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVilleAmdi(): ?int
    {
        return $this->villeAmdi;
    }

    /**
     * @param int|null $villeAmdi
     * @return VillesFranceFree
     */
    public function setVilleAmdi(?int $villeAmdi): VillesFranceFree
    {
        $this->villeAmdi = $villeAmdi;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVillePopulation2010(): ?int
    {
        return $this->villePopulation2010;
    }

    /**
     * @param int|null $villePopulation2010
     * @return VillesFranceFree
     */
    public function setVillePopulation2010(?int $villePopulation2010): VillesFranceFree
    {
        $this->villePopulation2010 = $villePopulation2010;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVillePopulation1999(): ?int
    {
        return $this->villePopulation1999;
    }

    /**
     * @param int|null $villePopulation1999
     * @return VillesFranceFree
     */
    public function setVillePopulation1999(?int $villePopulation1999): VillesFranceFree
    {
        $this->villePopulation1999 = $villePopulation1999;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVillePopulation2012(): ?int
    {
        return $this->villePopulation2012;
    }

    /**
     * @param int|null $villePopulation2012
     * @return VillesFranceFree
     */
    public function setVillePopulation2012(?int $villePopulation2012): VillesFranceFree
    {
        $this->villePopulation2012 = $villePopulation2012;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVilleDensite2010(): ?int
    {
        return $this->villeDensite2010;
    }

    /**
     * @param int|null $villeDensite2010
     * @return VillesFranceFree
     */
    public function setVilleDensite2010(?int $villeDensite2010): VillesFranceFree
    {
        $this->villeDensite2010 = $villeDensite2010;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getVilleSurface(): ?float
    {
        return $this->villeSurface;
    }

    /**
     * @param float|null $villeSurface
     * @return VillesFranceFree
     */
    public function setVilleSurface(?float $villeSurface): VillesFranceFree
    {
        $this->villeSurface = $villeSurface;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getVilleLongitudeDeg(): ?float
    {
        return $this->villeLongitudeDeg;
    }

    /**
     * @param float|null $villeLongitudeDeg
     * @return VillesFranceFree
     */
    public function setVilleLongitudeDeg(?float $villeLongitudeDeg): VillesFranceFree
    {
        $this->villeLongitudeDeg = $villeLongitudeDeg;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getVilleLatitudeDeg(): ?float
    {
        return $this->villeLatitudeDeg;
    }

    /**
     * @param float|null $villeLatitudeDeg
     * @return VillesFranceFree
     */
    public function setVilleLatitudeDeg(?float $villeLatitudeDeg): VillesFranceFree
    {
        $this->villeLatitudeDeg = $villeLatitudeDeg;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleLongitudeGrd(): ?string
    {
        return $this->villeLongitudeGrd;
    }

    /**
     * @param null|string $villeLongitudeGrd
     * @return VillesFranceFree
     */
    public function setVilleLongitudeGrd(?string $villeLongitudeGrd): VillesFranceFree
    {
        $this->villeLongitudeGrd = $villeLongitudeGrd;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleLatitudeGrd(): ?string
    {
        return $this->villeLatitudeGrd;
    }

    /**
     * @param null|string $villeLatitudeGrd
     * @return VillesFranceFree
     */
    public function setVilleLatitudeGrd(?string $villeLatitudeGrd): VillesFranceFree
    {
        $this->villeLatitudeGrd = $villeLatitudeGrd;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleLongitudeDms(): ?string
    {
        return $this->villeLongitudeDms;
    }

    /**
     * @param null|string $villeLongitudeDms
     * @return VillesFranceFree
     */
    public function setVilleLongitudeDms(?string $villeLongitudeDms): VillesFranceFree
    {
        $this->villeLongitudeDms = $villeLongitudeDms;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVilleLatitudeDms(): ?string
    {
        return $this->villeLatitudeDms;
    }

    /**
     * @param null|string $villeLatitudeDms
     * @return VillesFranceFree
     */
    public function setVilleLatitudeDms(?string $villeLatitudeDms): VillesFranceFree
    {
        $this->villeLatitudeDms = $villeLatitudeDms;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVilleZmin(): ?int
    {
        return $this->villeZmin;
    }

    /**
     * @param int|null $villeZmin
     * @return VillesFranceFree
     */
    public function setVilleZmin(?int $villeZmin): VillesFranceFree
    {
        $this->villeZmin = $villeZmin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVilleZmax(): ?int
    {
        return $this->villeZmax;
    }

    /**
     * @param int|null $villeZmax
     * @return VillesFranceFree
     */
    public function setVilleZmax(?int $villeZmax): VillesFranceFree
    {
        $this->villeZmax = $villeZmax;
        return $this;
    }


}
