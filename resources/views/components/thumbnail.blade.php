@props(['thumbnail', 'width' => null])

<img src="{{ ($thumbnail)? asset('storage/' . $thumbnail) : '/images/no-image.png' }}" alt="thumbnail_image" class="rounded-xl" width={{ $width }} />
