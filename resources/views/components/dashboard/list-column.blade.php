

<td {{ $attributes->merge(['class' => 'px-2 py-4 whitespace-nowrap']) }}>
    <div class="flex items-center">
        <div class="text-sm font-medium text-gray-900">
            {{ $slot }}
        </div>
    </div>
</td>