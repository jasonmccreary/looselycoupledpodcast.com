<div class="flex flex-col mb-4">
    <p class="text-gray-700 font-medium my-2 text-sm tracking-wider uppercase">
        {{ $post->getDate()->format('F j, Y') }}
    </p>

    <h2 class="text-3xl sm:text-4xl mt-0">
        <a
            href="{{ $post->getUrl() }}"
            title="Read more - {{ $post->title }}"
            class="text-black font-extrabold"
        >{{ $post->title }}</a>
    </h2>

    {!! $post->getContent() !!}
</div>
