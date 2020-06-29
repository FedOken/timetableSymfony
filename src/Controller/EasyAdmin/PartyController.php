<?php

namespace App\Controller\EasyAdmin;


use App\Entity\Cabinet;
use App\Entity\Course;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\University;
use App\Controller\EasyAdmin\Handler\CourseHandler;
use App\Controller\EasyAdmin\Handler\FacultyHandler;
use App\Controller\EasyAdmin\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\CourseRepository;
use App\Repository\FacultyRepository;
use App\Repository\PartyRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Service\Access\AccessService;
use App\Service\Access\AdminAccess;
use App\Service\Access\FacultyAccess;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class PartyController
 * @package App\Controller\EasyAdmin
 *
 * @property array $validIds
 */
class PartyController extends AdminController
{
    private $validIds = [];

    private function init()
    {
        $this->validIds = $this->accessService->getAccessObject($this->getUser())->getAccessiblePartyIds();
    }

    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $this->init();
        $response->andWhere('entity.id IN (:ids)')->setParameter('ids', $this->validIds);
        return $response;
    }

    protected function newAction()
    {
        $this->init();
        return $this->newCheckPermissionAndRedirect($this->validIds, 'Party', [FacultyAccess::getAccessRole()]);
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Party', [FacultyAccess::getAccessRole()]);
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Party',  [FacultyAccess::getAccessRole()]);
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
        $fcltToSel = $this->selDataHandler->getDataFclt(ArrayHelper::getValue($entity, 'faculty.id'), null);
        $crsToSel = $this->selDataHandler->getDataCrs(ArrayHelper::getValue($entity, 'course.id'), null);

        $formBuilder->add('faculty', EntityType::class, [
            'choices' => $fcltToSel,
            'class' => 'App\Entity\Faculty',
            'attr' => ['data-widget' => 'select2'],
        ]);
        $formBuilder->add('course', EntityType::class, [
            'choices' => $crsToSel,
            'class' => 'App\Entity\Course',
            'choice_label' => function ($choice) {
                return $choice->name_full.' - '.$choice->university->name;
            },
            'attr' => ['data-widget' => 'select2'],
        ]);

        return $formBuilder;
    }
}