<?php

namespace Dev\Auth\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use Dev\Base\Http\Controllers\BaseController;
use App\Models\User;
use Dev\Auth\Facades\AuthHelper;
use Dev\Auth\Http\Requests\ResendEmailVerificationRequest;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Member\Repositories\Interfaces\MemberInterface;

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
     * Resend email verification
     *
     * Resend the email verification notification.
     *
     * @bodyParam email string required The email of the user.
     *
     * @group Authentication
     */
    public function resend(ResendEmailVerificationRequest $request, BaseHttpResponse $response)
    {
        $user = app(MemberInterface::class)->where(['email' => $request->input('email')])->first();

        if (! $user) {
            return $response
                ->setError()
                ->setMessage(__('User not found!'))
                ->setCode(404);
        }

        /**
         * @var User $user
         */
        if ($user->hasVerifiedEmail()) {
            return $response
                ->setError()
                ->setMessage(__('This user has verified email'));
        }

        $token = Hash::make(Str::random(32));

        $user->email_verify_token = $token;
        $user->save();

        $user->sendEmailVerificationNotification();

        return $response
            ->setMessage(__('Resend email verification successfully!'));
    }
}
