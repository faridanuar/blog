@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li><p class="text-red-500 text-xs mt-2">{{ $error }}</p></li>
        @endforeach
    </ul>
@endif

<x-form.input name="old_password" type="password" :value="old('old_password', $user->old_password)" required />
<x-form.input name="new_password" type="password" :value="old('new_password', $user->new_password)" required />
<x-form.input name="retype_password" type="password" :value="old('retype_password', $user->retype_password)" required />

<x-form.button>Update</x-form.button>