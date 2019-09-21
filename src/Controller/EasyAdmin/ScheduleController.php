<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Day;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\User;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\DayRepository;
use App\Repository\PartyRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Service\AccessService;
use Doctrine\ORM\Query\Expr\Select;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Form\EventListener\EasyAdminAutocompleteSubscriber;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminDividerType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminFormType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminSectionType;
use EasyCorp\Bundle\EasyAdminBundle\Tests\Form\Type\EasyAdminAutocompleteTypeTest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class ScheduleController extends EasyAdminController
{
    protected $accessService;
    protected $universityRepo;
    protected $buildingRepo;
    protected $cabinetRepo;

    public function __construct(AccessService $accessService, UniversityRepository $universityRepo, CabinetRepository $cabinetRepo, BuildingRepository $buildingRepo)
    {
        $this->accessService = $accessService;
        $this->buildingRepo = $buildingRepo;
        $this->universityRepo = $universityRepo;
        $this->cabinetRepo = $cabinetRepo;
    }

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

    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $userToAccess = $this->getUser();
        $universityPermission = $this->accessService->getUniversityPermission($userToAccess);

        $universityToChoice = $this->universityRepo->getDataForChoice($universityPermission);;
        $buildingsToChoice = $this->buildingRepo->getDataForChoice($universityPermission);

        $formBuilder->add('university', ChoiceType::class, [
                'choices' => $universityToChoice,
                'attr' => ['data-widget' => 'select2']
        ]);
        $formBuilder->add('building', ChoiceType::class, [
                'choices' => $buildingsToChoice,
                'attr' => ['data-widget' => 'select2']]);

        return $formBuilder;
    }


}