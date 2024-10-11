<?php

namespace Dev\Api\Http\Controllers;

use Dev\Api\Forms\SanctumTokenForm;
use Dev\Api\Http\Requests\StoreSanctumTokenRequest;
use Dev\Api\Models\PersonalAccessToken;
use Dev\Api\Tables\SanctumTokenTable;
use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class SanctumTokenController extends BaseController
{
    public function __construct()
    {
        $this->breadcrumb()
            ->add(trans('core/setting::setting.title'), route('settings.index'))
            ->add(trans('libs/api::api.settings'), route('api.settings'));
    }

    public function index(SanctumTokenTable $sanctumTokenTable): JsonResponse|View
    {
        $this->pageTitle(trans('libs/api::sanctum-token.name'));

        return $sanctumTokenTable->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('libs/api::sanctum-token.create'));

        return SanctumTokenForm::create()->renderForm();
    }

    public function store(StoreSanctumTokenRequest $request): BaseHttpResponse
    {
        $accessToken = $request->user()->createToken($request->input('name'));

        session()->flash('plainTextToken', $accessToken->plainTextToken);

        return $this
            ->httpResponse()
            ->setNextUrl(route('api.settings'))
            ->withCreatedSuccessMessage();
    }

    public function destroy(PersonalAccessToken $sanctumToken): DeleteResourceAction
    {
        return DeleteResourceAction::make($sanctumToken);
    }
}
