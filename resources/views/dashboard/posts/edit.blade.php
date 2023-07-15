<x-layout>
    <x-setting :heading="'Edit Post: ' . $post->title">
        <form method="POST" action="/dashboard/posts/{{ $post->id }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('dashboard.posts._form')
        </form>
    </x-setting>
</x-layout>
