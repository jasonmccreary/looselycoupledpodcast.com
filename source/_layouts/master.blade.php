<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="{{ $page->meta_description ?? $page->siteDescription }}">

        <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:description" content="{{ $page->siteDescription }}" />

        <title>{{ $page->siteName }}{{ $page->title ? ' | ' . $page->title : '' }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="icon" href="/favicon.ico">
        <link href="/blog/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">

        @stack('meta')

        @if ($page->production)
            <!-- Insert analytics code here -->
        @endif

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i,800,800i" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
    </head>

    <body class="border-t-4 border-red-500 bg-gray-100 text-gray-800 leading-normal font-sans">
        <div class="flex flex-col justify-between min-h-screen max-w-xl mx-auto px-4">
            <header class="mt-8 mb-2 sm:mt-16 sm:mb-4 text-center" role="banner">
                <a href="/" title="{{ $page->siteName }} home" class="flex-shrink-0">
                    <img class="inline-block h-20 sm:h-32" src="/assets/img/logo.svg" alt="{{ $page->siteName }} logo" />
                </a>
                <p class="mt-4 max-w-sm mx-auto sm:mt-8 text-gray-600">
                    {{ $page->siteDescription }}
                </p>
            </header>

            <main role="main">
                @yield('body')
            </main>

            <footer class="text-center text-sm mt-12" role="contentinfo">
                <div>
                    <div class="uppercase mb-4 text-xs text-gray-600 tracking-wider">Hosted by</div>

                    <a href="https://twitter.com/gonedark" class="group inline-block mx-1 sm:mx-2 text-base text-gray-700 hover:text-gray-800">
                        <img class="inline-block h-20 w-20 sm:h-24 sm:w-24 mb-2 border-2 border-white rounded-full shadow group-hover:shadow-md" src="/assets/img/jmac.jpg" />
                        <div>JMac</div>
                    </a>

                    <a href="https://twitter.com/jessarchercodes" class="group inline-block mx-1 sm:mx-2 text-base text-gray-700 hover:text-gray-800">
                        <img class="inline-block h-20 w-20 sm:h-24 sm:w-24 mb-2 border-2 border-white rounded-full shadow group-hover:shadow-md" src="/assets/img/jess.jpg" />
                        <div>Jess</div>
                    </a>
                </div>

                <ul class="flex flex-col md:flex-row justify-center mt-10">
                    <li class="md:mr-2">
                        &copy; The Loosely Coupled Podcast {{ date('Y') }}.
                    </li>

                    <li>
                        Built with <a href="http://jigsaw.tighten.co" title="Jigsaw by Tighten">Jigsaw</a>
                        and <a href="https://tailwindcss.com" title="Tailwind CSS, a utility-first CSS framework">Tailwind CSS</a>.
                    </li>
                </ul>
            </footer>
        </div>

        <script src="{{ mix('js/main.js', 'assets/build') }}"></script>

        @stack('scripts')
    </body>
</html>
