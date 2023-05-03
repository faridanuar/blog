@props(['thumbnail'])

<img src="{{ ($thumbnail)? asset('storage/' . $thumbnail) : '/images/no-image.png' }}" alt="thumbnail_image" class="rounded-xl">
