@php
    $name = 'slug';
    $options = [
        'prefix' => SlugHelper::getPrefix($object::class),
        'model' => $object,
    ];
@endphp

@include('libs/slug::forms.fields.permalink')
