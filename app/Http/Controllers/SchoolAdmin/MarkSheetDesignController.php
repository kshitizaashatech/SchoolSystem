<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\MarkSheetDesign;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class MarkSheetDesignController extends Controller
{
    protected $imageSavePath = '/uploads/students/mark_sheet/';
    //
    public function index()
    {
        $page_title = "List Mark Sheet Design";
        $mark_sheet_design = MarkSheetDesign::all();
        return view('backend.school_admin.mark_sheet_design.index', compact('page_title', 'mark_sheet_design'));
    }

    public function create()
    {
        $page_title = 'Create Mark Sheet Design';
        return view('backend.school_admin.mark_sheet_design.create', compact('page_title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'template' => 'nullable',
            // 'heading' => 'nullable',
            // 'title' => 'nullable|string',
            // 'left_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'right_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'left_sign' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'middle_sign' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'right_sign' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'background_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'is_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'exam_name' => 'nullable',
            // 'school_name' => 'nullable',
            'exam_center' => 'nullable',
            // 'exam_session' => 'nullable',
            'date' => 'nullable',
            'is_classteacher_remarks' => 'boolean',
            'is_name' => 'boolean',
            'is_father_name' => 'boolean',
            'is_photo' => 'boolean',
            'is_mother_name' => 'boolean',
            // 'is_dob' => 'boolean',
            'is_admission_no' => 'boolean',
            'is_roll_no' => 'boolean',
            'is_address' => 'boolean',
            'is_gender' => 'boolean',
            'is_division' => 'boolean',
            'is_rank' => 'boolean',
            'is_custom_field' => 'boolean',
            'is_class' => 'boolean',
            'is_session' => 'boolean',
            'content' => 'nullable|string',
            'content_footer' => 'nullable|string',
        ]);

        try {
            $input = $request->all();
            $input['school_id'] = 1;

            // for left_logo
            if ($request->hasFile('left_logo')) {
                $postPath = time() . '.' . $request->file('left_logo')->getClientOriginalExtension();
                $request->file('left_logo')->move(public_path('uploads/students/mark_sheet/'), $postPath);
                $input['left_logo'] = $postPath;
            } else {
                $input['left_logo'] = null;
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['left_logo'] = $destinationPath;
            }
            // for right_logo
            if ($request->hasFile('right_logo')) {
                $postPath = time() . '.' . $request->file('right_logo')->getClientOriginalExtension();
                $request->file('right_logo')->move(public_path('uploads/students/mark_sheet/'), $postPath);
                $input['right_logo'] = $postPath;
            } else {
                $input['right_logo'] = null;
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['right_logo'] = $destinationPath;
            }
            // for left sign
            if ($request->hasFile('left_sign')) {
                $postPath = time() . '.' . $request->file('left_sign')->getClientOriginalExtension();
                $request->file('left_sign')->move(public_path('uploads/students/mark_sheet/'), $postPath);
                $input['left_sign'] = $postPath;
            } else {
                $input['left_sign'] = null;
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['left_sign'] = $destinationPath;
            }

            // for middle sign
            if ($request->hasFile('middle_sign')) {
                $postPath = time() . '.' . $request->file('middle_sign')->getClientOriginalExtension();
                $request->file('middle_sign')->move(public_path('uploads/students/mark_sheet/'), $postPath);
                $input['middle_sign'] = $postPath;
            } else {
                $input['middle_sign'] = null;
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['middle_sign'] = $destinationPath;
            }

            // for right sign
            if ($request->hasFile('right_sign')) {
                $postPath = time() . '.' . $request->file('right_sign')->getClientOriginalExtension();
                $request->file('right_sign')->move(public_path('uploads/students/mark_sheet/'), $postPath);
                $input['right_sign'] = $postPath;
            } else {
                $input['right_sign'] = null;
            }
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['right_sign'] = $destinationPath;
            }
            // for background_img
            if ($request->hasFile('background_img')) {
                $postPath = time() . '.' . $request->file('background_img')->getClientOriginalExtension();
                $request->file('background_img')->move(public_path('uploads/students/mark_sheet/'), $postPath);
                $input['background_img'] = $postPath;
            } else {
                $input['background_img'] = null;
            }

            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $input['background_img'] = $destinationPath;
            }
            // for is_photo

            // if ($request->hasFile('is_photo')) {
            //     $postPath = time() . '.' . $request->file('is_photo')->getClientOriginalExtension();
            //     $request->file('is_photo')->move(public_path('uploads/students/mark_sheet/'), $postPath);
            //     $input['is_photo'] = $postPath;
            // } else {
            //     $input['is_photo'] = null;
            // }
            // if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
            //     if (!File::exists($this->imageSavePath)) {
            //         File::makeDirectory($this->imageSavePath, 0775, true, true);
            //     }
            //     $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            //     Image::make($request->input('inputCroppedPic'))
            //         ->encode('jpg')
            //         ->save(public_path($destinationPath));
            //     $input['is_photo'] = $destinationPath;
            // }
            $mark_sheet_design = MarkSheetDesign::create($input);
            if ($mark_sheet_design) {
                return redirect()->back()->withToastSuccess('Mark Sheet Design Successfully Created');
            }
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        try {
            $mark_sheet_design = MarkSheetDesign::findOrFail($id);
            $page_title = "Edit Mark Sheet Design";
            return view('backend.school_admin.mark_sheet_design.update', compact('mark_sheet_design', 'page_title'));
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $validatedData = $request->validate([
                'template' => 'nullable',
                // 'heading' => 'nullable',
                // 'title' => 'nullable|string',
                'left_logo' => 'nullable',
                'right_logo' => 'nullable',
                'left_sign' => 'nullable',
                'middle_sign' => 'nullable',
                'right_sign' => 'nullable',
                'background_img' => 'nullable',
                'is_photo' => 'nullable',
                'exam_name' => 'nullable',
                // 'school_name' => 'nullable',
                'exam_center' => 'nullable',
                // 'exam_session' => 'nullable',
                // 'date' => 'nullable',
                'is_classteacher_remarks' => 'boolean',
                'is_name' => 'boolean',
                'is_father_name' => 'boolean',
                'is_mother_name' => 'boolean',
                'is_dob' => 'boolean',
                'is_admission_no' => 'boolean',
                'is_roll_no' => 'boolean',
                'is_address' => 'boolean',
                'is_gender' => 'boolean',
                'is_division' => 'boolean',
                'is_rank' => 'boolean',
                'is_custom_field' => 'boolean',
                'is_class' => 'boolean',
                'is_session' => 'boolean',
                'content' => 'nullable|string',
                'content_footer' => 'nullable|string',
            ]);

            $input = $request->all();
            // dd($request->all());
            $input['school_id'] = 1;

            // Check if a new left_logo is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['left_logo'] = $destinationPath;
            } else {
                // Use the existing logo path if a new logo is not selected
                $input['left_logo'] = $request->input('old_left_logo');
            }
            // Remove the 'old_logo' field from the $input array
            unset($input['old_left_logo']);

            // Check if a new right_logo is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['right_logo'] = $destinationPath;
            } else {
                // Use the existing logo path if a new logo is not selected
                $input['right_logo'] = $request->input('old_right_logo');
            }
            // Remove the 'old_logo' field from the $input array
            unset($input['old_right_logo']);

            // Check if a new left sign is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['left_sign'] = $destinationPath;
            } else {
                // Use the existing logo path if a new logo is not selected
                $input['left_sign'] = $request->input('old_left_sign');
            }
            unset($input['old_left_sign']);



            // Check if a new middle sign is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['middle_sign'] = $destinationPath;
            } else {
                // Use the existing logo path if a new logo is not selected
                $input['middle_sign'] = $request->input('old_middle_sign');
            }
            unset($input['old_middle_sign']);



            // Check if a new right sign is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['right_sign'] = $destinationPath;
            } else {
                // Use the existing logo path if a new logo is not selected
                $input['right_sign'] = $request->input('old_right_sign');
            }
            unset($input['old_right_sign']);

            // Check if a new background_img is selected
            if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
                if (!File::exists($this->imageSavePath)) {
                    File::makeDirectory($this->imageSavePath, 0775, true, true);
                }
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));

                $input['background_img'] = $destinationPath;
            } else {
                // Use the existing logo path if a new logo is not selected
                $input['background_img'] = $request->input('old_background_img');
            }
            unset($input['old_background_img']);


            // // Check if a new is_photo is selected
            // if ($request->has('inputCroppedPic') && !is_null($request->inputCroppedPic)) {
            //     if (!File::exists($this->imageSavePath)) {
            //         File::makeDirectory($this->imageSavePath, 0775, true, true);
            //     }
            //     $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            //     Image::make($request->input('inputCroppedPic'))
            //         ->encode('jpg')
            //         ->save(public_path($destinationPath));

            //     $input['is_photo'] = $destinationPath;
            // } else {
            //     // Use the existing logo path if a new logo is not selected
            //     $input['is_photo'] = $request->input('old_is_photo');
            // }
            // unset($input['old_is_photo']);

            $mark_sheet_design = MarkSheetDesign::findOrFail($id);
            $mark_sheet_design->update($input);
            return redirect()->route('admin.mark-sheetdesigns.index')->withToastSuccess('Mark Sheet Design successfully Updated');
            $mark_sheet_design = MarkSheetDesign::findOrFail($id);
            $mark_sheet_design->update($input);
            return redirect()->route('admin.mark-sheetdesigns.index')->withToastSuccess('Mark Sheet Design successfully Updated');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }



    public function getAllMarkSheetDesign(Request $request)
    {
        $mark_sheet_design = $this->getForDataTable($request->all());
        // dd($user);
        return Datatables::of($mark_sheet_design)
            ->editColumn('heading', function ($row) {
                return $row->heading;
            })
            ->editColumn('title', function ($row) {
                return $row->title;
            })

            ->editColumn('exam_name', function ($row) {
                return $row->exam_name;
            })
            // ->editColumn('school_name', function ($row) {
            //     return $row->school_name;
            // })
            ->editColumn('exam_center', function ($row) {
                return $row->exam_center;
            })

            ->escapeColumns([])
            ->addColumn('created_at', function ($user) {
                return $user->created_at->diffForHumans();
            })

            ->addColumn('status', function ($mark_sheet_design) {
                return $mark_sheet_design->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })

            ->addColumn('actions', function ($mark_sheet_design) {
                return view('backend.school_admin.mark_sheet_design.partials.controller_action', [
                    'mark_sheet_design' => $mark_sheet_design
                ])->render();
            })

            ->make(true);
    }
    public function getForDataTable($request)
    {
        $dataTableQuery = MarkSheetDesign::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }

    public function destroy($id)
    {
        try {
            $mark_sheet_design = MarkSheetDesign::findOrfail($id);
            $mark_sheet_design->delete();
            return redirect()->back()->withToastSuccess('Mark Sheet Design Successfully Deleted');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
}
