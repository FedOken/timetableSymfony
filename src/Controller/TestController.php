<?php


namespace App\Controller;


use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Course;
use App\Entity\Day;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Teacher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TestController extends AbstractController
{
    /**
     * @Route("/ajax/get-building-by-university", name="ajax-get-building-by-university")
     * @param Request $request
     * @return JsonResponse
     */
    public function getBuildingByUniversity(Request $request)
    {
        $university_id = $request->get('university_id');
        $repo = $this->getDoctrine()->getRepository(Building::class);

        $building_models = $repo->findBy(['university' => $university_id]);

        $pa = PropertyAccess::createPropertyAccessor();

        $data = [];
        foreach ($building_models as $model) {
            $data[$pa->getValue($model, 'id')] = $pa->getValue($model, 'complexName');
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/ajax/get-faculty-by-university", name="ajax-get-faculty-by-university")
     * @param Request $request
     * @return JsonResponse
     */
    public function getFacultyByUniversity(Request $request)
    {
        $university_id = $request->get('university_id');
        $repo = $this->getDoctrine()->getRepository(Faculty::class);

        $faculty_models = $repo->findBy(['university' => $university_id]);

        $pa = PropertyAccess::createPropertyAccessor();

        $data = [];
        foreach ($faculty_models as $model) {
            $data[$pa->getValue($model, 'id')] = $pa->getValue($model, 'name_full');
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/ajax/get-course-by-university", name="ajax-get-course-by-university")
     * @param Request $request
     * @return JsonResponse
     */
    public function getCourseByUniversity(Request $request)
    {
        $university_id = $request->get('university_id');
        $repo = $this->getDoctrine()->getRepository(Course::class);

        $course_models = $repo->findBy(['university' => $university_id]);

        $pa = PropertyAccess::createPropertyAccessor();

        $data = [];
        foreach ($course_models as $model) {
            $data[$pa->getValue($model, 'id')] = $pa->getValue($model, 'course');
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/ajax/get-cabinet-by-building", name="ajax-get-cabinet-by-building")
     * @param Request $request
     * @return JsonResponse
     */
    public function getCourseCabinetByBuilding(Request $request)
    {
        $building_id = $request->get('building_id');
        $repo = $this->getDoctrine()->getRepository(Cabinet::class);

        $course_models = $repo->findBy(['building' => $building_id]);

        $pa = PropertyAccess::createPropertyAccessor();

        $data = [];
        foreach ($course_models as $model) {
            $data[$pa->getValue($model, 'id')] = $pa->getValue($model, 'name');
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/ajax/get-group-by-university", name="ajax-get-group-by-university")
     * @param Request $request
     * @return JsonResponse
     */
    public function getGroupByUniversity(Request $request)
    {
        $university_id = $request->get('university_id');
        $repo = $this->getDoctrine()->getRepository(Party::class);

        $group_models = $repo->findBy(['university' => $university_id]);

        $pa = PropertyAccess::createPropertyAccessor();

        $data = [];
        foreach ($group_models as $model) {
            $data[$pa->getValue($model, 'id')] = $pa->getValue($model, 'name');
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/ajax/get-teacher-by-university", name="ajax-get-teacher-by-university")
     * @param Request $request
     * @return JsonResponse
     */
    public function getTeacherByUniversity(Request $request)
    {
        $university_id = $request->get('university_id');
        $repo = $this->getDoctrine()->getRepository(Teacher::class);

        $teacher_models = $repo->findBy(['university' => $university_id]);

        $pa = PropertyAccess::createPropertyAccessor();

        $data = [];
        foreach ($teacher_models as $model) {
            $data[$pa->getValue($model, 'id')] = $pa->getValue($model, 'name_full');
        }

        return new JsonResponse($data);
    }
}