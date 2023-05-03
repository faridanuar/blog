<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', [
            'model' => request()->user(),
        ]);
    }

    public function edit()
    {
        $model = request()->user();
        return view('profile.edit', ['model' => $model]);
    }

    public function update()
    {
        $model = request()->user();
        $attributes = $this->validateModel($model);

        if ($attributes['avatar'] ?? false) {
            $attributes['avatar'] = request()->file('avatar')->store('avatar');
        }

        $model->update($attributes);

        return back()->with('success', 'User Updated!');
    }

    protected function validateModel(?User $model = null): array
    {
        $model ??= new User();

        return request()->validate([
            'name' => 'required',
            'username' => ['required', Rule::unique('users', 'username')->ignore($model)],
            'avatar' => $model->exists ? ['image'] : ['required', 'image'],
        ]);
    }
}
