<div class="ticksify-stats">
    <div class="ticksify-stat-item">
        <div class="row">
            <div class="col-7">
                <span class="ticksify-stat-title">{{ $title }}</span>
                <h3 class="ticksify-stat-count">{{ number_format($count) }}</h3>
            </div>
            <div class="col-5">
                <div class="ticksify-stat-icon">
                    <x-core::icon :name="$icon" class="text-{{ $color }}" />
                </div>
            </div>
        </div>
    </div>
</div>
