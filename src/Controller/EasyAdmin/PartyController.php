<?php

namespace App\Controller\EasyAdmin;


use App\Entity\Cabinet;
use App\Entity\Course;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Repository\CourseRepository;
use App\Repository\FacultyRepository;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class PartyController extends EasyAdminController
{
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
     * @param $entity
     * @return bool
     */
    private function beforeSave($entity) {
        $pa = PropertyAccess::createPropertyAccessor();

        $request = $this->request->request->get('party');

        $university_id = $pa->getValue($request, '[university]');
        $faculty_id = $pa->getValue($request, '[faculty]');
        $course_id = $pa->getValue($request, '[course]');

        if (!$university_id || !$faculty_id || !$course_id) {
            return false;
        }

        /** @var $faculty_repo FacultyRepository */
        $faculty_repo = $this->getDoctrine()->getRepository(Faculty::class);
        $faculty_valid = $faculty_repo->checkFacultyByUniversity($university_id, $faculty_id);
        /** @var $course_repo CourseRepository */
        $course_repo = $this->getDoctrine()->getRepository(Course::class);
        $course_valid = $course_repo->checkCourseByUniversity($university_id, $course_id);

        if (!$faculty_valid || !$course_valid) {
            return false;
        }

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }


}