<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\Cabinet;
use App\Entity\Day;
use App\Entity\Party;
use App\Entity\Teacher;
use App\Entity\UniversityTime;
use App\Entity\Week;
use App\Handler\BaseHandler;
use App\Handler\for_entity\WeekHandler;
use App\Helper\ArrayHelper;
use App\Repository\CabinetRepository;
use App\Repository\PartyRepository;
use App\Repository\TeacherRepository;
use App\Repository\WeekRepository;

class ScheduleHandler extends BaseHandler
{
    public function formSchedule(string $type, int $week, int $id): array
    {
        $unId = $this->getModelAndUnIdByType($type, $id)['unId'];
        /**@var Party|Teacher|Cabinet $model */
        $model = $this->getModelAndUnIdByType($type, $id)['model'];

        $repoDay = $this->em->getRepository(Day::class);
        $repoWeek = $this->em->getRepository(Week::class);
        $repoTime = $this->em->getRepository(UniversityTime::class);

        $days = $repoDay->findAll();
        $times = $repoTime->findBy(['university' => $unId]);

        $weekAll = $repoWeek->findOneBy(['university' => $unId, 'name' => WeekHandler::WEEK_ALL]);
        $weekIds = [$week, $weekAll->id];

        $schedules = $schedulesList = [];
        $scheduleIsExist = false;
        /** @var Day $day */
        foreach ($days as $key => $day) {
            if (in_array($day->id, [6, 7])) continue;

            /** @var UniversityTime $time */
            foreach ($times as $time) {
                $schdModels = $model->handler->getScheduleByParams($weekIds, $id, $day->id, $time->id);

                if ($schdModels) {
                    $schdModels = $model->handler->serializeForSchedule($schdModels);
                    $schedulesList[] = $schdModels;
                    $scheduleIsExist = true;
                }

                $schedules[$key][$time->id] = $schdModels;
            }
        }

        if (!$scheduleIsExist) return [];
        $schedules = $this->formSchedules($schedules);
        $times = $this->formTimes($schedules);
        $days = $this->formDays();

        return [
            'schedules' => $schedules,
            'days' => $this->formDays(),
            'times' => $times,
            'buildingsByType' => $this->formBuildings($schedulesList),
            'timesOpacityPercent' => $this->timesOpacityPercent($times),
            'dayOpacityPercent' => $this->dayOpacityPercent($days),
        ];
    }

    public function formWeeks(string $type, int $id): array
    {
        $unId = $this->getModelAndUnIdByType($type, $id)['unId'];
        $model = $this->getModelAndUnIdByType($type, $id)['model'];
        if (!$unId || !$model) return [];

        /** @var $repoWeeks WeekRepository */
        $repoWeeks = $this->em->getRepository(Week::class);
        $weekModels = $repoWeeks->getWeeksByUniversity([$unId]);

        $weeks = [];
        /** @var $week Week */
        foreach ($weekModels as $week) {
            $weeks[] = $week->serialize();
        }

        return [
            'weeks' => $weeks,
            'model' => $model->serialize()
        ];
    }



    /* PRIVATE FUNCTIONS*/

    private function getModelAndUnIdByType(string $type, int $id): array
    {
        switch ($type) {
            case 'group':
                /** @var $repoParty PartyRepository */
                $repoParty = $this->em->getRepository(Party::class);

                $model = $repoParty->find($id);
                $unId = ArrayHelper::getValue($model, 'faculty.university.id');
                break;
            case 'teacher':
                /** @var $repoTchr TeacherRepository */
                $repoTchr = $this->em->getRepository(Teacher::class);

                $model = $repoTchr->find($id);
                $unId = ArrayHelper::getValue($model, 'university.id');
                break;
            case 'cabinet':
                /** @var $repoCbnt CabinetRepository */
                $repoCbnt = $this->em->getRepository(Cabinet::class);

                $model = $repoCbnt->find($id);
                $unId = ArrayHelper::getValue($model, 'building.university.id');
                break;
            default:
                $unId = null;
                $model = null;
        }
        return ['unId' => $unId, 'model' => $model];
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

    /**
     * Return KEY = day_id, VALUE = UniversityTime
     * @param array $schedules
     * @return array
     */
    private function formTimes(array $schedules): array
    {
        if(!isset($schedules[0])) return [];

        $existTimes = [];
        foreach ($schedules[0] as $timeId => $schedule) {
            $existTimes[] = $timeId;
        }

        $repoTime = $this->em->getRepository(UniversityTime::class);
        $times = $repoTime->findBy(['id' => $existTimes]);

        $data = [];
        foreach ($times as $time) {
            $data[] = $time->serialize();
        }

        return $data;
    }

    /**
     * Return KEY = building_id, value = css type
     * @param $schedules
     * @return array
     */
    private function formBuildings(array $schedules): array
    {
        $buildings = [];
        foreach ($schedules as $schedule) {
            $buildings[] = ArrayHelper::getValue($schedule, 'cabinet.building.id');
        }
        $buildings = array_unique($buildings);
        $buildings = array_values($buildings);

        $response = [];
        foreach ($buildings as $key => $buildingId) {
            $response[$buildingId] = $key + 1;
        }
        return $response;
    }

    /**
     * Remove times empty times row on start and on end
     * @param array $schedules
     * @return array
     */
    private function formSchedules(array $schedules): array
    {
        if(!isset($schedules[0])) return [];

        $days = $schedules[0];
        $schedules = $this->deleteUnExistingTimeRow($days, $schedules);

        $days = array_reverse($days, true);
        $schedules = $this->deleteUnExistingTimeRow($days, $schedules);

        return $schedules;
    }

    /**
     * @param array $days Where KEY = day_id
     * @param array $schedules
     * @return array
     */
    private function deleteUnExistingTimeRow(array $days, array $schedules): array
    {
        foreach ($days as $time => $unUseValue) {

            $status = 'row-to-delete';
            //Check for schedule existing in row
            foreach ($schedules as $day) {
                if (isset($day[$time]) && (bool)$day[$time]) {
                    $status = 'schedule-exist';
                }
            }

            //Clear row
            if ($status === 'row-to-delete') {
                foreach ($schedules as $key => $day) {
                    unset($schedules[$key][$time]);
                }
            }
            if ($status === 'schedule-exist') break;
        }
        return $schedules;
    }

    private function timesOpacityPercent(array $times): array
    {
        $opFrom = 60;
        $opTo = 90;

        $diff = $opTo - $opFrom;
        $count = count($times) - 1;

        $response = [];
        $i = 0;
        foreach ($times as $time) {
            if (!$count) {
                $response[$time['id']] = $opTo;
                break;
            }

            $response[$time['id']] = round($diff / $count * $i + $opFrom, 0);
            $i++;
        }

        //Reverse values
        $keys = array_keys($response);
        $values = array_reverse(array_values($response));
        $reverse = [];
        foreach ($keys as $index => $time_id) {
            $reverse[$time_id] = $values[$index];
        }

        return [ 'original' => $response, 'reverse' => $reverse ];
    }

    private function dayOpacityPercent(array $days): array
    {
        $opFrom = 60;
        $opTo = 90;

        $diff = $opTo - $opFrom;
        $count = count($days) - 1;

        $response = [];
        $i = 0;
        foreach ($days as $day) {
            $response[$day['id']] = round($diff / $count * $i + $opFrom, 0);
            $i++;
        }

        return $response;
    }
}