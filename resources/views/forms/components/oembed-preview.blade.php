@php
    $state = $getState();

    $params = [
        'autoplay' => in_array('autoplay', $state['options']) ? 1 : 0,
        'loop' => in_array('loop', $state['options']) ? 1 : 0,
        'title' => in_array('title', $state['options']) ? 1 : 0,
        'byline' => in_array('byline', $state['options']) ? 1 : 0,
        'portrait' => in_array('portrait', $state['options']) ? 1 : 0,
    ];
@endphp

<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div class="border border-gray-300 dark:border-gray-700 rounded-xl overflow-hidden aspect-video w-full h-auto bg-gray-300/30 dark:bg-gray-800/20">
        @if($state && $state['embed_url'])
            <iframe
                src="{{ $state['embed_url'] }}?{{ http_build_query($params) }}"
                width="640"
                height="360"
                allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen
                class="w-full h-full"
            ></iframe>
        @endif
    </div>
</x-forms::field-wrapper>
