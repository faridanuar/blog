<x-layout>
    <x-setting heading="Publish New Post">
        <form method="POST" action="/admin/posts" enctype="multipart/form-data">
            @csrf

            @include('admin.posts._form')
        </form>
    </x-setting>
</x-layout>
