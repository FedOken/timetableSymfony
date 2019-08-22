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


class BuildingController extends EasyAdminController
{
    /**
     * Action Edit, on update
     *
     * @param Building $entity
     */
    protected function updateEntity($entity)
    {
        $this->beforeSave($entity);
    }

    /**
     * Action New, on save
     *
     * @param Building $entity
     */
    protected function persistEntity($entity)
    {
        $this->beforeSave($entity);
    }

    private function beforeSave($entity) {
        $pa = PropertyAccess::createPropertyAccessor();

        $request = $this->request->request->get('building');

        $university_id = $pa->getValue($request, '[university]');
        $building_id = $pa->getValue($request, '[building]');


        if (!$university_id || !$building_id) {
            return false;
        }

        /** @var $building_repo BuildingRepository */
        $building_repo = $this->getDoctrine()->getRepository(Building::class);
        $building_valid = $building_repo->checkBuildingByUniversity($university_id, $building_id);

        if (!$building_valid) {
            return false;
        }

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }


}