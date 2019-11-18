<?php

namespace App\Controller\EasyAdmin;


use App\Entity\Cabinet;
use App\Entity\Course;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\University;
use App\Handler\CourseHandler;
use App\Handler\FacultyHandler;
use App\Handler\UniversityHandler;
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
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;


class PartyController extends AdminController
{
    protected $facultyHandler;
    protected $courseHandler;


    public function __construct(CourseHandler $courseHandler, FacultyHandler $facultyHandler, TranslatorInterface $translator, UniversityHandler $universityHandler, AccessService $accessService)
    {
        parent::__construct($translator, $universityHandler, $accessService);
        //Handler
        $this->facultyHandler = $facultyHandler;
        $this->courseHandler = $courseHandler;
    }

    /**
     * @return QueryBuilder query
     */
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $facultyIds = $this->accessService->getFacultyPermission($this->getUser());
        $response->andWhere('entity.faculty IN (:facultyIds)')->setParameter('facultyIds', $facultyIds);

        return $response;
    }

    /**
     * List action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function listAction()
    {
        $validIds = $this->accessService->getPartyPermission($this->getUser());
        return $this->listCheckPermissionAndRedirect($validIds, 'Party', AccessService::ROLE_FACULTY_MANAGER);
    }

    /**
     * Edit action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editAction()
    {
        $validIds = $this->accessService->getPartyPermission($this->getUser());
        return $this->editCheckPermissionAndRedirect($validIds, 'Party', AccessService::ROLE_FACULTY_MANAGER);
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

        $facultyToChoice = $this->facultyHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'faculty.id'), $this->getUser());
        $courseToChoice = $this->courseHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'course.id'), $this->getUser());

        $formBuilder->add('faculty', EntityType::class, [
            'choices' => $facultyToChoice,
            'class' => 'App\Entity\Faculty',
            'attr' => ['data-widget' => 'select2'],
        ]);
        $formBuilder->add('course', EntityType::class, [
            'choices' => $courseToChoice,
            'class' => 'App\Entity\Course',
            'attr' => ['data-widget' => 'select2'],
        ]);

        return $formBuilder;
    }
}