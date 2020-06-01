<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Role;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\User;
use App\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Service\Access\AccessService;
use App\Service\Access\AdminAccess;
use App\Service\Access\FacultyAccess;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use App\Service\Access\UniversityAccess;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;
use EasyCorp\Bundle\EasyAdminBundle\Search\Autocomplete;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;


class UserController extends AdminController
{
    protected $userRepo;
    protected $roleRepo;
    private $validIds = [];

    public function __construct(RoleRepository $roleRepository, UserRepository $userRepository, TranslatorInterface $translator, UniversityHandler $universityHandler, AccessService $accessService)
    {
        parent::__construct($translator, $universityHandler, $accessService);

        $this->userRepo = $userRepository;
        $this->roleRepo = $roleRepository;
    }


    private function init()
    {
        $this->validIds = ArrayHelper::getColumn($this->userRepo->findAll(),'id');
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'User', AdminAccess::getAccessRole());
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'User', AdminAccess::getAccessRole());
    }

    /**
     * @param User $entity
     *
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

    private function setRoleByRoleLabel($entity) {
        $request = $this->request->request->get('user');

        //Set role
        $roleId = ArrayHelper::getValue($request, 'role_label');
        $roleModel = $this->roleRepo->find($roleId);
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