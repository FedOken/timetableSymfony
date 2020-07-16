<?php

namespace App\Controller\Handler;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\Teacher;
use App\Entity\TeacherPosition;
use App\Entity\University;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\PartyRepository;
use App\Repository\UniversityRepository;

class MainHandler extends BaseHandler
{
    public function formSearchData(): array
    {
        /**@var UniversityRepository $repoUn */
        $repoUn = $this->em->getRepository(University::class);
        $universities = $repoUn->findAll();

        /**@var PartyRepository $repoPar */
        $repoPar = $this->em->getRepository(Party::class);
        $parties = $repoPar->findAll();

        /**@var TeacherPosition $repoTeach */
        $repoTeach = $this->em->getRepository(Teacher::class);
        $teachers = $repoTeach->findAll();

        /**@var CabinetRepository $repoCab */
        $repoCab = $this->em->getRepository(Cabinet::class);
        $cabinets = $repoCab->findAll();

        return [
            'universities' => $universities,
            'parties' => $parties,
            'teachers' => $teachers,
            'cabinets' => $cabinets,
        ];
    }
}