<?php

namespace App\Controller\EasyAdmin;


use App\Entity\Faculty;
use App\Entity\University;
use App\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Contracts\Translation\TranslatorInterface;


class FacultyController extends AdminController
{
    /**
     * @return QueryBuilder query
     */
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $universityIds = $this->accessService->getUniversityPermission($this->getUser());
        $response->andWhere('entity.university IN (:universityIds)')->setParameter('universityIds', $universityIds);

        return $response;
    }

    /**
     * List action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function listAction()
    {
        $validIds = $this->accessService->getFacultyPermission($this->getUser());
        return $this->listCheckPermissionAndRedirect($validIds, 'Faculty', AccessService::ROLE_UNIVERSITY_MANAGER);
    }

    /**
     * Edit action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editAction()
    {
        $validIds = $this->accessService->getFacultyPermission($this->getUser());
        return $this->editCheckPermissionAndRedirect($validIds, 'Faculty', AccessService::ROLE_FACULTY_MANAGER);
    }

    /**
     * Action New, on save
     *
     * @param Faculty $entity
     * @return bool|void
     */
    protected function persistEntity($entity)
    {
        $entity->enable = true;

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
        return true;
    }

    /**
     * Rewriting standard easy admin function
     * @param University $entity
     * @param string $view
     * @return \Symfony\Component\Form\FormBuilder
     */
    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $universityToChoice = $this->universityHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'university.id'), $this->getUser());

        $formBuilder->add('university', EntityType::class, [
            'choices' => $universityToChoice,
            'class' => 'App\Entity\University',
            'attr' => ['data-widget' => 'select2'],
        ]);

        return $formBuilder;
    }
}
