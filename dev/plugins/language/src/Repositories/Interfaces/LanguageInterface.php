<?php

namespace Dev\Language\Repositories\Interfaces;

use Dev\Base\Models\BaseModel;
use Dev\Language\Models\Language;
use Dev\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface LanguageInterface extends RepositoryInterface
{
    public function getActiveLanguage(array $select = ['*']): Collection;

    public function getDefaultLanguage(array $select = ['*']): BaseModel|Model|Language|null;
}
