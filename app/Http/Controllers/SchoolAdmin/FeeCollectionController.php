<?php

namespace App\Http\Controllers\SchoolAdmin;

use Validator;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Student;
use App\Models\PaymentMode;
use Illuminate\Http\Request;
use App\Models\FeeCollection;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\User;

class FeeCollectionController extends Controller
{
    //
    public function index()
    {
        // Fetch students based on the request using the modified method
        // $studentsCollection = $this->getStudentsCollection($request->all());
        // $payment_mode = PaymentMode::all();
        // Fetch class details

        $classes = Classg::all();
        $section = Section::all();
        // Fetch students based on default class and section
        $page_title = 'Fee Collection Listing';
        return view('backend.school_admin.fee_collection.index', compact('page_title', 'classes', 'section'));
    }


    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'amount' => 'required',
            'payed_on' => 'required|date',
            'notes' => 'required',
            'payment_mode_id' => 'required',

        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $feeCollection = $request->all();
            // $feeCollection['student_id'] = auth()->user()->student->id;
            $feeCollection['payment_mode_id'] = 1;
            $feeCollection['fee_groups_types_id'] = 1;

            // $input['academic_session_id'] = 1;


            $savedData = FeeCollection::create($feeCollection);
            return redirect()->back()->withToastSuccess('Fee Collection Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $feeCollection = FeeCollection::find($id);
        return view('backend.school_admin.fee_collection.index', compact('feeCollection'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'amount' => 'required|integer',
            // 'payment_mode_id' => 'required|string',
            'payed_on' => 'required|date',
            'notes' => 'required|string',

        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $feeCollection = FeeCollection::findOrFail($id);

        if (!$feeCollection) {
            return back()->withToastError('Fee Collection not found.');
        }

        try {
            $data = $request->all();
            $data['student_id'] = 1;
            $data['payment_mode_id'] = 1;
            $data['fee_groups_types_id'] = 1;
            $feeCollection->update($data);

            return redirect()->back()->withToastSuccess('Fee Collection Updated Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Collection. Please try again')->withInput();
    }

    public function destroy($id)
    {
        $feeCollection = FeeCollection::find($id);

        try {
            $feeCollection->delete();
            return redirect()->back()->withToastSuccess('Fee Collection has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllFeeCollection(Request $request)
    {
        $feeCollection = $this->getForDataTable($request->all());
        // $feeCollection = $this->getStudentsCollection($request->all());

        return Datatables::of($feeCollection)
            ->escapeColumns([])
            ->addColumn('amount', function ($feeCollection) {
                return $feeCollection->amount;
            })

            ->addColumn('payed_on', function ($feeCollection) {
                return $feeCollection->payed_on;
            })

            ->addColumn('notes', function ($feeCollection) {
                return $feeCollection->notes;
            })
            ->addColumn('created_at', function ($feeCollection) {
                return $feeCollection->created_at->diffForHumans();
            })

            ->addColumn('actions', function ($feeCollection) {
                return view('backend.school_admin.fee_collection.partials.controller_action', ['feeCollection' => $feeCollection])->render();
            })
            ->make(true);
    }


    public function getForDataTable($request)
    {
        $dataTableQuery = FeeCollection::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }

    // RETRIVING SECTIONS OF THE RESPECTIVE CLASS
    // public function getSections($classId)
    // {
    //     $sections = Classg::find($classId)->sections()->pluck('sections.section_name', 'sections.id');

    //     return response()->json($sections);
    // }


    public function getStudentsCollection(Request $request)
    {
        $classId = $request->input('classId');
        $sectionId = $request->input('sectionId');

        $students = User::join('students', 'users.id', '=', 'students.user_id')
            ->where('users.user_type_id', '=', 8)
            ->when($classId, function ($query) use ($classId) {
                $query->where('students.class_id', $classId);
            })
            ->when($sectionId, function ($query) use ($sectionId) {
                $query->where('students.section_id', $sectionId);
            })
            ->select(
                'users.id as user_id',
                'users.f_name',
                'users.l_name',
                'users.father_name',
                'users.dob',
                'users.mobile_number',
                'students.admission_no',
                'students.class_id',
                'students.section_id',
            )
            ->get();


        return $students;
    }

    public function studentFee(Request $request, $userId)
    {
        $page_title = 'Student Fee';
        $studentDetails = User::join('students', 'users.id', '=', 'students.user_id')
            ->where('users.user_type_id', '=', 8)
            ->where('users.id', $userId)
            ->select(
                'users.id as user_id',
                'users.f_name',
                'users.l_name',
                'users.father_name',
                'users.dob',
                'users.mobile_number',
                'students.admission_no',
                'students.class_id',
                'students.section_id',
                'students.student_photo',
            )
            ->first();
        // Fetch class details
        $classDetails = Classg::find($studentDetails->class_id);

        // Fetch section details
        $sectionDetails = Section::find($studentDetails->section_id);

        return view('backend.school_admin.fee_collection.studentfee', ['studentDetails' => $studentDetails, 'classDetails' => $classDetails, 'page_title' => $page_title, 'sectionDetails' => $sectionDetails]);
    }
}
