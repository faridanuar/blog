<x-layout>
    <x-setting :heading="'Edit User: ' . $user->name">
        <form method="POST" action="/dashboard/users/{{ $user->id }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('dashboard.users._form')
        </form>
    </x-setting>
</x-layout>
