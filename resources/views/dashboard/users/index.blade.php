<x-dashboard.list>
    <tr>
        <x-dashboard.list-column class="px-10">
            <a href="/dashboard/users/create" class="text-blue-500 hover:text-blue-600">New</a>
        </x-dashboard.list-column>
    </tr>
@forelse ($users as $user)
    <tr>
        <x-dashboard.list-column class="text-right text-sm font-medium">
            <x-thumbnail :thumbnail="isset($user->avatar) ? $user->avatar : null" :width="80" />
        </x-dashboard.list-column>

        <x-dashboard.list-column>
            <a href="/dashboard/users/{{ $user->id }}">{{ $user->name }}</a>
        </x-dashboard.list-column>

        <x-dashboard.list-column>
            {{ $user->email }}
        </x-dashboard.list-column>

        <x-dashboard.list-column>
            {{ \App\Utilities\User\OptionList::value('user-role', $user->role_id) }}
        </x-dashboard.list-column>

        <x-dashboard.list-column>
            {{ date('d/m/Y, h:i A', strtotime($user->created_at)) }}
        </x-dashboard.list-column>

        <x-dashboard.list-column class="text-right text-sm font-medium">
            <a href="/dashboard/users/{{ $user->id }}/edit" class="text-blue-500 hover:text-blue-600">Edit</a>
        </x-dashboard.list-column>

        <x-dashboard.list-column class="text-right text-sm font-medium">
            <form method="POST" action="/dashboard/users/{{ $user->id }}">
                @csrf
                @method('DELETE')

                <button class="text-xs text-gray-400">Delete</button>
            </form>
        </x-dashboard.list-column>
    </tr>
@empty
    <tr>
        <x-dashboard.list-column>Time to create your very first User!</x-dashboard.list-column>
    </tr>
@endforelse
</x-dashboard.list>