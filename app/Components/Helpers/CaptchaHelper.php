<?php


namespace App\Components\Helpers;

use GuzzleHttp\Client;

/**
 * Трейт, содержащий функции-помощники для работы с капчой.
 * @package App\Components\Helpers Классы-помощники.
 */
trait CaptchaHelper
{
    /**
     * Проверяет ответ Google captcha.
     *
     * @param string $response ответ google captcha.
     * @return bool флаг успешности проверки.
     */
    private function verifyCaptcha(string $response)
    {
        // Заводим клиент Guzzle
        $client = new Client();
        // Делаем запрос
        $result = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('app.google_recaptcha.secret'),
                'response' => $response
            ]
        ]);
        // Если ответ не успешен, возвращаем ложь
        if($result->getStatusCode() !== 200) {
            return false;
        }
        // Получаем контент ответа и декодируем его из JSON
        $content = json_decode($result->getBody()->getContents());
        // Возвращаем статус проверки
        return $content->success;
    }
}
