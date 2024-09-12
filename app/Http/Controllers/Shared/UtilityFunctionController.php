<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Http\Services\FormService;
use Illuminate\Http\Request;

class UtilityFunctionController extends Controller
{
    protected $formService;
    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getDistrict($province_id)
    {

        $districts = $this->formService->getDistricts($province_id);
        return response()->json($districts);
    }

    public function getMunicipality($district_id)
    {

        $municipalities = $this->formService->getMunicipalities($district_id);
        return response()->json($municipalities);
    }

    public function getWard($municipality_id)
    {
        $wards = $this->formService->getWards($municipality_id);

        return response()->json($wards);
    }

    public function getSubjectGroupByClassAndSection(Request $request)
    {
        $subjects = $this->formService->getSubjectGroupByClassAndSections($request);
        return response()->json($subjects);
    }
    public function getLessonsGroupByClassSectionSubjectgroupAndSubject(Request $request)
    {
        $subjects = $this->formService->getLessonsGroupByClassSectionSubjectgroupAndSubject($request);
        return response()->json($subjects);
    }

    // FOR PRIMARY MARKS/LESSONS
    public function getLessonsGroupByClassSectionSubjectgroupAndSubjectPrimary(Request $request)
    {
        $subjects = $this->formService->getLessonsGroupByClassSectionSubjectgroupAndSubjectPrimary($request);
        return response()->json($subjects);
    }

    public function getSubjects($subject_group_id)
    {
        $subjects = $this->formService->getSubjectsBySubjectGroup($subject_group_id);
        return response()->json($subjects);
    }

    public function getTopicsByClassSectionSubjectgroupSubjectAndLesson(Request $request)
    {
        $topics = $this->formService->getTopicsByClassSectionSubjectgroupSubjectAndLesson($request);

        return response()->json($topics);
    }

    public function getLesson($topic_id)
    {
        $lessons = $this->formService->getLesson($topic_id);

        return response()->json($lessons);
    }

    public function getSection($class_id)
    {
        $sections = $this->formService->getSection($class_id);

        return response()->json($sections);
    }
    public function getStudentBySection($classId, $sectionId)
    {
        $students = $this->formService->getStudentBySection($classId, $sectionId);
        return response()->json($students);
    }

    public function getStudentsBySection($classId, $sectionId, $date = null)
    {
        $students = $this->formService->getStudentsBySection($classId, $sectionId, $date);
        return response()->json($students);
    }
    public function getStudentsByClassSection($classId, $sectionId)
    {
        $students = $this->formService->getStudentsByClassSection($classId, $sectionId);
        return response()->json($students);
    }

    public function getSubjectsBySubjectGroup(Request $request)
    {
        $subjectGroupId = $request->input('subject_group_id');
        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');

        $subjects = $this->formService->getSubjectsBySubjectGroupId($subjectGroupId, $classId, $sectionId);

        return response()->json($subjects);
    }
}