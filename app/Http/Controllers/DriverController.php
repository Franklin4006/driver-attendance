<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class DriverController extends Controller
{
    public function index()
    {
        return view('drivers.index');
    }

    public function store(Request $request)
    {
        if ($request->edit_id) {
            $this->validate($request, [
                'mobile' => 'required|unique:users,mobile,' . $request->edit_id,
            ]);

            $user = User::find($request->edit_id);
            $message = "Driver Updated Successfully";
        } else {
            $this->validate($request, [
                'mobile' => 'required|unique:users,mobile',
            ]);

            $user = new User();
            $message = "Driver Created Successfully";
        }

        if($request->input('password'))
        {
            $user->password = Hash::make($request->input('password'));
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->salary = $request->input('salary');

        $user->save();

        return array("status" => 1, "message" => $message);
    }

    public function fetch()
    {
        $data = User::select('id', 'name','email', 'mobile','salary')->where('is_admin','No');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<button data-id="' . $row->id . '" class="edit-btn btn btn-primary btn-xs"><i class="fas fa-edit"></i> Edit</button>
                            <button data-id="' . $row->id . '" class="delete-btn btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i> Delete</button>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function fetch_edit($id)
    {
        $user = User::select('id', 'name', 'mobile', 'email', 'salary')->find($id);
        return ['driver' => $user];
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
        return array("status" => 1, "message" => "Driver deleted successfully");
    }
}
