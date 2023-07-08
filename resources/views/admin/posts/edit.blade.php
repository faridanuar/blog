<x-layout>
    <x-setting :heading="'Edit Post: ' . $post->title">
        <form method="POST" action="/admin/posts/{{ $post->id }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <x-form.input name="title" :value="old('title', $post->title)" required />
            <x-form.input name="slug" :value="old('slug', $post->slug)" required />

            <div class="mt-6">
                <div class="flex-1">
                    <x-form.input name="thumbnail" type="file" :value="old('thumbnail', $post->thumbnail)" />
                </div>

                @if ($post->thumbnail)
                    <div class="mt-6">
                        <x-form.label name="Thumbnail Preview"/>
                        <x-panel class="mt-2 w-36">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="" class="rounded-xl" width="100">
                        </x-panel>
                    </div>
                @endif
            </div>

            <x-form.textarea name="excerpt" required>{{ old('excerpt', $post->excerpt) }}</x-form.textarea>
            <x-form.textarea name="body" required>{{ old('body', $post->body) }}</x-form.textarea>

            <x-form.field>
                <x-form.label name="category"/>

                <select name="category_id" id="category_id" required>
                    @foreach (\App\Models\Category::all() as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}
                        >{{ ucwords($category->name) }}</option>
                    @endforeach
                </select>

                <x-form.error name="category"/>
            </x-form.field>

            <x-form.field>
                <x-form.label name="Status"/>

                <select name="status_id" id="status_id" required>
                    @foreach (\App\Utilities\posts\OptionList::render('post-status') as $key => $status)
                        <option
                            value="{{ $key }}"
                            {{ old('status_id', $post->status_id) == $key ? 'selected' : '' }}
                        >{{ ucwords($status) }}</option>
                    @endforeach
                </select>

                <x-form.error name="status"/>
            </x-form.field>

            <x-form.button>Update</x-form.button>
        </form>
    </x-setting>
</x-layout>
