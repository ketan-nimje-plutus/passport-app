<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserApiController extends Controller
{

    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);

            $data['password'] = bcrypt($request->password);

            $user = User::create($data);
            $token = $user->createToken('AppToken')->accessToken;

            return response()->json(['status' => true, 'user' => $user, 'token' => $token]);
            
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'user' => []]);
        }
    }

    public function login(Request $request)
    {

        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['status' => false, 'message' => 'Incorrect Details. Please try again']);
        }

        $token = auth()->user()->createToken('AppToken')->accessToken;

        return response()->json(['status' => true, 'message' => 'Login Successfully!', 'user' => auth()->user(), 'token' => $token]);
    }

    public function getUserData(Request $request)
    {

        try {

            $limit = $request->page_size;
            $page = $request->page;
            $search = $request->search;
            $sql = User::select('id', 'name', 'email', 'email_verified_at', 'created_at');
            if (!empty($search)) {
                $sql->where('name', 'LIKE', '%' . $search . '%')->orWhere('email', 'LIKE', '%' . $search . '%');
            }
            $results =  $sql->skip(($page - 1) *  $limit)->take($limit)->get();

            return response()->json(['status' => true, 'message' => '', 'count' => User::count(), 'data' => $results]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);
        }
    }

    public function getUserSingleData(Request $request, $id)
    {
        try {
            return response()->json(['status' => true, 'message' => '', 'data' => User::where('id', $id)->first()]);
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
                return response()->json(['status' => true, 'message' => 'Update Successfully!', 'error' => [], 'data' => []]);
            } else {

                $data = $request->validate([
                    'name' => 'required|max:255',
                    'email' => 'required|email|unique:users',
                    'password' => 'required'
                ]);

                $data['password'] = bcrypt($request->password);
                $data['email_verified_at'] = 1;
                $user = User::create($data);
                return response()->json(['status' => true, 'message' => 'Create Successfully!', 'error' => [], 'data' => $user]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'error' => [], 'data' => []]);
        }
    }

    public function deleteUserData(Request $request)
    {
        try {
            if (!empty($request->id)) {
                User::where('id', $request->id)->delete();
            }
            return response()->json(['status' => true, 'message' => 'Delete Successfully!', 'data' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);
        }
    }
    public function deleteBulkUserData(Request $request)
    {
        try {
            if (!empty($request->users_id)) {
                User::whereIn('id', $request->users_id)->delete();
            }
            return response()->json(['status' => true, 'message' => 'Delete Successfully!', 'data' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => []]);
        }
    }
}
