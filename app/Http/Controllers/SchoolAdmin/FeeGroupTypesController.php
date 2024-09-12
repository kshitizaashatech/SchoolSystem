<?php

namespace App\Http\Controllers\SchoolAdmin;

use Validator;
use App\Models\Classg;
use App\Models\FeeType;
use App\Models\FeeGroup;
use App\Models\FeeGroupType;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FeeGroupTypesController extends Controller
{
    //
    public function index()
    {
        $results = DB::table('fee_groups')
            ->join('fee_groups_types', 'fee_groups.id', '=', 'fee_groups_types.fee_group_id')
            ->join('fee_types', 'fee_types.id', '=', 'fee_groups_types.fee_type_id')
            ->select([
                'fee_groups_types.fee_group_id as fee_group_id',
                'fee_groups_types.id',
                'fee_groups.name as name',
                'fee_types.name as fee_group_type_name',
                'fee_groups_types.fee_type_id',
                'fee_groups_types.academic_session_id',
                'fee_groups_types.school_id',
                'fee_groups_types.amount',
                'fee_groups_types.is_active',
                'fee_groups_types.created_at',
                'fee_groups_types.updated_at',
            ])
            ->get()
            ->groupBy('name') // Group the result by fee_group_id key
            ->toArray();
            // dd($result);

        $feeTypes = FeeType::all();
        $feeGroups = FeeGroup::all();
        $academic_session = AcademicSession::all();
        $page_title = 'Fee Group Type Listing';

        $fee_group_types = FeeGroupType::with('feeType')->get();

        // Manipulate the data as needed
        $formattedData = $fee_group_types->map(function ($feeGroup) {
            return [
                'id' => $feeGroup->id,
                'fee_group_name' => $feeGroup->feeGroup->name,
                'amount' => $feeGroup->amount,
                'fee_type' => $feeGroup->feeType->toArray(),
            ];
        });
        // dd($formattedData);

        // $feeGroupType = FeeGroupType::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.school_admin.fee_group_type.index', compact('page_title','feeTypes','feeGroups','academic_session','results'));
    }

    // public function index()
    // {
    //     $feeTypes = FeeType::all();
    //     $feeGroups = FeeGroup::all();
    //     $academic_session = AcademicSession::all();
    //     $page_title = 'Fee Group Type Listing';

    //     $fee_group_types = FeeGroupType::with('feeType')->get();

    //     // Manipulate the data as needed
    //     $formattedData = $fee_group_types->map(function ($feeGroup, $index) use ($fee_group_types) {
    //         $rowspan = 1;

    //         // Check if the next item has the same fee group name
    //         if ($index < count($fee_group_types) - 1 && $feeGroup->feeGroup->name === $fee_group_types[$index + 1]->feeGroup->name) {
    //             // Increase rowspan if the next item has the same fee group name
    //             $rowspan++;
    //         }

    //         return [
    //             'id' => $feeGroup->id,
    //             'fee_group_name' => $feeGroup->feeGroup->name,
    //             'amount' => $feeGroup->amount,
    //             'fee_type' => $feeGroup->feeType->toArray(),
    //             'rowspan' => $rowspan, // Add the rowspan key
    //         ];
    //     });


    //     // $feeGroupType = FeeGroupType::orderBy('created_at', 'desc')->paginate(10);
    //     return view('backend.school_admin.fee_group_type.index', compact('page_title','feeTypes','feeGroups','academic_session','formattedData'));
    // }


    // public function store(Request $request)
    // {
    //     $validatedData = Validator::make($request->all(), [
    //         'amount' => 'required',
    //         'is_active' => 'required|boolean',
    //         'fee_type_id'=> 'required',
    //         'fee_group_id'=> 'required',

    //         'academic_session_id'=> 'required',

    //     ]);

    //     if ($validatedData->fails()) {
    //         return back()->withToastError($validatedData->messages()->all()[0])->withInput();
    //     }

    //     try {
    //         $feeGroupType = $request->all();
    //         $feeGroupType['school_id'] = 1;
    //         // $input['academic_session_id'] = 1;


    //         $savedData = FeeGroupType::create($feeGroupType);
    //         return redirect()->back()->withToastSuccess('Fee Group Type Saved Successfully!');
    //     } catch (\Exception $e) {
    //         return back()->withToastError($e->getMessage());
    //     }
    // }


public function store(Request $request)
{
    $validatedData = Validator::make($request->all(), [
        'amount' => 'required',
        'is_active' => 'required|boolean',
        'fee_type_id' => 'required',
        'fee_group_id' => [
            'required',
            Rule::unique('fee_groups_types')->where(function ($query) use ($request) {
                return $query->where('fee_type_id', $request->input('fee_type_id'))
                             ->where('academic_session_id', $request->input('academic_session_id'))
                             ->where('school_id', 1); // Adjust the condition based on your needs
            }),
        ],
        'academic_session_id' => 'required',
    ]);

    if ($validatedData->fails()) {
        return back()->withToastError($validatedData->messages()->all()[0])->withInput();
    }

    try {
        $feeGroupType = $request->all();
        $feeGroupType['school_id'] = 1;

        $savedData = FeeGroupType::create($feeGroupType);
        return redirect()->back()->withToastSuccess('Fee Group Type Saved Successfully!');
    } catch (\Exception $e) {
        return back()->withToastError($e->getMessage());
    }
}


    public function edit(string $id)
    {

        $feeGroupType = FeeGroupType::find($id);
        $page_title = 'Fee Group Type';
        return view('backend.school_admin.fee_group_type.index', compact('feeGroupType','page_title'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'amount' => 'required',
            'is_active' => 'required|boolean',
            'fee_type_id'=> 'required',
            'fee_group_id'=> 'required',
            'academic_session_id'=> 'required',

        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $feeGroupType = FeeGroupType::findOrFail($id);

        if (!$feeGroupType) {
            return back()->withToastError('Fee Group Type not found.');
        }

        try {
            $data = $request->all();
            $data['school_id'] = 1;
            $feeGroupType->update($data);

            return redirect()->back()->withToastSuccess('Fee Group Type Updated Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Fee Group Type. Please try again')->withInput();
    }



    public function destroy($id)
    {
        $feeGroupType = FeeGroupType::find($id);

        try {
            $feeGroupType->delete();
            return redirect()->back()->withToastSuccess('Fee Group Type has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
        return back()->withToastError('Something went wrong. Please try again');
    }

    public function show(){

    }



    // public function assignStudent(){
    //     $page_title = "Assign Student";

    //     $classes = Classg::all();
    //     $fee_group = FeeGroupType::all();
    //     $fee_code = FeeGroup::all();

    //     return view('backend.school_admin.fee_group_type.assign',['classes' =>$classes, 'fee_group' => $fee_group, 'fee_code'=>$fee_code, 'page_title' => $page_title]);

    // }

    public function assignStudent()
    {
        $page_title = "Assign Student";
        $classes = Classg::all();

        // Fetch fee-related information as needed
        $feeGroupTypes = FeeGroupType::all();
        $feeGroups = FeeGroup::all();

        // Combine the datasets for display in a single table
        $mergedData = $feeGroupTypes->merge($feeGroups);

        return view('backend.school_admin.fee_group_type.assign', [
            'classes' => $classes,
            'mergedData' => $mergedData,
            'page_title' => $page_title
        ]);
    }



}
