<?php

namespace Dev\Auth\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use Dev\Auth\Http\Requests\UpdatePasswordRequest;
use Dev\Auth\Http\Requests\UpdateProfileRequest;
use Dev\Auth\Facades\AuthHelper;
use Dev\Auth\Http\Resources\UserResource;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Media\Facades\AppMedia;
use Dev\Base\Http\Controllers\BaseController;

use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Exception;


class ProfileController extends BaseController
{
    private $logger = 'advanced-role';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        try {
            $this->logger = apps_logger($this->logger);
        } catch (Throwable $th) {
            Log::channel($this->logger)->error($th->getMessage());
            Log::channel($this->logger)->error($th->getTraceAsString());
        }
    }

    /**
     * Get the user profile information.
     *
     * @group Profile
     * @authenticated
     */
    public function getProfile(Request $request, BaseHttpResponse $response)
    {
        $token = $request->user()->createToken($request->input('token_name', 'Personal Access Token'));

        Log::channel($this->logger)->info("getProfile captured", [
            'accessToken' => $token->plainTextToken,
            'userAbilities' => [
                [
                    'action' => 'manage',
                    'subject' => 'all'
                ]
            ],
            'userData' => new UserResource($request->user())
        ]);

        return $response
            ->setData([
                'accessToken' => $token->plainTextToken,
                'userAbilities' => [
                    [
                        'action' => 'manage',
                        'subject' => 'all'
                    ]
                ],
                'userData' => new UserResource($request->user())
            ])
            ->setCode(Response::HTTP_OK);
    }

    /**
     * Update Avatar
     *
     * @bodyParam avatar file required Avatar file.
     *
     * @group Profile
     * @authenticated
     */
    public function updateAvatar(Request $request, BaseHttpResponse $response)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => AppMedia::imageValidationRule(),
        ]);

        if ($validator->fails()) {
            return $response
                ->setError()
                ->setCode(422)
                ->setMessage(__('An error has occurred.') . ' ' . implode(' ', $validator->errors()->all()) . '.');
        }

        try {
            $result = AppMedia::handleUpload($request->file('avatar'), 0, 'users');
            if (Arr::get($result, 'error') !== true) {
                $request->user()->update(['avatar_id' => $result['data']->id]);
            } else {
                Log::channel('daily')->error($result);
                return $response
                    ->setError()
                    ->setCode(422)
                    ->setMessage($result['message']);
            }

            return $response
                ->setData(new UserResource($request->user()))
                ->setMessage(__('Update avatar successfully!'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * Update profile
     *
     * @bodyParam first_name string required First name.
     * @bodyParam last_name string required Last name.
     * @bodyParam email string Email.
     * @bodyParam dob string required Date of birth.
     * @bodyParam gender string Gender
     * @bodyParam description string Description
     * @bodyParam phone string required Phone.
     *
     * @group Profile
     * @authenticated
     */
    public function updateProfile(UpdateProfileRequest $request, BaseHttpResponse $response)
    {
        try {
            $request->user()->update($request->validated());

            return $response
                ->setData(new UserResource($request->user()))
                ->setMessage(__('Update profile successfully!'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * Update password
     *
     * @bodyParam password string required The new password of user.
     *
     * @group Profile
     * @authenticated
     */
    public function updatePassword(UpdatePasswordRequest $request, BaseHttpResponse $response)
    {
        $request->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return $response
            ->setMessage(trans('core/acl::users.password_update_success'))
            ->setCode(Response::HTTP_OK);
    }

    /**
     * Delete account
     *
     * @group Profile
     * @authenticated
     */
    public function deleteAccount(Request $request, BaseHttpResponse $response)
    {
        if (!$request->user()) {
            abort(401);
        }

        $request->user()->tokens()->delete();
        $request->user()->delete();

        return $response
            ->setMessage(__('You are successfully deleted account!'));
    }
}
