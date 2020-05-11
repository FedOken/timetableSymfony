<?php

namespace App\Entity;

use App\Helper\MagicTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BuildingRepository")
 *
 * @UniqueEntity(
 *     fields={"university", "name"},
 *     errorPath="name",
 *     message="entity_exist"
 * )
 *
 * @property integer $id
 * @property string $name
 * @property string $name_full
 * @property string $address
 * @property University $university
 * @property Cabinet[] $cabinets
 * @property string $complexName
 */
class Building
{
    use MagicTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name_full;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\University", inversedBy="buildings")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $university;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cabinet", mappedBy="building")
     */
    private $cabinets;


    public function __construct()
    {
        $this->cabinets = new ArrayCollection();
        $this->schedules = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getComplexName();
    }

    public function getComplexName(): ?string
    {
        return $this->name.' ('.$this->address.')';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNameFull(): ?string
    {
        return $this->name_full;
    }

    public function setNameFull(?string $name_full): self
    {
        $this->name_full = $name_full;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getUniversity(): ?University
    {
        return $this->university;
    }

    public function setUniversity(?University $university): self
    {
        $this->university = $university;

        return $this;
    }

    /**
     * @return Cabinet[]
     */
    public function getCabinets(): array
    {
        return $this->cabinets->getValues();
    }

    public function addCabinet(Cabinet $cabinet): self
    {
        if (!$this->cabinets->contains($cabinet)) {
            $this->cabinets[] = $cabinet;
            $cabinet->setBuilding($this);
        }

        return $this;
    }

    public function removeCabinet(Cabinet $cabinet): self
    {
        if ($this->cabinets->contains($cabinet)) {
            $this->cabinets->removeElement($cabinet);
            // set the owning side to null (unless already changed)
            if ($cabinet->getBuilding() === $this) {
                $cabinet->setBuilding(null);
            }
        }

        return $this;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_full' => $this->name_full,
            'address' => $this->address,
            'university' => $this->university,
        ];
    }
}
