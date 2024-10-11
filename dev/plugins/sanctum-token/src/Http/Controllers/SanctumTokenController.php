<?php

namespace Dev\SanctumToken\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Exception;
use Dev\SanctumToken\Forms\SanctumTokenForm;
use Dev\SanctumToken\Http\Requests\StoreSanctumTokenRequest;
use Dev\SanctumToken\Models\PersonalAccessToken;
use Dev\SanctumToken\Tables\SanctumTokenTable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class SanctumTokenController extends BaseController
{
    public function index(SanctumTokenTable $sanctumTokenTable): JsonResponse|View
    {
        $this->pageTitle(__('plugins/sanctum-token::sanctum-token.name'));

        return $sanctumTokenTable->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/sanctum-token::sanctum-token.create'));

        return SanctumTokenForm::create()->renderForm();
    }

    public function store(StoreSanctumTokenRequest $request): BaseHttpResponse
    {
        $accessToken = $request->user()->createToken($request->input('name'));

        session()->flash('plainTextToken', $accessToken->plainTextToken);

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('sanctum-token.index'))
            ->setNextUrl(route('sanctum-token.index'))
            ->withCreatedSuccessMessage();
    }

    public function destroy(string $id): BaseHttpResponse
    {
        try {
            PersonalAccessToken::query()->findOrFail($id)->delete();

            return $this
                ->httpResponse()
                ->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
