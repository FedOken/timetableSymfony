<?php

namespace App\Handler\schedule;

use App\Entity\Cabinet;
use App\Entity\Day;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\UniversityTime;
use App\Entity\User;
use App\Handler\BaseHandler;
use App\Helper\ArrayHelper;

class ScheduleHandler extends BaseHandler
{
    public function formData(string $type, int $week, int $id): array
    {
        $repoSch = $this->em->getRepository(Schedule::class);
        $repoParty = $this->em->getRepository(Party::class);
        $repoDay = $this->em->getRepository(Day::class);
        $repoTime = $this->em->getRepository(UniversityTime::class);

        $unId =  ArrayHelper::getValue($repoParty->find($id), 'faculty.university.id');

        $days = $repoDay->findAll();
        $times = $repoTime->findBy(['university' => $unId]);

        $schedules = [];
        foreach ($days as $key => $day) {
            if (in_array($day->id, [6, 7])) continue;

            foreach ($times as $key2 => $time) {
                $schedule = $repoSch->findOneBy([
                    'week' => $week,
                    'party' => $id,
                    'day' => $day->id,
                    'universityTime' => $time->id,
                ]);

                if ($schedule) {
                    $schedule = [
                        'lesson' => $schedule->lesson_name,
                        'teacher' => $schedule->teacher->serialize(),
                        'cabinet' => $schedule->cabinet->serialize(),
                        'building' => $schedule->building->serialize(),
                    ];
                }

                $schedules[$key][$key2] = $schedule;
            }
        }
        return [
            'schedules' => $schedules,
            'days' => $this->formDays(),
            'times' => $this->formTimes($unId),
        ];
    }

    private function formDays(): array
    {
        $repoDay = $this->em->getRepository(Day::class);
        $days = $repoDay->findAll();

        $data = [];
        foreach ($days as $day) {
            if (in_array($day->id, [6, 7])) continue;

            $data[] = $day->serialize();
        }

        return $data;
    }

    private function formTimes(int $unId): array
    {
        $repoTime = $this->em->getRepository(UniversityTime::class);
        $times = $repoTime->findBy(['university' => $unId]);

        $data = [];
        foreach ($times as $time) {
            $data[] = $time->serialize();
        }

        return $data;
    }
}