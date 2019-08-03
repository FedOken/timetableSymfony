<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BuildingRepository")
 */
class Building
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\University", inversedBy="buildings")
     */
    private $university;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cabinet", mappedBy="building")
     */
    private $cabinets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Schedule", mappedBy="building")
     */
    private $schedules;

    public function __construct()
    {
        $this->cabinets = new ArrayCollection();
        $this->schedules = new ArrayCollection();
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
     * @return Collection|Cabinet[]
     */
    public function getCabinets(): Collection
    {
        return $this->cabinets;
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

    /**
     * @return Collection|Schedule[]
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setBuilding($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->contains($schedule)) {
            $this->schedules->removeElement($schedule);
            // set the owning side to null (unless already changed)
            if ($schedule->getBuilding() === $this) {
                $schedule->setBuilding(null);
            }
        }

        return $this;
    }

    /**
     * Set what user see in form by relation
     * @return mixed
     */
    public function __toString(){
        return $this->name;
    }
}
