<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Exception;
class recaptcha_verify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->token_verify($request->grecaptcha ??'empty'))
        {
            return (array('result' => 'recaptcha verify fail'));
        }
        return $next($request);
    }
    private function token_verify(string $token)
    {
        if($token==='empty')
        {
            return false;

        }
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $postdata = [
            // 'secret' => config('settings.google_recaptcha_secret'),
            'secret' => '6Le1lLUZAAAAAHiJhgYjy8rL7XjttqTcPDsg-pIu',
            'response' => $token,
        ];
        $client = new Client();
        $response = $client->request('POST', $url, [
            'form_params' => $postdata
        ]);
        $code = $response->getStatusCode();
        $content = json_decode($response->getBody()->getContents());

        if ($code === 200 && $content->success === true) {
            return true;
        }

        return false;
    }
}
