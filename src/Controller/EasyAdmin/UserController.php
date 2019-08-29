<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Role;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\User;
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
    /**
     * Action Edit, on update
     *
     * @param User $entity
     */
    protected function updateEntity($entity)
    {
        //If request not ajax, load params
        if($this->request->request->get('user')) {
            //Set role, password, access_code
            $this->loadUserParam($entity);
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
     */
    protected function persistEntity($entity)
    {
        $property_accessor = PropertyAccess::createPropertyAccessor();
        $encoder = new NativePasswordEncoder();

        //Set role, password, access_code
        $this->loadUserParam($entity);
        //Set status
        $entity->setEnable(false);

        //Set password
        $request = $this->request->request->get('user');
        $password = $property_accessor->getValue($request, '[password]');
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
     */
    private function loadUserParam(User $entity) {
        $property_accessor = PropertyAccess::createPropertyAccessor();
        $access_service = new AccessService();

        $request = $this->request->request->get('user');

        //Set role
        $role_obj_id = $property_accessor->getValue($request, '[role_label]');
        $role_obj = $this->getDoctrine()->getRepository(Role::class)->find($role_obj_id);
        $entity->setRoles([$role_obj->getName()]);

        //Set relation to null
        $entity->setUniversity(null);
        $entity->setFaculty(null);
        $entity->setParty(null);
        $entity->setTeacher(null);

        //Search access element
        $access_id = null;
        if ($role_obj->getName() === AccessService::ROLE_UNIVERSITY_MANAGER) {
            $access_id = $property_accessor->getValue($request, '[university]');
            $entity->setUniversity($this->getDoctrine()->getRepository(University::class)->find($access_id));
        }
        if($role_obj->getName() === AccessService::ROLE_FACULTY_MANAGER) {
            $access_id = $property_accessor->getValue($request, '[faculty]');
            $entity->setFaculty($this->getDoctrine()->getRepository(Faculty::class)->find($access_id));
        }
        if($role_obj->getName() === AccessService::ROLE_PARTY_MANAGER) {
            $access_id = $property_accessor->getValue($request, '[party]');
            $entity->setParty($this->getDoctrine()->getRepository(Party::class)->find($access_id));
        }
        if($role_obj->getName() === AccessService::ROLE_TEACHER) {
            $access_id = $property_accessor->getValue($request, '[teacher]');
            $entity->setTeacher($this->getDoctrine()->getRepository(Teacher::class)->find($access_id));
        }
        if (!$access_id) {
            $access_id = 0;
        }

        //Set access code
        $entity->setAccessCode($access_service->creatAccessCode($role_obj->getName(), $access_id));
    }

}