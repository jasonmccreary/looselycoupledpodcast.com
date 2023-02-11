---
pagination:
    collection: posts
    perPage: 50
---
@extends('_layouts.master')

@section('body')
    @if($post = $pagination->items->shift())
        @include('_components.post-full-inline')
        <hr>
    @endif

    @foreach ($pagination->items as $post)
        @include('_components.post-preview-inline')
        <hr>
    @endforeach

    @if ($pagination->pages->count() > 1)
        <nav class="flex text-base my-8">
            @if ($previous = $pagination->previous)
                <a
                    href="{{ $previous }}"
                    title="Previous Page"
                    class="bg-gray-100 hover:bg-gray-300 rounded mr-3 px-5 py-3"
                >&LeftArrow;</a>
            @endif

            @foreach ($pagination->pages as $pageNumber => $path)
                <a
                    href="{{ $path }}"
                    title="Go to Page {{ $pageNumber }}"
                    class="bg-gray-100 hover:bg-gray-300 text-orange-800 rounded mr-3 px-5 py-3 {{ $pagination->currentPage == $pageNumber ? 'text-orange-500' : '' }}"
                >{{ $pageNumber }}</a>
            @endforeach

            @if ($next = $pagination->next)
                <a
                    href="{{ $next }}"
                    title="Next Page"
                    class="bg-gray-100 hover:bg-gray-300 rounded mr-3 px-5 py-3"
                >&RightArrow;</a>
            @endif
        </nav>
    @endif
@stop
