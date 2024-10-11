<?php

namespace Dev\Base\Models;

use Dev\Base\Contracts\BaseModel as BaseModelContract;
use Dev\Base\Facades\MacroableModels;
use Dev\Base\Models\Concerns\HasBaseEloquentBuilder;
use Dev\Base\Models\Concerns\HasMetadata;
use Dev\Base\Models\Concerns\HasUuidsOrIntegerIds;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method static \Dev\Base\Models\BaseQueryBuilder query()
 */
class BaseModel extends Model implements BaseModelContract
{
    use HasBaseEloquentBuilder;
    use HasMetadata;
    use HasUuidsOrIntegerIds;

    public function __get($key)
    {
        if (MacroableModels::modelHasMacro($this::class, $method = 'get' . Str::studly($key) . 'Attribute')) {
            return call_user_func([$this, $method]);
        }

        return parent::__get($key);
    }
}
