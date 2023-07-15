@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li><p class="text-red-500 text-xs mt-2">{{ $error }}</p></li>
        @endforeach
    </ul>
@endif

<x-form.input name="name" :value="old('name', $user->name)" required />
<x-form.input name="username" :value="old('username', $user->username)" required />
<x-form.input name="email" :value="old('email', $user->email)" required />
<x-form.input name="password" />

<div class="mt-6">
    <div class="flex-1">
        <x-form.input name="avatar" type="file" :value="old('avatar', $user->avatar)" />
    </div>

    @if ($user->avatar)
        <div class="mt-6">
            <x-form.label name="Avatar Preview"/>
            <x-panel class="mt-2 w-36">
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="" class="rounded-xl" width="100">
            </x-panel>
        </div>
    @endif
</div>

<x-form.field>
    <x-form.label name="role"/>

    <select name="role_id" id="role_id" required>
        @foreach (\App\Utilities\User\OptionList::render('user-role') as $key => $role)
            <option
                value="{{ $key }}"
                {{ old('status_id', $user->role_id) == $key ? 'selected' : '' }}
            >{{ ucwords($role) }}</option>
        @endforeach
    </select>

    <x-form.error name="role_id"/>
</x-form.field>

@if ($user->exists) 
<x-form.button>Update</x-form.button>
@else
<x-form.button>Save</x-form.button>
@endif