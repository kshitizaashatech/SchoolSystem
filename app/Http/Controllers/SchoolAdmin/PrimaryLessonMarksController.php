<?php

namespace App\Http\Controllers\SchoolAdmin;

use Validator;
use App\Models\Classg;
use App\Models\Subject;
use App\Rules\UniqueLessons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PrimaryLessonMarks;
use App\Models\PrimaryMarks;
use Yajra\Datatables\Datatables;

class PrimaryLessonMarksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'Primary Lesson/Marks Listing';
        $schoolId = session('school_id');
        $subjectgroup = Subject::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();

        $classess = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.school_admin.primary_marks.index', compact('page_title', 'classess', 'subjectgroup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id',
            'subject_group_id' => 'required|numeric|exists:subject_groups,id',
            'subject_id' => 'required|numeric|exists:subjects,id',
            'lessons' => 'required|array|max:255',
            'marks' => 'required|array|max:255',
            'subject_group' => [new UniqueLessons($request->input('class_id'), $request->input('sections'), $request->input('subject_group_id'), $request->input('subject_id'), $request->input('lessons'))],
        ]);

        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        // try {
        //     $data = $request->only(['subject_group_id', 'subject_id', 'class_id']);
        //     $data['academic_session_id'] = session('academic_session_id');
        //     $data['school_id'] = session('school_id');
        //     foreach ($request->input('sections') as $section) {
        //         foreach ($request->input('lessons') as $lesson) {
        //             foreach ($request->input('marks') as $mark) {
        //                 // dd($mark);
        //                 $data['name'] = $lesson;
        //                 $data['section_id'] = $section;
        //                 $data['marks'] = $mark;
        //                 $savedData = PrimaryMarks::Create($data);
        //             }
        //         }
        //     }
        //     return redirect()->back()->withToastSuccess('Primary Marks Saved Successfully!');
        // } catch (\Exception $e) {
        //     return back()->withToastError($e->getMessage());
        // }

        try {
            $academic_session_id = session('academic_session_id');
            $school_id = session('school_id');

            $sections = $request->input('sections');
            $lessons = $request->input('lessons');
            $marks = $request->input('marks');

            foreach ($sections as $section) {
                foreach ($lessons as $key => $lesson) {
                    $data = [
                        'subject_group_id' => $request->input('subject_group_id'),
                        'subject_id' => $request->input('subject_id'),
                        'class_id' => $request->input('class_id'),
                        'section_id' => $section,
                        'academic_session_id' => $academic_session_id,
                        'school_id' => $school_id,
                        'name' => $lesson,
                        'marks' => $marks[$key],
                    ];
                    PrimaryLessonMarks::create($data);
                }
            }

            return redirect()->back()->withToastSuccess('Primary Marks Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $primaryMarks = PrimaryLessonMarks::find($id);

        return view('backend.school_admin.primary_marks.index', compact('primaryMarks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id',
            'subject_group_id' => 'required|numeric|exists:subject_groups,id',
            'subject_id' => 'required|numeric|exists:subjects,id',
            'lessons' => 'required|array|max:255',
            'marks' => 'required|array|max:255',
            'subject_group' => [new UniqueLessons($request->input('class_id'), $request->input('sections'), $request->input('subject_group_id'), $request->input('subject_id'), $request->input('lessons'), $id)],
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            // Retrieve the request data
            $requestData = $request->only(['subject_group_id', 'subject_id', 'class_id', 'sections']);
            $requestData['academic_session_id'] = session('academic_session_id');
            $requestData['school_id'] = session('school_id');

            //if the lesson is removed then remove from records
            $this->removeNonArrayLessons($requestData, $request->input('lessons'));

            // Iterate over the sections and lessons arrays
            foreach ($request->input('sections') as $section) {
                foreach ($request->input('lessons') as $key => $lesson) {
                    // Find the lesson by the provided data
                    $lessonData = [
                        'school_id' => $requestData['school_id'],
                        'academic_session_id' => $requestData['academic_session_id'],
                        'class_id' => $requestData['class_id'],
                        'section_id' => $section,
                        'subject_group_id' => $requestData['subject_group_id'],
                        'subject_id' => $requestData['subject_id'],
                        'name' => $lesson,
                    ];

                    // Add marks to the lesson data
                    $lessonData['marks'] = $request->input('marks')[$key];

                    // Update or create the lesson
                    PrimaryLessonMarks::updateOrCreate($lessonData);
                }
            }

            return redirect()->back()->withToastSuccess('Successfully Updated Primary Marks!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    public function removeNonArrayLessons($requestData, $arrayLesson)
    {
        // Retrieve existing lessons based on provided criteria
        $existingLessons = PrimaryLessonMarks::where([
            'school_id' => $requestData['school_id'],
            'academic_session_id' => $requestData['academic_session_id'],
            'class_id' => $requestData['class_id'],
            'section_id' => $requestData['sections'][0],
            'subject_group_id' => $requestData['subject_group_id'],
            'subject_id' => $requestData['subject_id'],
        ])->get();

        // Iterate over existing lessons
        foreach ($existingLessons as $existingLesson) {
            // Check if the existing lesson's section is not present in the input sections array
            if (!in_array($existingLesson->name, $arrayLesson)) {
                // Delete the lesson from the database if it's not present in the input sections array
                $existingLesson->delete();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = PrimaryLessonMarks::find($id);
        //select all lessons based on class, section, subject_groups, and subject
        try {
            $lesson = PrimaryLessonMarks::where([
                'school_id' => session('school_id'),
                'academic_session_id' => session('academic_session_id'),
                'class_id' => $lesson->class_id,
                'section_id' => $lesson->section_id,
                'subject_group_id' => $lesson->subject_group_id,
                'subject_id' => $lesson->subject_id,
            ])->delete();
            return redirect()->back()->withToastSuccess('Primary Lesson has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }

    public function getAllMarks(Request $request)
    {
        $lesson = $this->getForDataTable($request->all());
        // dd($lesson);
        $data = [];

        // Iterate through the $lessons array and reformat the data
        foreach ($lesson as $classId => $class) {
            foreach ($class as $sectionId => $section) {

                // Get the lesson names and id individually
                $lessonNames = [];
                $lessonId = [];
                $lessonMarks = [];
                foreach ($section['subject'] as $lesson) {
                    foreach ($lesson['lessons'] as $less) {
                        // dd($less);
                        $lessonNames[] = $less['name'];
                        $lessonMarks[] = $less['marks'];
                        $lessonId[] = $less['id'];
                    }
                }

                $lessonsString = implode('<br>', $lessonNames);
                // dd($lessonsString);
                $data[] = [
                    'id' => $section['id'],
                    'class' => $section['class_name'],
                    'class_id' => $section['class_id'],
                    'section' => $section['section_name'],
                    'section_id' => $section['section_id'],
                    'subject_group' => $section['subject_group_name'],
                    'subject_group_id' => $section['subject_group_id'],
                    'subject' => $section['subject_name'],
                    'subject_id' => $section['subject_id'],
                    'lessons' => $lessonsString,
                    'marks' => $lessonMarks,
                    'lessons_id' => $lessonId,
                ];
            }
        }
        return Datatables::of($data)
            ->escapeColumns([])
            // ->addColumn('class', function ($data) {
            //     return $data['class_name'] ?? 'Undefined';
            // })
            ->addColumn('class', function ($data) {
                return $data['class'];
            })

            ->addColumn('actions', function ($data) {
                return view('backend.school_admin.primary_marks.partials.controller_action', ['primaryMarks' => $data])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request = null)
    {
        // Retrieve all lessons
        $primaryMarks = PrimaryLessonMarks::all();
        // dd($primaryMarks);

        // Initialize an empty array to store the manipulated data
        $manipulatedData = [];

        // Loop through the lessons and organize the data as needed
        foreach ($primaryMarks as $lesson) {
            // dd($lesson);
            $classId = $lesson->class_id;
            $sectionId = $lesson->section_id;
            $subjectGroupId = $lesson->subject_group_id;
            $subjectId = $lesson->subject_id;
            //
            $class_name = $lesson->classes->class;
            $section_name = $lesson->sections->section_name;
            $subject_group_name = $lesson->subjectGroups->subject_group_name;
            $subject_name = $lesson->subjects->subject;
            $lessonName = $lesson->name;
            $lessonMarks = $lesson->marks;
            // dd($lessonMarks);
            $lesson_id = $lesson->id;

            // Create a nested structure as per the desired format
            $manipulatedData[$classId][$sectionId]['id'] = $lesson->id;
            $manipulatedData[$classId][$sectionId]['class_id'] = $classId;
            $manipulatedData[$classId][$sectionId]['class_name'] = $class_name;
            $manipulatedData[$classId][$sectionId]['section_id'] = $sectionId;
            $manipulatedData[$classId][$sectionId]['section_name'] = $section_name;
            $manipulatedData[$classId][$sectionId]['subject_group_id'] = $subjectGroupId;
            $manipulatedData[$classId][$sectionId]['subject_group_name'] = $subject_group_name;
            $manipulatedData[$classId][$sectionId]['subject_id'] = $subjectId;
            $manipulatedData[$classId][$sectionId]['subject_name'] = $subject_name;
            $manipulatedData[$classId][$sectionId]['subject'][$subjectId]['lessons'][] = [
                'name' => $lessonName,
                'marks' => $lessonMarks,
                'id' => $lesson_id,
            ];
        }

        // dd($manipulatedData);
        return $manipulatedData;
    }
}
