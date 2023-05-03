<x-layout>
    <x-setting :heading="'Edit Profile'">
        <form method="POST" action="/profile/edit" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <x-form.input name="name" :value="old('name', $model->name)" required />
            <x-form.input name="username" :value="old('slug', $model->username)" required />

            <div class="flex mt-6">
                <div class="flex-1">
                    <x-form.input name="avatar" type="file" :value="old('avatar', $model->avatar)" />
                </div>

                <img src="{{ asset('storage/' . $model->avatar) }}" alt="" class="rounded-xl ml-6" width="100">
            </div>

            <x-form.button>Update</x-form.button>
        </form>
    </x-setting>
</x-layout>
