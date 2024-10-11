<div class="ticksify-wrapper">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 mb-3 g-3">
        @include('plugins/ticksify::themes.partials.stat', [
            'title' => __('Total Tickets'),
            'count' => $stats->total,
            'icon' => 'ti ti-ticket',
            'color' => 'primary',
        ])

        @include('plugins/ticksify::themes.partials.stat', [
            'title' => __('Closed Tickets'),
            'count' => $stats->closed,
            'icon' => 'ti ti-x',
            'color' => 'danger',
        ])

        @include('plugins/ticksify::themes.partials.stat', [
            'title' => __('Active Tickets'),
            'count' => $stats->open,
            'icon' => 'ti ti-check',
            'color' => 'success',
        ])

        @include('plugins/ticksify::themes.partials.stat', [
            'title' => __('On Hold Tickets'),
            'count' => $stats->on_hold,
            'icon' => 'ti ti-hand-grab',
            'color' => 'warning',
        ])
    </div>

    <div class="ticksify-card">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
            <div>
                <h4 class="ticksify-card-title mb-0">
                    {{ __('Your Tickets') }}
                </h4>
                <p class="ticksify-card-subtitle mb-0">
                    {{ __('Here you can view all your tickets and their status.') }}
                </p>
            </div>
            <a href="{{ route('ticksify.public.tickets.create') }}" class="btn btn-primary">
                {{ __('Create Ticket') }}
            </a>
        </div>

        @if ($tickets->isNotEmpty())
            <div class="ticksify-tickets">
                @foreach ($tickets as $ticket)
                    <div class="ticksify-ticket">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <h5 class="ticksify-ticket-title">
                                <a href="{{ route('ticksify.public.tickets.show', $ticket) }}">
                                    {{ $ticket->title }}
                                </a>
                            </h5>
                            <div class="d-flex align-items-center gap-1">
                                @if($ticket->is_resolved)
                                    <span class="badge bg-success">
                                    <x-core::icon name="ti ti-check" />
                                    {{ __('Resolved') }}
                                </span>
                                @endif
                                @if($ticket->is_locked)
                                    <span class="badge bg-secondary">
                                    <x-core::icon name="ti ti-lock" />
                                    {{ __('Locked') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="ticksify-ticket-details">
                        <span class="ticksify-ticket-detail ticket-id">
                            <strong>{{ __('Ticket ID') }}:</strong> #{{ $ticket->id }}
                        </span>
                            <span class="ticksify-ticket-detail">
                            <strong>{{ __('Priority') }}:</strong> {!! $ticket->priority->toHtml() !!}
                        </span>
                            <span class="ticksify-ticket-detail">
                            <strong>{{ __('Status') }}:</strong> {!! $ticket->status->toHtml() !!}
                        </span>
                            <span class="ticksify-ticket-detail">
                            <strong>{{ __('Category') }}:</strong> {{ $ticket->category->name }}
                        </span>
                            <span class="ticksify-ticket-detail">
                            <strong>{{ __('Created') }}:</strong> {{ $ticket->created_at->diffForHumans() }}
                        </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @include('plugins/ticksify::themes.partials.pagination', ['paginator' => $tickets])
    </div>
</div>
