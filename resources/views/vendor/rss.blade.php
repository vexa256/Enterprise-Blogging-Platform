<?php echo '<'.'?xml version="1.0" encoding="UTF-8"?>'; ?>

<rss version="2.0"
     xmlns:blogChannel="http://backend.userland.com/blogChannelModule"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:atom="http://www.w3.org/2005/Atom">

    <channel>
        <title><![CDATA[  {!! get_buzzy_config('sitetitle') !!}   ]]> Rss</title>
        <link>{{ url('/') }}</link>
        <description><![CDATA[  {!! get_buzzy_config('sitedesc') !!}   ]]></description>
        <language>{{ \Config::get('app.locale') }}</language>
        <lastBuildDate>{{ $posts->slice(0,1)->first()->published_at->toRfc2822String() }}</lastBuildDate>
        <atom:link href="{{ url(Request::segment(1)) }}" rel="self" />

        <image>
            <title><![CDATA[  {!! get_buzzy_config('sitetitle') !!}   ]]></title>
            <url>{{ asset('assets/images/logo.png') }}</url>
            <link>{{ url('/') }}</link>
        </image>

        @foreach($posts as $post)
            <item>
                <title><![CDATA[  {!!  $post->title !!}   ]]></title>
                <link>{{ url(generate_post_url($post)) }}</link>
                <description><![CDATA[ {!! $post->body!!}  ]]></description>
                <media:thumbnail url='{{ url(makepreview($post->thumb, 'b', 'posts')) }}'  data-url='{{ url(makepreview($post->thumb, 'b', 'posts')) }}'  height='650' width='370' />
                <guid isPermaLink="false">{{ url(generate_post_url($post)) }}</guid>
                <pubDate>{{ $post->published_at->toRfc2822String() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>