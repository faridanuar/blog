<x-dashboard.list>
@forelse ($posts as $post)
    <tr>
        <x-dashboard.list-column class="text-right text-sm font-medium">
            <x-thumbnail :thumbnail="isset($post->thumbnail) ? $post->thumbnail : null" :width="80" />
        </x-dashboard.list-column>

        <x-dashboard.list-column>
            <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
        </x-dashboard.list-column>

        <x-dashboard.list-column>
            {{ \App\Utilities\Post\OptionList::value('post-status', $post->status_id) }}
        </x-dashboard.list-column>

        <x-dashboard.list-column>
            {{ date('d/m/Y, h:i A', strtotime($post->created_at)) }}
        </x-dashboard.list-column>

        <x-dashboard.list-column class="text-right text-sm font-medium">
            <a href="/dashboard/posts/{{ $post->id }}/edit" 
                class="text-blue-500 hover:text-blue-600">Edit</a>
        </x-dashboard.list-column>

        <x-dashboard.list-column class="text-right text-sm font-medium">
            <form method="POST" action="/dashboard/posts/{{ $post->id }}">
                @csrf
                @method('DELETE')

                <button class="text-xs text-gray-400">Delete</button>
            </form>
        </x-dashboard.list-column>
    </tr>
@empty
    <tr>
        <x-dashboard.list-column>Time to create your very first Post!</x-dashboard.list-column>
    </tr>
@endforelse
</x-dashboard.list>