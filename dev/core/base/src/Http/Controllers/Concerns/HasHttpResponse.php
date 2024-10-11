<?php

namespace Dev\Base\Http\Controllers\Concerns;

use Dev\Base\Http\Responses\BaseHttpResponse;

trait HasHttpResponse
{
    public function httpResponse(): BaseHttpResponse
    {
        return BaseHttpResponse::make();
    }
}
