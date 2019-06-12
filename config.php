<?php

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'The BaseCode Podcast',
    'siteDescription' => 'A podcast by developers on opposite sites of the planet discussing ways to make code less complex and more readable.',
    'siteAuthor' => 'JMac and Jess',

    // collections
    'collections' => [
        'posts' => [
            'author' => 'JMac and Jess', // Default author, if not provided in a post
            'sort' => '-date',
            'path' => '/{filename}',
        ],
    ],

    // helpers
    'url' => function ($page, $link) {
        return $page->baseUrl . '/' . trim($link, '/');
    },
    'getDate' => function ($page) {
        return Datetime::createFromFormat('U', $page->date);
    },
    'getExcerpt' => function ($page, $length = 255) {
        $content = $page->description ?? $page->getContent();
        $cleaned = strip_tags(
            preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content),
            '<code>'
        );

        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    },
    'isActive' => function ($page, $path) {
        return ends_with(trimPath($page->getPath()), trimPath($path));
    },
];
