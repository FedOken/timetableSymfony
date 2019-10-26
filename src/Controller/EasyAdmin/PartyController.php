<?php

namespace App\Controller\EasyAdmin;


use App\Entity\Cabinet;
use App\Entity\Course;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\CourseRepository;
use App\Repository\FacultyRepository;
use App\Repository\PartyRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Service\AccessService;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class PartyController extends EasyAdminController
{
    protected $accessService;
    protected $courseRepo;
    protected $partyRepo;
    protected $facultyRepo;
    protected $universityRepo;

    public function __construct(UniversityRepository $universityRepo, CourseRepository $courseRepository, PartyRepository $partyRepository, AccessService $accessService, FacultyRepository $facultyRepository)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->universityRepo = $universityRepo;
        $this->courseRepo = $courseRepository;
        $this->facultyRepo = $facultyRepository;
        $this->partyRepo = $partyRepository;
    }
    /**
     * Action Edit, on update
     *
     * @param Party $entity
     */
    protected function updateEntity($entity)
    {
        $this->beforeSave($entity);
    }

    /**
     * Action New, on save
     *
     * @param Party $entity
     */
    protected function persistEntity($entity)
    {
        $this->beforeSave($entity);
    }

    /**
     * @param Party $entity
     * @return bool
     */
    private function beforeSave($entity) {
        $request = $this->request->request->get('party');

        $universityId = ArrayHelper::getValue($request, 'university');
        $facultyId = ArrayHelper::getValue($request, 'faculty');
        $courseId = ArrayHelper::getValue($request, 'course');

        if (!$universityId || !$facultyId || !$courseId) {
            return false;
        }

        $facultyValid = $this->facultyRepo->checkFacultyInUniversity($universityId, $facultyId);
        $courseValid = $this->courseRepo->checkCourseInUniversity($universityId, $courseId);

        if (!$facultyValid || !$courseValid) {
            return false;
        }

        $entity->setFaculty($this->facultyRepo->findOneBy(['id' => $facultyId]));

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
        return true;
    }

    /**
     * Rewriting standard easy admin function
     * @param Party $entity
     * @param string $view
     * @return \Symfony\Component\Form\FormBuilder
     */
    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $userToAccess = $this->getUser();

        //Set university permission
        $universityPermission = $this->accessService->getUniversityPermission($userToAccess);
        //Set faculty permission
        $facultyPermission = $this->accessService->getFacultyPermission($userToAccess);

        /*DATA FOR SELECT*/
        $universityToChoice = $this->universityRepo->getDataForChoice($universityPermission);
        //Select building by university
        count($universityToChoice) > 0 ? $facultyToChoice = $this->facultyRepo->getFacultiesByUniversity([reset($universityToChoice)], true) : $facultyToChoice = [];

        $formBuilder->add('university', ChoiceType::class, [
            'choices' => $universityToChoice,
            'mapped' => false,
            'attr' => ['data-widget' => 'select2']
        ]);
        $formBuilder->add('faculty', ChoiceType::class, [
            'choices' => $facultyToChoice,
            'mapped' => false,
            'attr' => ['data-widget' => 'select2']
        ]);

        return $formBuilder;
    }


}