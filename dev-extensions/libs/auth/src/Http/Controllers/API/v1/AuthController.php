<?php

namespace Dev\Auth\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Auth\Facades\AuthHelper;
use Dev\Auth\Http\Requests\LoginRequest;
use Dev\Auth\Http\Requests\RegisterRequest;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\AdvancedRole\Models\Member;
use Dev\Auth\Http\Resources\UserResource;

use Carbon\Carbon;
use Dev\Member\Repositories\Interfaces\MemberInterface;

use Throwable;

class AuthController extends BaseController
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

    public function register(RegisterRequest $request, BaseHttpResponse $response)
    {
        $request->merge(['password' => Hash::make($request->input('password'))]);

        $request->merge(['name' => $request->input('first_name') . ' ' . $request->input('last_name')]);

        $user = app(MemberInterface::class)->create($request->only([
            'first_name',
            'last_name',
            'name',
            'email',
            'phone',
            'password',
        ]));

        if (AuthHelper::accountVerify()) {
            $token = Hash::make(Str::random(32));
            $user->email_verify_token = $token;
            /**
             * @var Member $user
             */
            $user->sendEmailVerificationNotification();
        } else {
            $user->confirmed_at = Carbon::now();
        }

        $user->save();
        $token = $user->createToken($request->input('token_name', 'Personal Access Token'));

        Log::channel($this->logger)->info("AuthController::register captured", [
            'accessToken' => $token->plainTextToken,
            'userAbilities' => [
                [
                    'action' => 'manage',
                    'subject' => 'all'
                ]
            ],
            'userData' => new UserResource($user)
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
                'userData' => new UserResource($user)
            ])
            ->setMessage(__('Registered successfully! We emailed you to verify your account!'));
    }

    /**
     * Login
     *
     * @bodyParam login string required The email/phone of the user.
     * @bodyParam password string required The password of user to create.
     *
     * @response {
     * "error": false,
     * "data": {
     *    "token": "1|aF5s7p3xxx1lVL8hkSrPN72m4wPVpTvTs..."
     * },
     * "message": null
     * }
     *
     * @group Authentication
     */
    public function login(LoginRequest $request, BaseHttpResponse $response)
    {
        if (
            Auth::guard(AuthHelper::guard())
            ->attempt(
                [
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                ],
                true // remember
            ) // guard:member, dd(config('auth'));
        ) {
            $token = $request->user(
                AuthHelper::guard()
            )->createToken($request->input('token_name', 'Personal Access Token'));

            Log::channel($this->logger)->info("AuthController::login captured", [
                'accessToken' => $token->plainTextToken,
                'userAbilities' => [
                    [
                        'action' => 'manage',
                        'subject' => 'all'
                    ]
                ],
                'userData' => new UserResource($request->user(AuthHelper::guard()))
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
                    'userData' => new UserResource($request->user(AuthHelper::guard()))
                ]);
        }

        return $response
            ->setError()
            ->setCode(422)
            ->setMessage(__('Email or password is not correct!'));
    }

    /**
     * Logout
     *
     * @group Authentication
     * @authenticated
     */
    public function logout(Request $request, BaseHttpResponse $response)
    {
        if (!$request->user()) {
            abort(401);
        }

        $request->user()->tokens()->delete();

        return $response
            ->setMessage(__('You have been successfully logged out!'));
    }
}
