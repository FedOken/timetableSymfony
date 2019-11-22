<?php

namespace App\Entity;

use App\Helper\ArrayHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Helper\MagicTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 *
 * @property integer $id
 * @property string $lesson_name
 * @property Party $party
 * @property LessonType $lesson_type
 * @property Teacher $teacher
 * @property Cabinet $cabinet
 * @property Week $week
 * @property Day $day
 * @property UniversityTime $universityTime
 */
class Schedule
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
    private $lesson_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Party", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $party;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LessonType", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $lesson_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teacher", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cabinet", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $cabinet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Week", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $week;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Day", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UniversityTime", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $universityTime;

    public function __toString(){
        return $this->lesson_name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLessonName(): ?string
    {
        return $this->lesson_name;
    }

    public function setLessonName(?string $lesson_name): self
    {
        $this->lesson_name = $lesson_name;

        return $this;
    }

    public function getParty(): ?Party
    {
        return $this->party;
    }

    public function setParty(?Party $party): self
    {
        $this->party = $party;

        return $this;
    }

    public function getLessonType(): ?LessonType
    {
        return $this->lesson_type;
    }

    public function setLessonType(?LessonType $lesson_type): self
    {
        $this->lesson_type = $lesson_type;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getCabinet(): ?Cabinet
    {
        return $this->cabinet;
    }

    public function setCabinet(?Cabinet $cabinet): self
    {
        $this->cabinet = $cabinet;

        return $this;
    }

    public function getWeek(): ?Week
    {
        return $this->week;
    }

    public function setWeek(?Week $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setDay(?Day $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getUniversityTime(): ?UniversityTime
    {
        return $this->universityTime;
    }

    public function getBuilding()
    {
        return ArrayHelper::getValue($this, 'cabinet.building');
    }

    public function getUniversity()
    {
        return ArrayHelper::getValue($this, 'cabinet.building.university');
    }
}
