@props([
'media' => null,
])

@if($media && $media['embed_url'])
    @php
        $styles = $media['responsive'] ? "aspect-ratio: {$media['width']} / {$media['height']}; width: 100%; height: auto;" : null;
        $params = [
            'autoplay' => in_array('autoplay', $media['options']) ? 1 : 0,
            'loop' => in_array('loop', $media['options']) ? 1 : 0,
            'title' => in_array('title', $media['options']) ? 1 : 0,
            'byline' => in_array('byline', $media['options']) ? 1 : 0,
            'portrait' => in_array('portrait', $media['options']) ? 1 : 0,
        ];
    @endphp

    <iframe
        src="{{ $media['embed_url'] }}?{{ http_build_query($params) }}"
        width="{{ $media['responsive'] ? $media['width'] : ($media['width'] ?: '640') }}"
        height="{{ $media['responsive'] ? $media['height'] : ($media['height'] ?: '480') }}"
        allow="autoplay; fullscreen; picture-in-picture"
        allowfullscreen
        style="{{ $styles }}"
    ></iframe>
@endif
