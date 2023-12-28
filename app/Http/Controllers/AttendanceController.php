<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Calcutta");
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

        if(!$check_exist)
        {
            $attendance = new Attendance();

            $attendance->user_id = $user_id;
            $attendance->date = $date;
            $attendance->latitude = $request->latitude;
            $attendance->longitude = $request->longitude;
            $attendance->punch_in_at = date("Y-m-d H:i:s");
            $attendance->save();

            return ['status' => 1, "message" => "Success"];

        }else
        {
            return ['status' => 0, "message" => "Already Punched Today"];
        }

    }
}
