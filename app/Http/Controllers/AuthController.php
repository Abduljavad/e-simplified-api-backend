<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    protected $expiryAddOnTime;
    public function __construct()
    {
        $this->expiryAddOnTime = env('VERIFICATION_EXPIRY_ADD_ON_TIME', 5);
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgotPassword', 'resetPassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->errorResponse('User-name or Password is incorrect');
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        
        if ($request->avatar) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }


        $user = User::create($data);
        $user->assignRole('user');

        $token = auth()->login($user);

        return $this->successResponse('User created successfully', [
            'user' => $user,
            'authorisation' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = User::with('roles:id,name')->find(auth()->user()->id);

        return $this->successResponse(
            'user successfully  retrieved',
            [
                'user' => $user->load(['emergency_contacts.relationship'])
            ]
        );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return $this->successResponse('Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return  $this->successResponse(
            'Token successfully generated',
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]
        );
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->errorResponse('Current password does not match');
        }

        $user->update(['password' => $request->new_password]);

        return $this->successResponse('Password successfully changed');
    }


    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();

        $verificationCode = rand(100000, 999999);
        echo $verificationCode;
        $user->update([
            'verification_code' => $verificationCode,
            'verification_code_expired_at' => now()->addMinutes($this->expiryAddOnTime)
        ]);

        return $this->successResponse('Verification code sent successfully');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        $verificationCodeExpiryTime = $user->verification_code_expired_at;

        if (!Hash::check($request->verification_code, $user->verification_code)) {
            return $this->errorResponse('Invalid OTP');
        }

        if (is_null($verificationCodeExpiryTime) || now()->greaterThan($verificationCodeExpiryTime)) {
            return $this->errorResponse('Verification Code  Expired');
        }

        $user->update([
            'password' => $request->password,
            'verification_code' => null
        ]);

        return $this->successResponse('Password reset successfully');
    }
}
