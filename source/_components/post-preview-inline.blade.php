<div class="flex flex-col mb-4">
    <p class="text-gray-600 font-medium my-2 text-xs tracking-widest uppercase">
        {{ $post->getDate()->format('F j, Y') }}
    </p>

    <h2 class="text-2xl sm:text-3xl mt-0">
        <a
            href="{{ $post->getUrl() }}"
            title="Read more - {{ $post->title }}"
            class="text-gray-800"
        >{{ $post->title }}</a>
    </h2>

    <p class="mb-4 mt-0">{!! $post->getExcerpt(200) !!}</p>
</div>
