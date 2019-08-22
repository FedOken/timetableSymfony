<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\User;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\PartyRepository;
use App\Repository\TeacherRepository;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ScheduleController extends EasyAdminController
{
    /**
     * Action Edit, on update
     *
     * @param Schedule $entity
     */
    protected function updateEntity($entity)
    {
        $this->beforeSave($entity);
    }

    /**
     * Action New, on save
     *
     * @param Schedule $entity
     */
    protected function persistEntity($entity)
    {
        $this->beforeSave($entity);
    }

    private function beforeSave($entity) {
        $pa = PropertyAccess::createPropertyAccessor();

        $request = $this->request->request->get('schedule');

        $university_id = $pa->getValue($request, '[university]');
        $building_id = $pa->getValue($request, '[building]');
        $party_id = $pa->getValue($request, '[party]');
        $cabinet_id = $pa->getValue($request, '[cabinet]');
        $teacher_id = $pa->getValue($request, '[teacher]');

        if (!$university_id || !$building_id || !$party_id || !$cabinet_id || !$teacher_id) {
            return false;
        }

        /** @var $building_repo BuildingRepository */
        $building_repo = $this->getDoctrine()->getRepository(Building::class);
        $building_valid = $building_repo->checkBuildingByUniversity($university_id, $building_id);
        /** @var $cabinet_repo CabinetRepository */
        $cabinet_repo = $this->getDoctrine()->getRepository(Cabinet::class);
        $cabinet_valid = $cabinet_repo->checkCabinetByBuilding($building_id, $cabinet_id);
        /** @var $party_repo PartyRepository */
        $party_repo = $this->getDoctrine()->getRepository(Party::class);
        $party_valid = $party_repo->checkPartyByUniversity($university_id, $party_id);
        /** @var $teacher_repo TeacherRepository */
        $teacher_repo = $this->getDoctrine()->getRepository(Teacher::class);
        $teacher_valid = $teacher_repo->checkTeacherByUniversity($university_id, $teacher_id);


        if (!$building_valid || !$cabinet_valid || !$party_valid || !$teacher_valid) {
            return false;
        }

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }


}