@props(['avatar'])

<img src="{{ ($avatar)? asset('storage/'.$avatar) : '/images/no-avatar.png' }}" alt="avatar_image" width="80" {{ $attributes->merge(['class' => 'rounded-xl']) }}>
