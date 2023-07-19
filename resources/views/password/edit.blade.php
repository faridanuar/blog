<x-layout>
    <x-setting :heading="'Edit Password'">
        <form method="POST" action="/password/update" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('password._form')
        </form>
    </x-setting>
</x-layout>
