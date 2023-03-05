@props(['avatar'])

<img src="{{ ($avatar)? asset('storage/' . $post->user->avatar) : '/images/no-avatar.png' }}" alt="avatar_image" width="80" class="rounded-xl">
