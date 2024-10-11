<?php

namespace Dev\Analytics\Facades;

use Dev\Analytics\Abstracts\AnalyticsAbstract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getCredentials()
 * @method static \Google\Analytics\Data\V1beta\BetaAnalyticsDataClient getClient()
 * @method static \Dev\Analytics\AnalyticsResponse get()
 * @method static \Illuminate\Support\Collection fetchMostVisitedPages(\Dev\Analytics\Period $period, int $maxResults = 20)
 * @method static \Illuminate\Support\Collection fetchTopReferrers(\Dev\Analytics\Period $period, int $maxResults = 20)
 * @method static \Illuminate\Support\Collection fetchTopBrowsers(\Dev\Analytics\Period $period, int $maxResults = 10)
 * @method static \Illuminate\Support\Collection performQuery(\Dev\Analytics\Period $period, array|string $metrics, array|string $dimensions = [])
 * @method static string getPropertyId()
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static \Dev\Analytics\Analytics dateRange(\Dev\Analytics\Period $period)
 * @method static \Dev\Analytics\Analytics dateRanges(\Dev\Analytics\Period ...$items)
 * @method static \Dev\Analytics\Analytics metric(string $name)
 * @method static \Dev\Analytics\Analytics metrics(array|string $items)
 * @method static \Dev\Analytics\Analytics dimension(string $name)
 * @method static \Dev\Analytics\Analytics dimensions(array|string $items)
 * @method static \Dev\Analytics\Analytics orderByMetric(string $name, string $order = 'ASC')
 * @method static \Dev\Analytics\Analytics orderByMetricDesc(string $name)
 * @method static \Dev\Analytics\Analytics orderByDimension(string $name, string $order = 'ASC')
 * @method static \Dev\Analytics\Analytics orderByDimensionDesc(string $name)
 * @method static \Dev\Analytics\Analytics metricAggregation(int $value)
 * @method static \Dev\Analytics\Analytics metricAggregations(int ...$items)
 * @method static \Dev\Analytics\Analytics whereDimension(string $name, int $matchType, $value, bool $caseSensitive = false)
 * @method static \Dev\Analytics\Analytics whereDimensionIn(string $name, array $values, bool $caseSensitive = false)
 * @method static \Dev\Analytics\Analytics whereMetric(string $name, int $operation, $value)
 * @method static \Dev\Analytics\Analytics whereMetricBetween(string $name, $from, $to)
 * @method static \Dev\Analytics\Analytics keepEmptyRows(bool $keepEmptyRows = false)
 * @method static \Dev\Analytics\Analytics limit(int|null $limit = null)
 * @method static \Dev\Analytics\Analytics offset(int|null $offset = null)
 *
 * @see \Dev\Analytics\Analytics
 */
class Analytics extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AnalyticsAbstract::class;
    }
}
