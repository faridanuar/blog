@props(['heading'])

<section class="py-8 max-w-6xl mx-auto">
    <h1 class="text-lg font-bold mb-8 pb-2 border-b">
        {{ $heading }}
    </h1>

    <div class="flex">
        <aside class="w-48 flex-shrink-0">
            <h4 class="font-semibold mb-4">Links</h4>
            <ul>
                <li>
                    <a href="/dashboard/posts" class="{{ request()->is('dashboard/posts') ? 'text-blue-500' : '' }}">All Posts</a>
                </li>
                <li>
                    <a href="/dashboard/posts/create" class="{{ request()->is('dashboard/posts/create') ? 'text-blue-500' : '' }}">New Post</a>
                </li>
            </ul>
            <div class="overflow-hidden border-b border-gray-200 my-1.5 w-36"></div>
            @admin
            <ul>
                <li>
                    <a href="/dashboard/users" class="{{ request()->is('dashboard/users') ? 'text-blue-500' : '' }}">Users</a>
                </li>
            </ul>
            <div class="overflow-hidden border-b border-gray-200 my-1.5 w-36"></div>
            @endadmin
            <ul>
                <li>
                    <a href="/profile" class="{{ request()->is('profile') ? 'text-blue-500' : '' }}">Profile</a>
                </li>
            </ul>
        </aside>

        <main class="flex-1">
            <x-panel>
                {{ $slot }}
            </x-panel>
        </main>
    </div>
</section>
