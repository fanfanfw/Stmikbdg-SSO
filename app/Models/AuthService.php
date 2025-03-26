<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\MyWebService;

class AuthService extends MyWebService
{
    use HasFactory;

    public function __construct() {
        parent::__construct('authentications');
    }

    public function login(string $email, string $password) {
        $payload = [
            'email' => $email,
            'password' => $password,
        ];

        return $this->post($payload, '?platform=web');
    }

    public function validateUserSiteAccess(string $siteURL) {
        return $this->get(null, '/check/site?url=' . $siteURL);
    }

    public function logout() {
        return $this->delete();
    }

    public function verifyEmailForgotPassword(string $email) {
        $payload = [
            'email' => $email,
        ];

        return $this->post($payload, '/password/forgot');
    }

    public function resetPasswordByOTP(
        string $email, string $otp, string $newPassword, string $confirmPassword
    ) {
        $payload = [
            'email' => $email,
            'otp' => $otp,
            'password' => $newPassword,
            'confirm_password' => $confirmPassword,
        ];

        return $this->post($payload, '/password/reset');
    }

    public function getSiteInfo(string $url) {
        $query = '?url=' . $url;

        return $this->get(null, ('/detail/site' . $query));
    }
}
