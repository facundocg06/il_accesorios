<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Messages\ErrorMessages;
use App\Models\Services\UserService;
use App\Http\Messages\SuccessMessages;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function user_list()
    {
        $users = $this->userService->getAll();
        return view('content.user.user-list', compact('users'));
    }
    public function register_user(UserRequest $userRequest)
    {
        try {
            $this->userService->createUser($userRequest->all());
            return redirect()->route('user-list')->with('success', SuccessMessages::USER_CREATED);
        } catch (Exception $e) {
            return redirect()->route('user-list')->with('error', ErrorMessages::USER_CREATION_ERROR);
        }
    }
    public function edit_user($id){

    }
    public function update_user(Request $request, $id){
        try {
            $this->userService->updateUser($request->all(),$id);
            return redirect()->route('user-list')->with('success', SuccessMessages::USER_UPDATED);
        } catch (Exception $e) {
            return redirect()->route('user-list')->with('error', ErrorMessages::USER_UPDATE_ERROR);
        }
    }
    public function delete_user($id){
        try {
            $this->userService->deleteUser($id);
            return redirect()->route('user-list')->with('success', SuccessMessages::USER_DELETED);
        } catch (Exception $e) {
            return redirect()->route('user-list')->with('error', ErrorMessages::USER_DELETE_ERROR);
        }
    }
}
