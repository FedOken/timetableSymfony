<?php

namespace App\Controller\EasyAdmin;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
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
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $request = $this->request->request->get('user');
        $user_role = $propertyAccessor->getValue($request, '[role]');

        $entity->setRoles([$user_role]);

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
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $encoder = new NativePasswordEncoder();

        $request = $this->request->request->get('user');

        $role = $propertyAccessor->getValue($request, '[role]');
        $password = $encoder->encodePassword($entity->getPassword(), null);

        $entity->setRoles([$role]);
        $entity->setPassword($password);

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param User $entity
     * @param $view
     * @return \Symfony\Component\Form\FormBuilder
     */
    protected function createUserEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $formBuilder->add('role', ChoiceType::class, [
            'choices' => $entity->getRoleList(),
        ]);

        return $formBuilder;
    }

}