<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Course;
use App\Entity\Faculty;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\FacultyRepository;
use App\Repository\PartyRepository;
use App\Repository\ScheduleRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AjaxRequestController extends AbstractController
{
    protected $accessService;
    protected $universityRepo;
    protected $buildingRepo;
    protected $cabinetRepo;
    protected $partyRepo;
    protected $teacherRepo;
    protected $scheduleRepo;
    protected $universityTimeRepo;
    protected $facultyRepo;
    protected $weekRepo;


    public function __construct(WeekRepository $weekRepository, FacultyRepository $facultyRepository, UniversityTimeRepository $universityTimeRepository, ScheduleRepository $scheduleRepository, TeacherRepository $teacherRepository, PartyRepository $partyRepository, UniversityRepository $universityRepo, CabinetRepository $cabinetRepository, BuildingRepository $buildingRepository)
    {
        //Repository
        $this->buildingRepo = $buildingRepository;
        $this->universityRepo = $universityRepo;
        $this->cabinetRepo = $cabinetRepository;
        $this->partyRepo = $partyRepository;
        $this->teacherRepo = $teacherRepository;
        $this->scheduleRepo = $scheduleRepository;
        $this->universityTimeRepo = $universityTimeRepository;
        $this->facultyRepo = $facultyRepository;
        $this->weekRepo = $weekRepository;
    }

    /**
     * @Route("/ajax/set-language", name="ajax-set-language")
     * @param Request $request
     * @return JsonResponse
     */
    public function setLanguage(Request $request)
    {
        $locale = $request->get('_locale');
        if ($locale) {
            $request->getSession()->set('_locale', $locale);
        }
        return new JsonResponse(true);
    }

    /**
     * @Route("/ajax/get-building-by-university", name="ajax-get-building-by-university")
     * @param Request $request
     * @return JsonResponse
     */
    public function getBuildingByUniversity(Request $request)
    {
        $id = $request->get('universityId');
        $models = $this->buildingRepo->findBy(['university' => $id]);

        $data = [];
        foreach ($models as $model) {
            $data[$model->id] = $model->complexName;
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/ajax/get-week-by-university", name="ajax-get-week-by-university")
     * @param Request $request
     * @return JsonResponse
     */
    public function getWeekByUniversity(Request $request)
    {
        $id = $request->get('universityId');
        $models = $this->weekRepo->findBy(['university' => $id]);

        $data = [];
        foreach ($models as $model) {
            $data[$model->id] = $model->name;
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/ajax/get-time-by-university", name="ajax-get-time-by-university")
     * @param Request $request
     * @return JsonResponse
     */
    public function getTimeByUniversity(Request $request)
    {
        $id = $request->get('universityId');
        $models = $this->universityTimeRepo->findBy(['university' => $id]);

        $data = [];
        foreach ($models as $model) {
            $data[$model->id] = $model->name;
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
    public function getCabinetByBuilding(Request $request)
    {
        $id = $request->get('buildingId');
        $models = $this->cabinetRepo->findBy(['building' => $id]);

        $data = [];
        foreach ($models as $model) {
            $data[$model->id] = $model->name;
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
        $id = $request->get('universityId');
        $facultyModels = ArrayHelper::getColumn($this->facultyRepo->findBy(['university' => $id]), 'id');
        $models = $this->partyRepo->findBy(['faculty' => $facultyModels]);

        $data = [];
        foreach ($models as $model) {
            $data[$model->id] = $model->name;
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
        $id = $request->get('universityId');
        $models = $this->teacherRepo->findBy(['university' => $id]);

        $data = [];
        foreach ($models as $model) {
            $data[$model->id] = $model->name;
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/ajax/test-route", name="test-route")
     * @param Request $request
     * @return JsonResponse
     */
    public function getTest(Request $request)
    {

        $data = [
            ['id' => 100, 'text' => 'abc1'],
            ['id' => 100, 'text' => 'fgs2']
        ];
        return new JsonResponse($data);

    }
}