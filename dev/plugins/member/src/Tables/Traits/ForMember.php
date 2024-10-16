<?php

namespace Dev\Member\Tables\Traits;

trait ForMember
{
    public function booted(): void
    {
        $this
            ->setView('plugins/member::table.base')
            ->bulkChangeUrl(route('public.member.table.bulk-change.save'))
            ->bulkChangeDataUrl(route('public.member.table.bulk-change.data'))
            ->bulkActionDispatchUrl(route('public.member.table.bulk-action.dispatch'))
            ->filterInputUrl(route('public.member.table.filter.input'));
    }
}
