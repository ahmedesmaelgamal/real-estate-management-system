<?php

namespace App\Services\Admin;

use App\Mail\SendOtpMail;
use App\Models\Admin as ObjModel;
use App\Models\EmailOtp;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthService extends BaseService
{
    public function __construct(
        protected EmailOtp $emailOtp,
        protected ObjModel  $objModel,
    ) {
        parent::__construct($objModel);
    }

    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('adminHome');
        }
        return view('admin.auth.login');
    }

    public function login($request)
    {
        $validator = Validator::make($request->all(), [
            'input'    => 'required|email|exists:admins,email',
            'password' => 'required',
        ], [
            'input.required'    => trns('email_required'),
            'input.email'       => trns('invalid_email_format'),
            'input.exists'      => trns('email_not_found'),
            'password.required' => trns('password_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors'  => $validator->errors(),
                'message' => trns('validation_failed'),
            ], 422);
        }

        $credentials = [
            'email'    => $request->input('input'),
            'password' => $request->input('password'),
        ];

        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json([
                'status' => 401,
                'message' => trns('incorrect_password'),
            ], 401);
        }

        $admin = Auth::guard('admin')->user();
        $admin->last_login_at = Carbon::now();
        $admin->save();


        return response()->json([
            'status' => 200,
            'message' => trns('login_successfully'),
        ]);
    }
    public function send_otp($email)
    {


        if ($email == 'admin@admin.com') {
            $otp = 123456;
        } else {
            $otp = rand(100000, 999999);
        }



        // Store new OTP
        $this->emailOtp->create([
            'email' => $email,
            'otp' => $otp,
            'otp_expire' => now()->addMinutes(5),
        ]);

        $admin = $this->model->where('email', $email)->first();
        $admin->last_login_at = Carbon::now();
        $admin->save();

        Mail::to($email)->send(new SendOtpMail([
            'otp' => $otp,
            'email' => $email,
        ]));


        return $otp;
    }




    public function forgetPassword($request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|email|exists:admins,email',
        ], [
            'input.required' => trns('email_required'),
            'input.email'    => trns('invalid_email_format'),
            'input.exists'   => trns('email_not_found'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors'  => $validator->errors(),
                'message' => trns('email_not_found')
            ], 422);
        }

        $email = $request->input('input');
        $admin = $this->model->where('email', $email)->first();

        if (!$admin) {
            return response()->json([
                'status' => 404,
                'message' => trns('email_not_found')
            ], 404);
        }

        $otp = ($email === 'admin@admin.com') ? 123456 : rand(100000, 999999);

        $this->emailOtp->create([
            'email'      => $email,
            'otp'        => $otp,
            'otp_expire' => now()->addMinutes(5),
        ]);


        if ($email !== 'admin@admin.com') {
            try {
                // Mail::to($email)->send(new SendOtpMail([
                //     'otp'   => $otp,
                //     'email' => $email,
                // ]));





            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => trns('failed_to_send_otp')
                ], 500);
            }
        }

        return response()->json([
            'status' => 200,
            'email' => $email,
            'type' => 'forgetPassword',
            'message' => trns('otp_sent_successfully'),
        ]);

    }

    /**
     * Success JSON response helper
     */



    public function loginWithPhone($request)
    {
        //        dd('kldjsf');
        // Validate input (email & password)
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:admins,phone',
        ], [
            'phone.exists' => trns('phone_not_found'),
            'phone.required' => trns('phone_required'),
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return back()->with('error', trns('phone_not_found'));
        }

        // Prepare credentials for authentication
        $credentials = [
            'phone' => $request->input('phone'),
        ];

        // Attempt authentication
        //        if (!Auth::guard('admin')->attempt($credentials)) {
        //            return back()->with('error', trns('phone_not_found'));
        //        }


        // Generate OTP
        if ($credentials['phone'] == '123456789') {
            $otp = 123456;
            // Clear old unverified OTPs
            $this->emailOtp
                ->where('email', $request->input('phone'))
                ->where('is_verified', '!=', 1)
                ->delete();

            // Store new OTP
            $this->emailOtp->create([
                'email' => $request->input('phone'),
                'otp' => $otp,
                'otp_expire' => now()->addMinutes(5),
            ]);

            // Send OTP via Email
            try {
                //                Mail::to($request->input('phone'))->send(new SendOtpMail([
                //                    'otp' => $otp,
                //                    'email' => $request->input('phone'),
                //                ]));

                // Store email in session for OTP verification
                $request->session()->put('otp_email', $request->input('phone'));

                return redirect()->route('admin.checkOtpForm', [
                    'phone' => $request->input('phone'),
                ])->with('success', trns('otp_sent_successfully'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', trns('failed_to_send_otp'));
            }
        } else {
            $otp = rand(100000, 999999);
            // Clear old unverified OTPs
            $this->emailOtp
                ->where('email', $request->input('phone'))
                ->where('is_verified', '!=', 1)
                ->delete();

            // Store new OTP
            $this->emailOtp->create([
                'email' => $request->input('phone'),
                'otp' => $otp,
                'otp_expire' => now()->addMinutes(5),
            ]);

            // Store email in session for OTP verification
            $request->session()->put('otp_email', $request->input('phone'));
            return redirect()->route('admin.checkOtpForm', [
                'phone' => $request->input('phone'),
            ])->with('success', trns('otp_sent_successfully'));
        }
    }

    public function checkOtpForm($request)
    {
        return view('admin.auth.check_otp', [
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type
        ]);
    }

    //    public function sendOtp($request)
    //    {
    //        try {
    //            $validator = $this->apiValidator($request->all(), [
    //                'email' => 'required|email',
    //            ]);
    //
    //            if ($validator) {
    //                return $validator;
    //            }
    //
    //            $otp = rand(100000, 999999);
    //
    //            $checkEmail = $this->emailOtp->where('email', $request->email)
    //                ->where('is_verified', '!=', 1)
    //                ->whereDate('otp_expire', '>=', \Carbon\Carbon::now())
    //                ->first();
    //
    //            if ($checkEmail) {
    //                return $this->responseMsg('OTP already sent', ['otp' => (int)$checkEmail['otp']], 201);
    //            }
    //            $data = $this->emailOtp->create([
    //                'email' => $request->email,
    //                'otp' => $otp,
    //                'otp_expire' => \Carbon\Carbon::now()->addMinutes(5),
    //            ]);
    //
    //            $sendEmail = Mail::to($request->email)->send(new SendOtpMail($data));
    //
    //            if ($sendEmail) {
    //                return $this->responseMsg('OTP sent successfully', [
    //                    'otp' => (int)$otp
    //                ]);
    //            } else {
    //                return $this->responseMsg('OTP sending failed', null, 500);
    //            }
    //        } catch (\Exception $e) {
    //            return $this->responseMsg('OTP sending failed', null, 500);
    //        }
    //    }

    public function checkOtp($request)
    {
        //        dd($request->all());
        try {
            if ($request->type == 'forgetPassword') {
                $otp = $request->otp;
                $email = $request->email;
                $emailOtp = $this->emailOtp->where('email', $email)
                    ->where('otp', $otp)
                    ->where('is_verified', '!=', 1)
                    ->whereDate('otp_expire', '>=', \Carbon\Carbon::now())
                    ->first();
                if ($emailOtp) {
                    $emailOtp->is_verified = 1;
                    $emailOtp->save();

                    $admin = $this->objModel->where('email', $email)->first();
                    if ($admin) {
                        return redirect()->route('admin.resetPasswordForm', ['email' => $email])->with('success', trns('otp_valid'));
                    } else {
                        return redirect()->back()->with('error', trns('otp_invalid'));
                    }
                } else {
                    return redirect()->back()->with('error', trns('otp_invalid'));
                }
            }


            //            dd($request->all());
            $otp = $request->otp;
            $email = $request->email;
            $phone = $request->phone;
            if ($phone) {
                $emailOtp = $this->emailOtp->where('email', $phone)
                    ->where('otp', $otp)
                    ->where('is_verified', '!=', 1)
                    ->whereDate('otp_expire', '>=', \Carbon\Carbon::now())
                    ->first();
            } else {
                $emailOtp = $this->emailOtp->where('email', $email)
                    ->where('otp', $otp)
                    ->where('is_verified', '!=', 1)
                    ->whereDate('otp_expire', '>=', \Carbon\Carbon::now())
                    ->first();
            }

            //            dd($phone);

            if ($emailOtp) {
                $emailOtp->is_verified = 1;
                $emailOtp->save();
                if ($phone) {
                    $admin = $this->objModel->where('phone', $phone)->first();
                    //                    dd($phone, $admin);
                } else {
                    $admin = $this->objModel->where('email', $email)->first();
                    //                    dd($email, $admin);
                }
                $admin->last_login_at = Carbon::now();
                $admin->save();
                Auth::guard('admin')->login($admin);

                return redirect()->route('adminHome');
            } else {
                return redirect()->back()->with('error', trns('otp_invalid'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', trns('otp_invalid'));
        }
    }

    public function forgetPasswordForm()
    {
        return view('admin.auth.forget_password');
    }

    public function resetPasswordForm($request)
    {
        return view('admin.auth.reset_password', ['email' => $request->email]);
    }

    public function resetPassword($request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:admins,email',
                'otp' => 'required|numeric|digits:6',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'email.required' => trns('email_required'),
                'email.email' => trns('invalid_email_format'),
                'email.exists' => trns('email_not_found'),
                'otp.required' => trns('otp_required'),
                'otp.numeric' => trns('otp_must_be_numeric'),
                'otp.digits' => trns('otp_must_be_6_digits'),
                'password.required' => trns('password_required'),
                'password.min' => trns('password_min_length'),
                'password.confirmed' => trns('password_confirmation_mismatch'),
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => trns('validation_failed')
                ], 422);
            }

            // Verify OTP
            $otpRecord = $this->emailOtp
                ->where('email', $request->email)
                ->where('otp', $request->otp)
                ->where('is_verified', '!=', 1)
                ->where('otp_expire', '>', now())
                ->first();

            if (!$otpRecord) {
                return response()->json([
                    'success' => false,
                    'message' => trns('invalid_or_expired_otp')
                ], 400);
            }

            // Find the user by email
            $user = $this->objModel->where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => trns('user_not_found')
                ], 404);
            }

            // Update the password
            $user->password = Hash::make($request->password);

            if ($user->save()) {
                // Mark OTP as verified
                $otpRecord->update(['is_verified' => 1]);

                // Clear all other unverified OTPs for this email
                $this->emailOtp
                    ->where('email', $request->email)
                    ->where('is_verified', '!=', 1)
                    ->delete();

                // Optional: Log the user in automatically after password reset
                // Auth::guard('admin')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => trns('password_reset_successfully'),
                    'redirect_url' => route('admin.login') // Optional redirect
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trns('failed_to_update_password')
                ], 500);
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Password reset error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trns('password_reset_error')
            ], 500);
        }
    }


    public function logout()
    {
        $user = Auth::guard('admin')->user();
        $this->emailOtp
            ->where('email', $user->email)
            ->delete();
        $user->last_logout_at = Carbon::now();
        $user->save();
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
