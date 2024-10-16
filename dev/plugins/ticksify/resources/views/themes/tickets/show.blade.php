<div class="ticksify-wrapper">
    <div class="row">
        <div class="col-md-9">
            @if($ticket->is_resolved)
                <div class="alert alert-success">
                    <div class="d-flex align-items-center gap-1">
                        <x-core::icon name="ti ti-check" />
                        {{ __('This ticket has been resolved.') }}
                    </div>
                </div>
            @endif

            <div class="ticksify-card ticksify-ticket">
                <h3 class="ticksify-ticket-title">{{ $ticket->title }}</h3>
                <div class="ticksify-ticket-content">
                    {!! BaseHelper::clean($ticket->content) !!}
                </div>
            </div>

            @if(auth()->user()->hasPermission('ticksify.tickets.messages.store'))
                <div class="ticksify-card">
                    <h5 class="ticksify-card-title">{{ __('Reply to Ticket') }}</h5>
                    @if(! $ticket->is_locked)
                        {!! $form->renderForm() !!}
                    @else
                        <div class="ticksify-card-body">
                            <div class="alert alert-secondary mb-0">
                                <div class="d-flex align-items-center gap-1">
                                    <x-core::icon name="ti ti-lock" />
                                    {{ __('This ticket is locked and you cannot reply to it.') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if ($messages->isNotEmpty())
                <div class="ticksify-card p-0" id="messages">
                    <h5 class="ticksify-card-title p-3 pb-0">{{ __('Replies') }}</h5>
                    <div class="ticksify-messages">
                        @foreach ($messages as $message)
                            <div class="ticksify-message">
                                <div class="ticksify-message-content">
                                    {{ AppMedia::image($message->sender->avatar_url, $message->sender->name, attributes: ['class' => 'ticksify-message-avatar']) }}
                                    <div class="ticksify-message-details">
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            <h6 class="ticksify-message-name">{{ $message->sender->name }}</h6>
                                            @if($message->is_staff)
                                                <span class="badge bg-primary">{{ __('Staff') }}</span>
                                            @endif
                                        </div>
                                        <small
                                            class="ticksify-message-time"
                                            title="{{ $message->created_at->translatedFormat('d M Y H:i') }}"
                                        >
                                            <x-core::icon name="ti ti-clock" />
                                            {{ $message->created_at->diffForHumans() }}
                                        </small>
                                        <div class="ticksify-message-body mt-2">
                                            {!! BaseHelper::clean($message->content) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @include('plugins/ticksify::themes.partials.pagination', ['paginator' => $messages])
            @endif
        </div>

        <div class="col-md-3 mb-3">
            <div class="ticksify-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="ticksify-card-title mb-0">{{ __('Ticket Details') }}</h5>
                    {!! $ticket->status->toHtml() !!}
                </div>

                <dl class="mb-0">
                    <dt>{{ __('Ticket ID') }}</dt>
                    <dd>#{{ $ticket->getKey() }}</dd>
                    <dt>{{ __('Created At') }}</dt>
                    <dd title="{{ $ticket->created_at->translatedFormat('d M Y H:i') }}">
                        {{ $ticket->created_at->diffForHumans() }}
                    </dd>
                    <dt>{{ __('Priority') }}</dt>
                    <dd>{!! $ticket->priority->toHtml() !!}</dd>
                    <dt>{{ __('Category') }}</dt>
                    <dd>{{ $ticket->category->name }}</dd>
                </dl>
            </div>

            <div class="mt-3 d-grid">
                <a href="{{ route('ticksify.public.tickets.create') }}" class="btn btn-primary">
                    {{ __('Open a New Ticket') }}
                </a>
            </div>
        </div>
    </div>
</div>
