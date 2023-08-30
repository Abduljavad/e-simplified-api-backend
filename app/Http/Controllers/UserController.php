<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('super_admin')->only('index');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if ($request->avatar) $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        
        $user->update($data);

        return $this->successResponse('User-Profile updated successfully', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        $this->authorize('accessResource', $user);

        $user->delete();

        return $this->successResponse('User deleted Successfully');
    }

    public function index()
    {
        $users = User::paginate();
        return $this->successResponse('users fetched successfully', ['users' => $users]);
    }
}
