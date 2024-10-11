<?php

namespace Dev\Kernel\Providers;

use Illuminate\Support\Str;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use Javoscript\MacroableModels\Facades\MacroableModels;

use Dev\AdvancedRole\Models\Team;
use Dev\Kernel\Models\Transaction;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        #region Macro 1 show FULL sql
        /**
         * Macro 1 show FULL sql
         * 
         * usage: 
         * DB::table('table-name')->toBoundSql();
         * // result: ['name' => 'Chris']
         * 
         */
        Builder::macro('toBoundSql', function () {
            /* @var Builder $this */
            $bindings = array_map(
                fn($parameter) => is_string($parameter) ? "'$parameter'" : $parameter,
                $this->getBindings()
            );

            return Str::replaceArray(
                '?',
                $bindings,
                $this->toSql()
            );
        });
        EloquentBuilder::macro('toBoundSql', function () {
            return $this->toBase()->toBoundSql();
        });
        #endregion Macro 1 show FULL sql

        #region Macro 2 for case insensitive 'where' filter
        /**
         * Macro 2 for case insensitive 'where' filter
         * 
         * $collection = collect([
         *   [
         *      'name' => 'Chris'
         *   ],
         *   [
         *      'name' => 'Monica'
         *   ]
         * ]);
         * 
         * $collection->where('name', 'chris');
         * // result: null
         * 
         * If you want a case insensitive 'where' filter, 
         * add this to your AppServiceProvider's boot method
         *
         * usage: 
         * $collection->whereCaseInsensitive('name', 'chris');
         * // result: ['name' => 'Chris']
         *
         */

        Collection::macro('whereCaseInsensitive', function (string $field, string $search) {
            return $this->filter(function ($item) use ($field, $search) {
                return strtolower($item[$field]) == strtolower($search);
            });
        });
        #endregion Macro 2 for case insensitive 'where' filter

        #region Macro for "member" model
        // MacroableModels::addMacro(Member::class, 'balance', function () {
        //     $transaction = DB::table('transactions')
        //         ->select(DB::raw('(COALESCE(SUM(transactions.credit),0) - COALESCE(SUM(transactions.debit),0)) as balance'))
        //         ->where('user_id', $this->id)
        //         ->first();

        //     return $transaction->balance ?? 0;
        // });

        // MacroableModels::addMacro(Member::class, 'transactions', function (): HasMany {
        //     return $this->hasMany(Transaction::class);
        // });

        // MacroableModels::addMacro(Member::class, 'teams', function (): BelongsToMany {
        //     return $this->belongsToMany(Team::class, 'app__team_members', 'member_id', 'team_id')
        //         ->withPivot(['status']);
        // });
        #endregion Macro for "member" model
    }
}
