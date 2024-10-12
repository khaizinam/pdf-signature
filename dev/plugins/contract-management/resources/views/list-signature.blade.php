<div class="form-group {{ $options['wrapper']['class'] }}">
    <label for="" class="mb-3">{{$options['label']}}</label>
    <div class="multi-choices-widget list-item-checkbox">
        @if(isset($options['values']) && (is_array($options['values']) || $options['values'] instanceof \Illuminate\Support\Collection))
            @include('plugins/contract-management::signature-item', [
                'values' => $options['values'],
            ])
        @endif
    </div>
</div>
