<?php

namespace App\Entity;

use App\Entity\Base\WeekBase;
use App\Helper\MagicTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeekRepository")
 *
 * @UniqueEntity(
 *     fields={"name", "university"},
 *     errorPath="name",
 *     message="entity_exist"
 * )
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort_order
 * @property Schedule[] $schedules
 * @property University $university
 */
class Week extends WeekBase
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort_order;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Schedule", mappedBy="week")
     */
    private $schedules;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\University", inversedBy="weeks")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $university;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
    }

    public function __toString(){
        return $this->name;
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

    /**
     * @return Schedule[]
     */
    public function getSchedules(): array
    {
        return $this->schedules->getValues();
    }

    public function addSchedule(Schedule $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setWeek($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->contains($schedule)) {
            $this->schedules->removeElement($schedule);
            // set the owning side to null (unless already changed)
            if ($schedule->getWeek() === $this) {
                $schedule->setWeek(null);
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

    public function getSortOrder(): int
    {
        return $this->sort_order;
    }

    public function setSortOrder(int $sort_order): self
    {
        $this->sort_order = $sort_order;
        return $this;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'university' => $this->university ? $this->university->serialize() : null,
        ];
    }
}
