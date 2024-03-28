<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="{{ $page->meta_description ?? $page->siteDescription }}">

        <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ $page->getUrl() }}" />
        <meta property="og:description" content="{{ $page->description ?? $page->siteDescription }}" />
        <meta property="og:image" content="{{ $page->url('assets/img/logo-square.png') }}" />

        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}" />
        <meta name="twitter:description" content="{{ $page->description ?? $page->siteDescription }}" />
        <meta name="twitter:image" content="{{ $page->url('assets/img/logo-square.png') }}" />

        <title>{{ $page->siteName }}{{ $page->title ? ' | ' . $page->title : '' }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="icon" href="/favicon.ico">
        <link type="application/rss+xml" rel="alternate" title="The BaseCode Podcast" href="https://feeds.transistor.fm/basecode-podcast"/>

        @stack('meta')

        @if ($page->production)
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111862243-2"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', 'UA-111862243-1');
            </script>
        @endif

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i,800,800i" rel="stylesheet">
        <link rel="stylesheet" href="{{ $page->url(mix('css/main.css', 'assets/build')) }}">
    </head>

    <body class="border-t-8 border-orange-500 bg-gray-100 text-gray-800 leading-normal font-sans">
        <div class="flex flex-col justify-between min-h-screen max-w-xl mx-auto px-4">
            <header class="mt-8 mb-2 sm:mt-16 sm:mb-4 text-center" role="banner">
                <a href="/" title="{{ $page->siteName }} home" class="flex-shrink-0">
                    <img class="inline-block h-32 sm:h-64 border" src="{{ $page->url('assets/img/logo.png') }}" alt="{{ $page->siteName }} logo" />
                </a>
                <p class="mt-4 max-w-md mx-auto sm:mt-8 text-base sm:text-xl text-gray-600 italic">
                    A podcast by developers on opposite sites of the planet discussing ways to make code <strong class="text-gray-700 whitespace-no-wrap">less complex</strong> and <strong class="text-gray-700 whitespace-no-wrap">more readable</strong>.
                </p>
                <hr>
            </header>

            <main role="main">
                @yield('body')
            </main>

            <footer class="text-center text-sm mt-12" role="contentinfo">
                <div>
                    <div class="uppercase mb-4 text-xs text-gray-600 tracking-wider">Hosted by</div>

                    <a href="https://twitter.com/gonedark" class="group inline-block mx-1 sm:mx-2 text-base text-gray-700 hover:text-gray-800">
                        <img class="inline-block h-20 w-20 sm:h-24 sm:w-24 mb-2 border-2 border-white rounded-full shadow group-hover:shadow-md" src="{{ $page->url('assets/img/jmac.jpg') }}" />
                        <div>JMac</div>
                    </a>

                    <a href="https://twitter.com/jessarchercodes" class="group inline-block mx-1 sm:mx-2 text-base text-gray-700 hover:text-gray-800">
                        <img class="inline-block h-20 w-20 sm:h-24 sm:w-24 mb-2 border-2 border-white rounded-full shadow group-hover:shadow-md" src="{{ $page->url('assets/img/jess.jpg') }}" />
                        <div>Jess</div>
                    </a>
                </div>

                <div class="mt-10 text-gray-600">
                    &copy; Copyright {{ date('Y') }}.
                </div>

                <div class="mb-6 text-gray-600">
                    Built with <a href="http://jigsaw.tighten.co" title="Jigsaw by Tighten">Jigsaw</a>
                    and <a href="https://tailwindcss.com" title="Tailwind CSS, a utility-first CSS framework">Tailwind CSS</a>.
                </div>
            </footer>
        </div>

        <script src="{{ $page->url(mix('js/main.js', 'assets/build')) }}"></script>

        @stack('scripts')
    </body>
</html>
