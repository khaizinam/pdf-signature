<?php

namespace Dev\Slug\Facades;

use Dev\Slug\SlugHelper as BaseSlugHelper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dev\Slug\SlugHelper registerModule(array|string $model, string|null $name = null)
 * @method static \Dev\Slug\SlugHelper removeModule(array|string $model)
 * @method static array supportedModels()
 * @method static \Dev\Slug\SlugHelper setPrefix(string $model, string|null $prefix, bool $canEmptyPrefix = false)
 * @method static \Dev\Slug\SlugHelper setColumnUsedForSlugGenerator(string $model, string $column)
 * @method static bool isSupportedModel(string $model)
 * @method static \Dev\Slug\SlugHelper disablePreview(array|string $model)
 * @method static bool canPreview(string $model)
 * @method static \Dev\Base\Contracts\BaseModel|\Dev\Slug\Models\Slug createSlug(\Dev\Base\Contracts\BaseModel $model, string|null $name = null)
 * @method static mixed getSlug(string|null $key, string|null $prefix = null, string|null $model = null, $referenceId = null)
 * @method static string|null getPrefix(string $model, string $default = '', bool $translate = true)
 * @method static string getHelperTextForPrefix(string $model, string $default = '/', bool $translate = true)
 * @method static string getHelperText(string $prefix, string|null $postfix = '', string|null $separation = '')
 * @method static string|null getColumnNameToGenerateSlug(object|array|string|null $model)
 * @method static string getPermalinkSettingKey(string $model)
 * @method static bool turnOffAutomaticUrlTranslationIntoLatin()
 * @method static string|null getPublicSingleEndingURL()
 * @method static string getSettingKey(string $key)
 * @method static array getCanEmptyPrefixes()
 * @method static \Dev\Slug\SlugCompiler getTranslator()
 * @method static array getSlugPrefixes()
 * @method static array getAllPrefixes()
 *
 * @see \Dev\Slug\SlugHelper
 */
class SlugHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseSlugHelper::class;
    }
}
