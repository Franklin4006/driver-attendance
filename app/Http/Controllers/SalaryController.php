<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $drivers = User::select('id', 'name')->where('is_admin', 'No')->get();

        $this_month_data = [];
        $last_month_data = [];

        foreach ($drivers as $da) {
            $user_id = $da->id;

            /* This Month */

            $this_month_advance = Advance::where('date', ">=", date("Y-m-01"))->where("user_id", $user_id)->sum('amount');
            $this_month_workingdays = Attendance::where('date', ">=", date("Y-m-01"))->where("user_id", $user_id)->get()->count();

            $this_month['name'] = $da->name;
            $this_month['workingdays'] = $this_month_workingdays;
            $this_month['salary'] = ($this_month_workingdays * auth()->user()->salary);
            $this_month['advance'] = $this_month_advance;
            $this_month['balance'] = ($this_month_workingdays * auth()->user()->salary) - $this_month_advance;

            $this_month_data[] = $this_month;

            /* Last Month */

            $last_month_advance = Advance::where('date', ">=", date("Y-m-01", strtotime('-1 month')))->where('date', "<=", date("Y-m-t", strtotime('-1 month')))->where("user_id", $user_id)->sum('amount');
            $last_month_workingdays = Attendance::where('date', ">=", date("Y-m-01", strtotime('-1 month')))->where('date', "<=", date("Y-m-t", strtotime('-1 month')))->where("user_id", $user_id)->get()->count();

            $last_month['name'] = $da->name;
            $last_month['workingdays'] = $last_month_workingdays;
            $last_month['salary'] = ($last_month_workingdays * auth()->user()->salary);
            $last_month['advance'] = $last_month_advance;
            $last_month['balance'] = ($last_month_workingdays * auth()->user()->salary) - $last_month_advance;

            $last_month_data[] = $last_month;
        }

        return view('salary', compact('this_month_data', 'last_month_data'));
    }
}
