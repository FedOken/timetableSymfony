<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniversityRepository")
 */
class University
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name_full;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Faculty", mappedBy="university")
     */
    private $faculties;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Building", mappedBy="university")
     */
    private $buildings;


    public function __construct()
    {
        $this->faculties = new ArrayCollection();
        $this->buildings = new ArrayCollection();
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

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * @return Collection|Faculty[]
     */
    public function getFaculties(): Collection
    {
        return $this->faculties;
    }

    public function addFaculty(Faculty $faculty): self
    {
        if (!$this->faculties->contains($faculty)) {
            $this->faculties[] = $faculty;
            $faculty->setUniversity($this);
        }

        return $this;
    }

    public function removeFaculty(Faculty $faculty): self
    {
        if ($this->faculties->contains($faculty)) {
            $this->faculties->removeElement($faculty);
            // set the owning side to null (unless already changed)
            if ($faculty->getUniversity() === $this) {
                $faculty->setUniversity(null);
            }
        }

        return $this;
    }

    /**
     * Set what user see in form by relation
     * @return mixed
     */
    public function __toString(){
        return $this->name_full;
    }

    /**
     * @return Collection|Building[]
     */
    public function getBuildings(): Collection
    {
        return $this->buildings;
    }

    public function addBuilding(Building $building): self
    {
        if (!$this->buildings->contains($building)) {
            $this->buildings[] = $building;
            $building->setUniversity($this);
        }

        return $this;
    }

    public function removeBuilding(Building $building): self
    {
        if ($this->buildings->contains($building)) {
            $this->buildings->removeElement($building);
            // set the owning side to null (unless already changed)
            if ($building->getUniversity() === $this) {
                $building->setUniversity(null);
            }
        }

        return $this;
    }
}
