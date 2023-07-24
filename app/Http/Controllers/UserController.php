<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('users');
    }

    public function getUserData(Request $request)
    {
        try {

            $requestData = $_REQUEST;

            $columns = array(
                0 => 'id',
                1 => 'name',
                2 => 'email',
                3 => 'created_at',
            );

            $totalData = User::all()->count();
            $totalFiltered = $totalData;
            $sql = User::select('id', 'name', 'email', 'email_verified_at', 'created_at');

            if (!empty($request->search['value'])) {
                $sql->where('name', 'LIKE', '%' . $request->search['value'] . '%')->orWhere('email', 'LIKE', '%' . $request->search['value'] . '%');
            }
            $sql = $sql->orderByRaw($columns[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
            $results = $sql->get();
            $totalData = count($results);
            $totalFiltered = $totalData;

            $data = array();
            $cnt = $request->start + 1;

            foreach ($results as $dt) {
                $nestedData = array();
                $nestedData[] = $cnt++;
                $nestedData[] = $dt->name;
                $nestedData[] = $dt->email;
                $nestedData[] = date('Y-m-d', strtotime($dt->created_at));
                $nestedData[] = '<div class="btn-group">
                                    <a type="button" href="' . url('user-detail/' . $dt->id) . '" class="btn btn-default"> <i class="fas fa-edit"></i> </a>
                                    <a type="button" href="' . url('delete-user/' . $dt->id) . '" class="btn btn-default " data-id="' . $dt->id . '"> <i class="fas fa-trash"></i> </a>  
                                </div>';
                $data[] = $nestedData;
            }

            return response()->json([
                'status' => true,
                "draw" => intval($requestData['draw']),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);
        }
    }

    public function getUserSingleData(Request $request, $id = null)
    {
        try {

            return view('userEditForm', ['data' => User::where('id', $id)->first()]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);
        }
    }

    public function saveUserData(Request $request)
    {
        try {

            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if (!empty($request->id)) {
                User::where('id', $request->id)->update($data);
                Session::flash('message', 'User Update Successfully!');
            } else {

                $data = $request->validate([
                    'name' => 'required|max:255',
                    'email' => 'required|email|unique:users',
                    'password' => 'required'
                ]);
                $data['password'] = bcrypt($request->password);
                $data['email_verified_at'] = 1;
                User::create($data);
                Session::flash('message', 'User Create Successfully!');
            }

            Session::flash('alert-class', 'alert-success');
            return redirect()->to('users');
        } catch (\Exception $e) {

            Session::flash('message', $e->getMessage());
            return redirect()->to('users');
        }
    }

    public function deleteUserData(Request $request, $id)
    {
        try {
            User::where('id', $id)->delete();
            Session::flash('message', 'User Delete Successfully!');
            Session::flash('alert-class', 'alert-danger');

            return redirect()->to('users');
        } catch (\Exception $e) {

            Session::flash('message', $e->getMessage());
            Session::flash('alert-class', 'alert-danger');

            return redirect()->to('users');
        }
    }
}
