<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        // register policy to auto assign method name matching because this controller uses resource method on web.php
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = User::where(['is_deleted' => 0])->where('role_id', '!=', User::ROLE_ADMIN)->filter(
            request(['search', 'role'])
        )->orderBy('created_at', 'desc')->paginate(18)->withQueryString();

        return view('dashboard.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $user = new User;
        return view('dashboard.users.create', ['user' => $user]);
    }

    public function store()
    {
        User::create(array_merge($this->validateUser(), [
            'user_id' => request()->user()->id,
            'avatar' => request()->file('avatar')->store('avatars')
        ]));

        return redirect('/');
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', ['user' => $user]);
    }

    public function update(User $user)
    {        
        $attributes = $this->validateUser($user);

        if ($attributes['password'] == null) {
            unset($attributes['password']);
        }
        
        if ($attributes['avatar'] ?? false) {
            $attributes['avatar'] = request()->file('avatar')->store('avatars');
        }

        $user->update($attributes);

        return back()->with('success', 'Record Updated!');
    }

    public function destroy(User $user)
    {
        $user->update(['is_deleted' => 1]);

        return back()->with('success', 'Record Deleted!');
    }

    protected function validateUser(?User $user = null): array
    {
        $user ??= new User();

        $rules = [
            'name' => 'required|max:255',
            'username' => ['required', Rule::unique('users', 'username')->ignore($user)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => $user->exists ? '' : 'required|min:6',
            'avatar' => $user->exists ? ['image'] : ['required', 'image'],
            'role_id' => 'required',
        ];

        return request()->validate($rules);
    }
}
