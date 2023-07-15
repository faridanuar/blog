<x-layout>
    <x-setting heading="Create New User">
        <form method="POST" action="/dashboard/users" enctype="multipart/form-data">
            @csrf

            @include('dashboard.users._form')
        </form>
    </x-setting>
</x-layout>
