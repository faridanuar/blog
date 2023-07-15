<x-layout>
    <x-setting heading="Publish New Post">
        <form method="POST" action="/dashboard/posts" enctype="multipart/form-data">
            @csrf

            @include('dashboard.posts._form')
        </form>
    </x-setting>
</x-layout>
