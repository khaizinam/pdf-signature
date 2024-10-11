<?php

namespace Dev\Api\Supports;

use App\Models\User;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class ApiHelper
{
    public function modelName(): string
    {
        return (string)$this->getConfig('model', User::class);
    }

    public function setModelName(string $modelName): self
    {
        config(['libs.api.api.provider.model' => $modelName]);

        return $this;
    }

    public function guard(): string|null
    {
        return $this->getConfig('guard');
    }

    public function passwordBroker(): string|null
    {
        return $this->getConfig('password_broker');
    }

    public function getConfig(string $key, $default = null): string|null
    {
        return config('libs.api.api.provider.' . $key, $default);
    }

    public function setConfig(array $config)
    {
        return config(['libs.api.api.provider' => $config]);
    }

    public function newModel(): ?Model
    {
        $model = $this->modelName();

        if (! $model || ! class_exists($model)) {
            return new BaseModel();
        }

        return new $model();
    }

    public function getTable(): string
    {
        return $this->newModel()->getTable();
    }

    public function enabled(): bool
    {
        return setting('api_enabled', 0) == 1;
    }
}
