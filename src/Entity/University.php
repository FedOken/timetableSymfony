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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Week", mappedBy="university")
     */
    private $weeks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Course", mappedBy="university")
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Teacher", mappedBy="university")
     */
    private $teachers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cabinet", mappedBy="university")
     */
    private $cabinets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Party", mappedBy="university")
     */
    private $parties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Schedule", mappedBy="university")
     */
    private $schedules;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="university")
     */
    private $users;

    public function __construct()
    {
        $this->faculties = new ArrayCollection();
        $this->buildings = new ArrayCollection();
        $this->weeks = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->cabinets = new ArrayCollection();
        $this->parties = new ArrayCollection();
        $this->schedules = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * Set what user see in form by relation
     * @return mixed
     */
    public function __toString(){
        return $this->name_full;
    }

    /**
     * @param $propertyName
     * @return mixed
     */
    public function __get($propertyName)
    {
        return $this->$propertyName;
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

    /**
     * @return Collection|Week[]
     */
    public function getWeeks(): Collection
    {
        return $this->weeks;
    }

    public function addWeek(Week $week): self
    {
        if (!$this->weeks->contains($week)) {
            $this->weeks[] = $week;
            $week->setUniversity($this);
        }

        return $this;
    }

    public function removeWeek(Week $week): self
    {
        if ($this->weeks->contains($week)) {
            $this->weeks->removeElement($week);
            // set the owning side to null (unless already changed)
            if ($week->getUniversity() === $this) {
                $week->setUniversity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setUniversity($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->contains($course)) {
            $this->courses->removeElement($course);
            // set the owning side to null (unless already changed)
            if ($course->getUniversity() === $this) {
                $course->setUniversity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Teacher[]
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): self
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers[] = $teacher;
            $teacher->setUniversity($this);
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): self
    {
        if ($this->teachers->contains($teacher)) {
            $this->teachers->removeElement($teacher);
            // set the owning side to null (unless already changed)
            if ($teacher->getUniversity() === $this) {
                $teacher->setUniversity(null);
            }
        }

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
            $cabinet->setUniversity($this);
        }

        return $this;
    }

    public function removeCabinet(Cabinet $cabinet): self
    {
        if ($this->cabinets->contains($cabinet)) {
            $this->cabinets->removeElement($cabinet);
            // set the owning side to null (unless already changed)
            if ($cabinet->getUniversity() === $this) {
                $cabinet->setUniversity(null);
            }
        }

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
            $party->setUniversity($this);
        }

        return $this;
    }

    public function removeParty(Party $party): self
    {
        if ($this->parties->contains($party)) {
            $this->parties->removeElement($party);
            // set the owning side to null (unless already changed)
            if ($party->getUniversity() === $this) {
                $party->setUniversity(null);
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
            $schedule->setUniversity($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->contains($schedule)) {
            $this->schedules->removeElement($schedule);
            // set the owning side to null (unless already changed)
            if ($schedule->getUniversity() === $this) {
                $schedule->setUniversity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setUniversity($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUniversity() === $this) {
                $user->setUniversity(null);
            }
        }

        return $this;
    }
}
