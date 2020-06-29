<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Role;
use App\Entity\User;
use App\Helper\ArrayHelper;
use App\Service\Access\AdminAccess;
use App\Service\Access\FacultyAccess;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use App\Service\Access\UniversityAccess;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

/**
 * Class TeacherPositionController
 * @package App\Controller\EasyAdmin
 *
 * @property array $validIds
 */
class UserController extends AdminController
{
    private $validIds = [];

    private function init()
    {
        $this->validIds = ArrayHelper::getColumn($this->em->getRepository(User::class)->findAll(),'id');
    }

    protected function newAction()
    {
        $this->init();
        return $this->newCheckPermissionAndRedirect($this->validIds, 'User', [AdminAccess::getAccessRole()]);
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'User', [AdminAccess::getAccessRole()]);
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'User', [AdminAccess::getAccessRole()]);
    }

    protected function updateEntity($entity)
    {
        /** @var User $entity */
        if(!$this->request->isXmlHttpRequest()) {
            //Set role by role label
            if (!$this->setRoleByRoleLabel($entity)) {
                return false;
            }
        }

        $request = $this->request->request->get('user');
        $entity->status = ArrayHelper::getValue($request, 'status_choice');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }


    protected function persistEntity($entity)
    {
        /** @var User $entity */
        //Set role by role label
        if (!$this->setRoleByRoleLabel($entity)) {
            return false;
        }

        //Set password
        $request = $this->request->request->get('user');
        $password = ArrayHelper::getValue($request, 'password');
        $entity->password = (new NativePasswordEncoder())->encodePassword($password, null);

        $entity->status = User::STATUS_ACTIVE;

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);
        $choice = (new User())->getStatusList();
        $choiceUpd = [];
        /**@var User $entity */
        foreach ($choice as $key => $label) {
            if ($entity->status === $key) {
                $choiceUpd[$key] = $label;
                unset($choice[$key]);
                break;
            }
        }
        $choice = $choiceUpd + $choice;

        $formBuilder->add('status_choice', ChoiceType::class, [
            'choices' => array_flip($choice),
            'attr' => ['data-widget' => 'select2'],
            'mapped' => false,
        ]);

        return $formBuilder;
    }

    private function setRoleByRoleLabel($entity) {
        $request = $this->request->request->get('user');

        //Set role
        $roleId = ArrayHelper::getValue($request, 'role_label');
        $roleModel = $this->em->getRepository(Role::class)->find($roleId);
        $entity->roles = [$roleModel->name];

        //Search access element
        $accessId = 0;
        switch ($roleModel->name) {
            case UniversityAccess::getAccessRole():
                $accessId = ArrayHelper::getValue($entity, 'university.id');
                $entity->faculty = null;
                $entity->party = null;
                $entity->teacher = null;
                break;
            case FacultyAccess::getAccessRole():
                $accessId = ArrayHelper::getValue($entity, 'faculty.id');
                $entity->university = null;
                $entity->party = null;
                $entity->teacher = null;
                break;
            case PartyAccess::getAccessRole():
                $accessId = ArrayHelper::getValue($entity, 'party.id');
                $entity->university = null;
                $entity->faculty = null;
                $entity->teacher = null;
                break;
            case TeacherAccess::getAccessRole():
                $accessId = ArrayHelper::getValue($entity, 'teacher.id');
                $entity->university = null;
                $entity->faculty = null;
                $entity->party = null;
                break;
            default:
                $entity->university = null;
                $entity->faculty = null;
                $entity->party = null;
                $entity->teacher = null;
        }

        if ($accessId === null) {
            $this->addFlash('warning', 'The selected role is not assigned an access object!');
            return false;
        }

        //Set access code
        $entity->access_code = $this->accessService->createAccessCode($roleModel->name, $accessId);
        return true;
    }

}