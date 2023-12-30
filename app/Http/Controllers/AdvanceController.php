<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdvanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Calcutta");
    }

    public function index()
    {
        $drivers = User::select('id', 'name')->where('is_admin', 'No')->get();
        return view('advance', compact('drivers'));
    }
    public function fetch()
    {
        if(auth()->user()->is_admin == "Yes")
        {
            $data = Advance::with('user')->orderBy('date', 'DESC')->get();
        }else{
            $data = Advance::with('user')->where('user_id', auth()->user()->id)->orderBy('date', 'DESC')->get();
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<button data-id="' . $row->id . '" class="edit-btn btn btn-primary btn-xs"><i class="fas fa-edit"></i> Edit</button>
                            <button data-id="' . $row->id . '" class="delete-btn btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i> Delete</button>';

                return $btn;
            })
            ->addColumn('date', function ($row) {
                return date("d-m-Y", strtotime($row->created_at));
            })
            ->addColumn('amount', function ($row) {
                return "₹".number_format($row->amount,2);
            })

            ->rawColumns(['action','amount'])
            ->make(true);
    }
    public function create(Request $request)
    {
        $validated = $request->validate([
            'driver' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);
        if($request->edit_id)
        {
            $advance =Advance::find($request->edit_id);
        }else{
            $advance = new Advance();
        }
        $advance->user_id = $request->driver;
        $advance->date = $request->date;
        $advance->amount = $request->amount;
        $advance->save();

        return ['status' => 1, "message" => "Success"];
    }
    public function fetch_edit($id)
    {
        $advance = Advance::find($id);
        return $advance;
    }
    public function delete($id)
    {
        Advance::find($id)->delete();
        return ['status' => 1, "message" => "Success"];
    }
}
