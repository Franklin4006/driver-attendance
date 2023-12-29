<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Calcutta");
    }

    public function index()
    {
        $drivers = User::select('id', 'name')->where('is_admin', 'No')->get();
        return view('attendance', compact('drivers'));
    }

    public function punch_in(Request $request)
    {
        $validated = $request->validate([
            'datetime' => 'required',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $date = date("Y-m-d");
        $user_id = auth()->user()->id;

        $check_exist = Attendance::where('date', $date)->where("user_id", $user_id)->first();

        if (!$check_exist) {
            $attendance = new Attendance();

            $attendance->user_id = $user_id;
            $attendance->date = $date;
            $attendance->latitude = $request->latitude;
            $attendance->longitude = $request->longitude;
            $attendance->punch_in_at = date("Y-m-d H:i:s");
            $attendance->save();

            return ['status' => 1, "message" => "Success"];
        } else {
            return ['status' => 0, "message" => "Already Punched Today"];
        }
    }

    public function fetch()
    {
        $data = Attendance::with('user')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<button data-id="' . $row->id . '" class="edit-btn btn btn-primary btn-xs"><i class="fas fa-edit"></i> Edit</button>
                            <button data-id="' . $row->id . '" class="delete-btn btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i> Delete</button>';

                return $btn;
            })
            ->addColumn('time', function ($row) {
                return date("h:i A", strtotime($row->created_at));
            })
            ->addColumn('location', function ($row) {
                return "<a href='#' onclick=open_location('" . $row->latitude . "','" . $row->longitude . "')><i class='fas fa-map-marker-alt'></i></a>";
            })
            ->rawColumns(['action', 'time', 'location'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'driver' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        $date = $request->date;
        $user_id = $request->driver;

        $check_exist = Attendance::where('date', $date)->where("user_id", $user_id)->first();

        if (!$check_exist) {
            $attendance = new Attendance();

            $attendance->user_id = $user_id;
            $attendance->date = $date;
            $attendance->latitude = $request->latitude;
            $attendance->longitude = $request->longitude;
            $attendance->punch_in_at = $request->date . " " . $request->time;
            $attendance->save();

            return ['status' => 1, "message" => "Success"];
        } else {
            return ['status' => 0, "message" => "Already Punched"];
        }
    }
    public function fetch_edit($id, Request $request)
    {
        $attendance = Attendance::find($id);

        $data = array(
            "driver" => $attendance->user_id,
            "date" => $attendance->date,
            "time" => date("H:i:s", strtotime($attendance->punch_in_at)),
            "latitude" => $attendance->latitude,
            "longitude" => $attendance->longitude,
        );

        return $data;
    }
    public function delete($id)
    {
        Attendance::where('id', $id)->delete();
        return array("status" => 1, "message" => "Record deleted successfully");
    }
}
