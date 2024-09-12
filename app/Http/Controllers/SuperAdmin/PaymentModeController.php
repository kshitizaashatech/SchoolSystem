<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMode;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;

class PaymentModeController extends Controller
{
    //
    public function index()
    {
        $page_title = 'Payment Mode Listing';
        return view('backend.shared.payment_mode.index', compact('page_title'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'payment_mode' => 'required|string',
            'is_active' => 'required|boolean',


        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            $paymentMode = $request->all();


            // $input['academic_session_id'] = 1;


            $savedData = PaymentMode::create($paymentMode);
            return redirect()->back()->withToastSuccess('Payment Mode Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $paymentMode = PaymentMode::find($id);
        return view('backend.shared.payment_mode.index', compact('paymentMode'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'payment_mode' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $paymentMode = PaymentMode::findOrFail($id);

        if (!$paymentMode) {
            return back()->withToastError('Payment mode not found.');
        }

        try {
            $data = $request->all();
            $paymentMode->update($data);

            return redirect()->back()->withToastSuccess('Payment Mode Updated Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
        return back()->withToastError('Cannot Update Payment Mode. Please try again')->withInput();
    }

    public function destroy($id)
    {
        $paymentMode = PaymentMode::find($id);

        try {
            $paymentMode->delete();
            return redirect()->back()->withToastSuccess('Payment Mode has been Successfully Deleted!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
        return back()->withToastError('Something went wrong. Please try again');
    }

    public function getAllPaymentMode(Request $request)
    {
        $paymentMode = $this->getForDataTable($request->all());

        return Datatables::of($paymentMode)
            ->escapeColumns([])
            ->addColumn('payment_mode', function ($paymentMode) {
                return $paymentMode->payment_mode;
            })

            ->addColumn('status', function ($paymentMode) {
                return $paymentMode->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($paymentMode) {
                return view('backend.shared.payment_mode.partials.controller_action', ['paymentMode' => $paymentMode])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = PaymentMode::where(function ($query) use ($request) {
            if (isset($request->id)) {
                $query->where('id', $request->id);
            }
        })
            ->get();

        return $dataTableQuery;
    }




}
