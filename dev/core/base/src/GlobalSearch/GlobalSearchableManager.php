<?php

namespace Dev\Base\GlobalSearch;

use Dev\Base\Contracts\GlobalSearchableManager as GlobalSearchableManagerContract;
use Dev\Base\Contracts\GlobalSearchableProvider as GlobalSearchableProviderContract;
use Dev\Base\GlobalSearch\Providers\DashboardMenuProvider;
use Dev\Base\GlobalSearch\Providers\PanelSectionProvider;
use Illuminate\Support\Collection;

class GlobalSearchableManager implements GlobalSearchableManagerContract
{
    public function __construct(
        protected array $providers = [
            DashboardMenuProvider::class,
            PanelSectionProvider::class,
        ],
        protected array $resolvedProviders = [],
    ) {
    }

    public function registerProvider(string $provider): static
    {
        $this->providers[] = $provider;

        return $this;
    }

    public function search(string $keyword, int $limit = 20): Collection
    {
        $result = collect();

        foreach ($this->providers as $provider) {
            $result = $result->merge(
                $this->getProvider($provider)->search($keyword)->take($limit)
            );
        }

        return $result;
    }

    protected function getProvider(string $provider): GlobalSearchableProviderContract
    {
        return $this->resolvedProviders[$provider] ??= app($provider);
    }
}
