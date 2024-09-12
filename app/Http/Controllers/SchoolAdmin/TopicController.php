<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\Classg;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Rules\UniqueTopic;

class TopicController extends Controller
{
    public function index()
    {
        $page_title = 'Topic Listing';
        $schoolId = session('school_id');
        $subjectgroup = Subject::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        $classess = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();
        // $subjectgroup = Subject::orderBy('created_at', 'desc')->get();
        // $classess = Classg::orderBy('created_at', 'desc')->get();
        return view('backend.school_admin.topics.index', compact('page_title', 'classess', 'subjectgroup'));
    }
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'class_id' => 'required|numeric|exists:classes,id',
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id',
            'subject_group_id' => 'required|numeric|exists:subject_groups,id',
            'subject_id' => 'required|numeric|exists:subjects,id',
            'lesson_id' => 'required|numeric|exists:lessons,id',
            'topic_name' => 'required|array|max:255',
            'topic_name' => [new UniqueTopic($request->input('class_id'), $request->input('sections'), $request->input('subject_group_id'), $request->input('subject_id'), $request->input('lesson_id'), $request->input('topic_name'))],
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $data = $request->only(['subject_group_id', 'subject_id', 'class_id', 'lesson_id']);
            $data['academic_session_id'] = session('academic_session_id');
            $data['school_id'] = session('school_id');
            foreach ($request->input('sections') as $section) {
                foreach ($request->input('topic_name') as $topic) {
                    // dd($topic);
                    $data['topic_name'] = $topic;
                    $data['section_id'] = $section;
                    $savedData = Topic::Create($data);
                }
            }
            return redirect()->back()->withToastSuccess('Topic Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $topic = Topic::find($id);

        return view('backend.school_admin.topics.index', compact('topic'));
    }
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'class_id' => 'required|numeric|exists:classes,id',
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id',
            'subject_group_id' => 'required|numeric|exists:subject_groups,id',
            'subject_id' => 'required|numeric|exists:subjects,id',
            'lesson_id' => 'required|numeric|exists:lessons,id',
            'topic_name' => 'required|array|max:255',
            'subject_group' => [new UniqueTopic($request->input('class_id'), $request->input('sections'), $request->input('subject_group_id'), $request->input('subject_id'), $request->input('lesson_id'), $request->input('topic_name'), $id)],
        ]);
        if ($validatedData->fails()) {

            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $topic = Topic::findorfail($id);
        try {
            // Retrieve the request data
            $requestData = $request->only(['subject_group_id', 'subject_id', 'class_id', 'sections', 'lesson_id']);
            $requestData['academic_session_id'] = session('academic_session_id');
            $requestData['school_id'] = session('school_id');

            //if the lesson is removed then remove from records
            $this->removeNonArrayTopics($requestData, $request->input('topic_name'));

            // Iterate over the sections and lessons arrays
            foreach ($request->input('sections') as $section) {
                foreach ($request->input('topic_name') as $topic) {
                    // Find the topic by the provided data
                    $topicData = [
                        'school_id' => $requestData['school_id'],
                        'academic_session_id' => $requestData['academic_session_id'],
                        'class_id' => $requestData['class_id'],
                        'section_id' => $section,
                        'subject_group_id' => $requestData['subject_group_id'],
                        'subject_id' => $requestData['subject_id'],
                        'lesson_id' => $requestData['lesson_id'],
                        'topic_name' => $topic
                    ];

                    // Update or create the topic
                    Topic::updateOrCreate($topicData);
                }
            }

            return redirect()->back()->withToastSuccess('Successfully Updated Topic!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Topic Please try again')->withInput();
    }

    public function removeNonArrayTopics($requestData, $arrayTopic)
    {
        // Retrieve existing topics based on provided criteria
        $existingTopics = Topic::where([
            'school_id' => $requestData['school_id'],
            'academic_session_id' => $requestData['academic_session_id'],
            'class_id' => $requestData['class_id'],
            'section_id' => $requestData['sections'][0],
            'subject_group_id' => $requestData['subject_group_id'],
            'subject_id' => $requestData['subject_id'],
            'lesson_id' => $requestData['lesson_id'],
        ])->get();

        // Iterate over existing topics
        foreach ($existingTopics as $existingTopic) {
            // Check if the existing topic's section is not present in the input sections array
            if (!in_array($existingTopic->topic_name, $arrayTopic)) {
                // Delete the topic from the database if it's not present in the input sections array
                $existingTopic->delete();
            }
        }
    }
    public function destroy(string $id)
    {
        $topic = Topic::find($id);
        try {
            $lesson = Topic::where([
                'school_id' => session('school_id'),
                'academic_session_id' => session('academic_session_id'),
                'class_id' => $topic->class_id,
                'section_id' => $topic->section_id,
                'subject_group_id' => $topic->subject_group_id,
                'subject_id' => $topic->subject_id,
                'lesson_id' => $topic->lesson_id,
            ])->delete();
            return redirect()->back()->withToastSuccess('Topic has been Successfully Deleted!');
        } catch (Exception $e) {
            $error_message = $e->getMessage();
            return back()->withToastError($e->getMessage());
        }

        return back()->withToastError('Something went wrong. please try again');
    }
    public function getAllTopics(Request $request)
    {
        $topics = $this->getForDataTable($request->all());
        // dd($topics);
        $data = [];

        // Iterate through the $topics array and reformat the data
        foreach ($topics as $classId => $class) {
            foreach ($class as $sectionId => $section) {

                foreach ($section['lessons'] as $lessonId => $lesson) {

                    // Initialize arrays for topic names and IDs for this lesson
                    $lessonTopicNames = [];
                    $topicId = [];

                    // Iterate through topics in this lesson
                    foreach ($lesson['topic'] as $topic) {
                        // Add topic name and ID to the arrays for this lesson
                        $lessonTopicNames[] = $topic['name'];
                        $topicId[] = $topic['id'];
                    }

                    $topicsString = implode('<br>', $lessonTopicNames);

                    /// here starting main code
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
                        'lessons' => $lesson['lesson_name'],
                        'lesson_id' => $lesson['lesson_id'],
                        'topics' => $topicsString,
                        'topic_id' => $topicId,
                    ];
                }
                ///

                // Get the top$topics names and id individually
                // $topicName = [];
                // $topicId = [];
                // foreach ($section['topics'] as $topics) {
                //     foreach ($topics['topic'] as $less) {
                //         $topicName[] = $less['name'];
                //         $topicId[] = $less['id'];

                //     }
                // }

                // $topicsString = implode('<br>', $topicName);
                // // dd($topicsString);
                // $data[] = [
                //     'id' => $section['id'],
                //     'class' => $section['class_name'],
                //     'class_id' => $section['class_id'],
                //     'section' => $section['section_name'],
                //     'section_id' => $section['section_id'],
                //     'subject_group' => $section['subject_group_name'],
                //     'subject_group_id' => $section['subject_group_id'],
                //     'subject' => $section['subject_name'],
                //     'subject_id' => $section['subject_id'],
                //     'lessons' => $section['lesson_name'],
                //     'lesson_id' => $section['lesson_id'],
                //     'topics' => $topicsString,
                //     'topic_id' => $topicId,
                // ];
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
                return view('backend.school_admin.topics.partials.controller_action', ['topic' => $data])->render();
            })

            ->make(true);
    }

    public function getForDataTable($request)
    {
        // Retrieve all topic
        $topic = Topic::all();

        // Initialize an empty array to store the manipulated data
        $manipulatedData = [];

        // Loop through the topic and organize the data as needed
        foreach ($topic as $topic) {
            $classId = $topic->class_id;
            $sectionId = $topic->section_id;
            $subjectGroupId = $topic->subject_group_id;
            $subjectId = $topic->subject_id;
            $lessonId = $topic->lesson_id;
            //
            $class_name = $topic->classes->class;
            $section_name = $topic->sections->section_name;
            $subject_group_name = $topic->subjectGroups->subject_group_name;
            $subject_name = $topic->subjects->subject;
            $lesson_name = $topic->lessons->name;
            $topicName = $topic->topic_name;
            $topic_id = $topic->id;

            // Create a nested structure as per the desired format
            $manipulatedData[$classId][$sectionId]['id'] = $topic->id;
            $manipulatedData[$classId][$sectionId]['class_id'] = $classId;
            $manipulatedData[$classId][$sectionId]['class_name'] = $class_name;
            $manipulatedData[$classId][$sectionId]['section_id'] = $sectionId;
            $manipulatedData[$classId][$sectionId]['section_name'] = $section_name;
            $manipulatedData[$classId][$sectionId]['subject_group_id'] = $subjectGroupId;
            $manipulatedData[$classId][$sectionId]['subject_group_name'] = $subject_group_name;
            $manipulatedData[$classId][$sectionId]['subject_id'] = $subjectId;
            $manipulatedData[$classId][$sectionId]['subject_name'] = $subject_name;
            $manipulatedData[$classId][$sectionId]['lessons'][$lessonId]['lesson_id'] = $lessonId;
            $manipulatedData[$classId][$sectionId]['lessons'][$lessonId]['lesson_name'] = $lesson_name;
            $manipulatedData[$classId][$sectionId]['lessons'][$lessonId]['topic'][] = [
                'name' => $topicName,
                'id' => $topic_id,
            ];
        }
        // dd($manipulatedData);
        return $manipulatedData;
    }
}
