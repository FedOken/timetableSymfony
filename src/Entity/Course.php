<?php

namespace App\Entity;

use App\Helper\MagicTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 *
 * @UniqueEntity(
 *     fields={"university", "course"},
 *     errorPath="course",
 *     message="entity_exist"
 * )
 *
 * @UniqueEntity(
 *     fields={"university", "name_full"},
 *     errorPath="name_full",
 *     message="entity_exist"
 * )
 *
 * @property int $id
 * @property string $course
 * @property string $name_full
 * @property Party[] $parties
 * @property University $university
 */
class Course
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
    private $course;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name_full;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Party", mappedBy="course")
     */
    private $parties;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\University", inversedBy="courses")
     */
    private $university;

    public function __construct()
    {
        $this->parties = new ArrayCollection();
    }

    public function __toString(){
        return $this->course;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourse(): ?string
    {
        return $this->course;
    }

    public function setCourse(?string $course): self
    {
        $this->course = $course;

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

    /**
     * @return Collection|Party[]
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Party $party): self
    {
        if (!$this->parties->contains($party)) {
            $this->parties[] = $party;
            $party->setCourse($this);
        }

        return $this;
    }

    public function removeParty(Party $party): self
    {
        if ($this->parties->contains($party)) {
            $this->parties->removeElement($party);
            // set the owning side to null (unless already changed)
            if ($party->getCourse() === $this) {
                $party->setCourse(null);
            }
        }

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
}
