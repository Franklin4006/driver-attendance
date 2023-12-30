<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Attendance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Calcutta");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date = date("Y-m-d");
        $user_id = auth()->user()->id;
        $check_punched = Attendance::where('date', $date)->where("user_id", $user_id)->first();

        $this_month = [];
        $last_month = [];

        /* This Month */

        $this_month_advance = Advance::where('date', ">=", date("Y-m-01"))->where("user_id", $user_id)->sum('amount');
        $this_month_workingdays = Attendance::where('date', ">=", date("Y-m-01"))->where("user_id", $user_id)->get()->count();

        $this_month['workingdays'] = $this_month_workingdays;
        $this_month['salary'] = ($this_month_workingdays * auth()->user()->salary);
        $this_month['advance'] = $this_month_advance;
        $this_month['balance'] = ($this_month_workingdays * auth()->user()->salary) - $this_month_advance;

        /* Last Minth */

        $last_month_advance = Advance::where('date', ">=", date("Y-m-01", strtotime('-1 month')))->where('date', "<=", date("Y-m-t", strtotime('-1 month')))->where("user_id", $user_id)->sum('amount');
        $last_month_workingdays = Attendance::where('date', ">=", date("Y-m-01", strtotime('-1 month')))->where('date', "<=", date("Y-m-t", strtotime('-1 month')))->where("user_id", $user_id)->get()->count();

        $last_month['workingdays'] = $last_month_workingdays;
        $last_month['salary'] = ($last_month_workingdays * auth()->user()->salary);
        $last_month['advance'] = $last_month_advance;
        $last_month['balance'] = ($last_month_workingdays * auth()->user()->salary) - $last_month_advance;

        return view('home', compact('check_punched', 'this_month', 'last_month'));
    }

    public function get_date_time()
    {
        return date("Y-m-d H:i:s");
    }
}
