<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <x-panel>
                <div style="float:right;"><a href="/profile/edit">Edit</a></div>
                <div><h1 class="text-center font-bold text-xl">Profile Overview</h1></div>
                
                <div class="flex justify-center items-center mt-7">
                    <img src="{{ ($model->avatar)? asset('storage/'.$model->avatar) : '/images/no-avatar.png' }}" alt="avatar_image" width="300" class='rounded-xl border-2 border-sky-500'>
                </div>

                <div class="grid place-items-center mt-5">
                    <div class="p-2"><h4>{{ ucfirst($model->name) }}</h4></div>
                    <div class="p-2"><span style="font-size:12;color:grey;">{{ '@'.$model->username }}</span></div>
                </div>
            </x-panel>
        </main>
    </section>
</x-layout>