<?php

namespace App\Http\Controllers\Shared;
use App\Models\EcaActivity;
use App\Models\ExtraCurricularHead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\School;
use Yajra\Datatables\Datatables;

class EcaActivityController extends Controller
{
    public function index()
    {
        $page_title = 'ECA Activities';
        $ecaHeads = ExtraCurricularHead::where('is_active', 1)->get();
        $schools = School::all();
        return view('backend.shared.extraactivities.index', compact('page_title', 'ecaHeads', 'schools'));
    }

    public function getEcaActivities(Request $request)
    {
        if ($request->ajax()) {
            $data = EcaActivity::with('ecaHead')->get();
            return Datatables::of($data)
                ->addColumn('actions', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit-eca-activity btn btn-warning btn-sm" data-id="'.$row->id.'" data-title="'.$row->title.'" data-description="'.$row->description.'" data-player_type="'.$row->player_type.'" data-is_active="'.$row->is_active.'" data-eca_head_id="'.$row->eca_head_id.'">Edit</a>';
                    $btn .= ' <form action="'.route('admin.eca_activities.destroy', $row->id).'" method="POST" style="display:inline-block;">';
                    $btn .= csrf_field();
                    $btn .= method_field('DELETE');
                    $btn .= ' <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>';
                    $btn .= '</form>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'player_type' => 'required|in:single,multi',
            'is_active' => 'required|boolean',
            'eca_head_id' => 'required|exists:extra_curricular_heads,id',
            'school_ids' => 'required|array',
            'school_ids.*' => 'exists:schools,id',
            'pdf_image' => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('pdf_image')) {
            $data['pdf_image'] = $request->file('pdf_image')->store('pdf_images');
        }

        $ecaActivity = EcaActivity::create($data);
        $ecaActivity->schools()->sync($request->school_ids);

        return redirect()->route('admin.eca_activities.index')->with('success', 'ECA Activity created successfully.');
    }

    public function update(Request $request, EcaActivity $ecaActivity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'player_type' => 'required|in:single,multi',
            'is_active' => 'required|boolean',
            'eca_head_id' => 'required|exists:extra_curricular_heads,id',
            'school_ids' => 'required|array',
            'school_ids.*' => 'exists:schools,id',
            'pdf_image' => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('pdf_image')) {
            $data['pdf_image'] = $request->file('pdf_image')->store('pdf_images');
        }

        $ecaActivity->update($data);
        $ecaActivity->schools()->sync($request->school_ids);

        return redirect()->route('admin.eca_activities.index')->with('success', 'ECA Activity updated successfully.');
    }

    public function destroy($id)
    {
        $ecaActivity = EcaActivity::findOrFail($id);
        if ($ecaActivity->pdf_image) {
            unlink(public_path('uploads/eca_activities') . '/' . $ecaActivity->pdf_image);
        }
        $ecaActivity->delete();
        return redirect()->route('admin.eca_activities.index')->with('success', 'ECA Activity deleted successfully.');
    }
}
