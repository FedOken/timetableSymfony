<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Role;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\User;
use App\Helper\ArrayHelper;
use App\Repository\RoleRepository;
use App\Service\AccessService;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;
use EasyCorp\Bundle\EasyAdminBundle\Search\Autocomplete;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends EasyAdminController
{
    protected $roleRepo;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepo = $roleRepository;
    }

    /**
     * Action Edit, on update
     *
     * @param User $entity
     * @return bool|void
     */
    protected function updateEntity($entity)
    {
        if(!$this->request->isXmlHttpRequest()) {
            //Set role by role label
            if (!$this->setRoleByRoleLabel($entity)) {
                return false;
            }
        }

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * Action New, on save
     *
     * @param User $entity
     * @return bool|void
     */
    protected function persistEntity($entity)
    {
        $encoder = new NativePasswordEncoder();

        //Set role by role label
        if (!$this->setRoleByRoleLabel($entity)) {
            return false;
        }

        //Set status
        $entity->setEnable(false);

        //Set password
        $request = $this->request->request->get('user');
        $password = ArrayHelper::getValue($request, 'password');
        $password_encode = $encoder->encodePassword($password, null);
        $entity->setPassword($password_encode);

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * Load params from request to model, by some rules
     * @param User $entity
     * @return bool
     */
    private function setRoleByRoleLabel(User $entity) {
        $request = $this->request->request->get('user');

        //Set role
        $roleId = ArrayHelper::getValue($request, 'role_label');
        $roleModel = $this->roleRepo->find($roleId);
        $entity->roles = [$roleModel->name];

        //Search access element
        $accessId = 0;
        switch ($roleModel->name) {
            case AccessService::ROLE_UNIVERSITY_MANAGER:
                $accessId = ArrayHelper::getValue($entity, 'university.id');
                $entity->faculty = null;
                $entity->party = null;
                $entity->teacher = null;
                break;
            case AccessService::ROLE_FACULTY_MANAGER:
                $accessId = ArrayHelper::getValue($entity, 'faculty.id');
                $entity->university = null;
                $entity->party = null;
                $entity->teacher = null;
                break;
            case AccessService::ROLE_PARTY_MANAGER:
                $accessId = ArrayHelper::getValue($entity, 'party.id');
                $entity->university = null;
                $entity->faculty = null;
                $entity->teacher = null;
                break;
            case AccessService::ROLE_TEACHER:
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
        $entity->access_code = AccessService::creatAccessCode($roleModel->name, $accessId);
        return true;
    }

}