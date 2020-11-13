<?php

namespace App\Http\Requests\Api;


class VerificationCodeRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'captcha_key' => 'required|string',
                'captcha_code' => 'required|string',
            ];
    }

    public function attributes()
    {
        return [
            'captcha_key' => '图片验证码 key',
            'captcha_code' => '图片验证码',
        ];
    }
}

$code = '071aYd1w3HhthV2dbS2w35U4Ja1aYd16';
$driver = Socialite::driver('wechat');
$accessToken = $driver->getAccessToken($code);
$oauthUser = $driver->user($accessToken);
$oauthUser->getNickname();
$oauthUser->getId();