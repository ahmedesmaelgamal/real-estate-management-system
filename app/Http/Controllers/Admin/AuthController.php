<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\AuthInterface;
use App\Services\Admin\AuthService as ObjService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function __construct(protected ObjService $objService)
    {

    }

    public function index()
    {
        return $this->objService->index();
    }

    public function login(Request $request)
    {
        return $this->objService->login($request);
    }

    public function loginWithPhone(Request $request)
    {
        return $this->objService->loginWithPhone($request);

    }

    public function logout()
    {
        return $this->objService->logout();
    }
//    public function sendOtp(Request $request)
//    {
//        return $this->objService->sendOtp($request);
//    }
    public function checkOtp(Request $request)
    {
        return $this->objService->checkOtp($request);
    }

    public function checkOtpForm(Request $request)
    {
        return $this->objService->checkOtpForm($request);
    }

    public function resetPasswordForm(Request $request)
    {
        return $this->objService->resetPasswordForm($request);

    }
    public function resetPassword(Request $request)
    {
        return $this->objService->resetPassword($request);
    }

    public function forgetPassword(Request $request)
    {
        return $this->objService->forgetPassword($request);
    }
    public function forgetPasswordForm()
    {
        return $this->objService->forgetPasswordForm();
    }

//    public function updateProfile(Request $request)
//    {
//        return $this->objService->updateProfile($request);
//    }
//    public function profile()
//    {
//        return $this->objService->profile();
//    }
}//end class
