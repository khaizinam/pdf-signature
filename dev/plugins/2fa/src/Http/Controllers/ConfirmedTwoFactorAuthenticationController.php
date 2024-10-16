<?php

namespace ArchiElite\TwoFactorAuthentication\Http\Controllers;

use ArchiElite\TwoFactorAuthentication\Actions\ConfirmTwoFactorAuthentication;
use ArchiElite\TwoFactorAuthentication\Http\Requests\ConfirmTwoFactorCodeRequest;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;

class ConfirmedTwoFactorAuthenticationController extends BaseController
{
    public function store(
        ConfirmTwoFactorCodeRequest $request,
        ConfirmTwoFactorAuthentication $confirm,
    ): BaseHttpResponse {
        $confirm($request->user(), $request->input('code'), $request->input('secret'));

        return $this->httpResponse();
    }
}
