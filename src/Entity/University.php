<?php

namespace App\Entity;

use App\Helper\MagicTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniversityRepository")
 *
 * @UniqueEntity(
 *     fields={"name", "name_full"},
 *     errorPath="name",
 *     message="entity_exist"
 * )
 * @UniqueEntity(
 *     fields={"name_full"},
 *     errorPath="name_full",
 *     message="entity_exist"
 * )
 *
 * @property int $id
 * @property string $name
 * @property string $name_full
 * @property Faculty[] $faculties
 * @property bool $enable
 * @property string $access_code
 *
 * @property Building[] $buildings
 * @property Week[] $weeks
 * @property Course[] $courses
 * @property Teacher[] $teachers
 * @property UniversityTime[] $universityTimes
 * @property User[] $users
 *
 */

class University
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
     * @ORM\Column(type="string")
     */
    private $access_code;

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
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="university")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UniversityTime", mappedBy="university")
     */
    private $universityTimes;

    public function __construct()
    {
        $this->faculties = new ArrayCollection();
        $this->buildings = new ArrayCollection();
        $this->weeks = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->universityTimes = new ArrayCollection();
    }

    public function __toString(){
        return $this->name_full;
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
     * @return array|Faculty[]
     */
    public function getFaculties(): array
    {
        return $this->faculties->toArray();
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
     * @return Building[]
     */
    public function getBuildings(): array
    {
        return $this->buildings->getValues();
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
     * @return Week[]
     */
    public function getWeeks(): array
    {
        return $this->weeks->getValues();
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
     * @return Course[]
     */
    public function getCourses(): array
    {
        return $this->courses->getValues();
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
     * @return Teacher[]
     */
    public function getTeachers(): array
    {
        return $this->teachers->getValues();
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
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users->getValues();
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

    /**
     * @return UniversityTime[]
     */
    public function getUniversityTimes(): array
    {
        return $this->universityTimes->getValues();
    }

    public function addUniversityTime(UniversityTime $universityTime): self
    {
        if (!$this->universityTimes->contains($universityTime)) {
            $this->universityTimes[] = $universityTime;
            $universityTime->setUniversity($this);
        }

        return $this;
    }

    public function removeUniversityTime(UniversityTime $universityTime): self
    {
        if ($this->universityTimes->contains($universityTime)) {
            $this->universityTimes->removeElement($universityTime);
            // set the owning side to null (unless already changed)
            if ($universityTime->getUniversity() === $this) {
                $universityTime->setUniversity(null);
            }
        }

        return $this;
    }

    public function getAccessCode(): ?string
    {
        return $this->access_code;
    }

    public function setAccessCode(?string $access_code): self
    {
        $this->access_code = $access_code;
        return $this;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_full' => $this->name_full,
        ];
    }
}
