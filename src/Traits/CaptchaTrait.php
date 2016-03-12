<?php namespace jlourenco\support\Traits;

use Input;
use ReCaptcha\ReCaptcha;

trait CaptchaTrait
{

    public function captchaCheck()
    {
        $response = Input::get('g-recaptcha-response');
        $remoteip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); //$_SERVER['REMOTE_ADDR'];
        $secret   = config('jlourenco.support.RE_CAP_SECRET');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);

        if ($resp->isSuccess())
            return true;
        else
            return false;
    }

}