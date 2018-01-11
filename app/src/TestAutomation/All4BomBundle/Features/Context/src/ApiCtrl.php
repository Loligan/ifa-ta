<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 21.8.17
 * Time: 12.32
 */

namespace TestAutomation\All4BomBundle\Features\Context\src;


use Symfony\Component\Config\Definition\Exception\Exception;
use TestAutomation\All4BomBundle\Features\Context\FeatureContext;

class ApiCtrl
{
    const DEFAULT_PASSOWD = '12345';

    public static function createUser()
    {
        print
            '===================================' . PHP_EOL .
            '======   USER CREATE START   ======' . PHP_EOL .
            '===================================' . PHP_EOL;

        $email = self::generateEmail();
        $login = self::generateLogin();

        $requestData = array(
            'method' => "user:registration",
            "data" => [
                'email' => $email,
                "username" => $login,
                "password" => self::DEFAULT_PASSOWD
            ],
            "request_id" => "sdfsdfsd234wdf23sdf3r2"
        );
        $url = FeatureContext::getSiteUrl() . "/test/access/";
        $payload = json_encode($requestData);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resultExec = curl_exec($ch);
        curl_close($ch);

        if(strstr($resultExec,"Internal Server Error")){
            throw new \Exception("500. Internal Server Error");
        }

        $resultExec = json_decode($resultExec, true);
        if ($resultExec['error'] != null) {
            throw new \Exception('Register fail. Result exec: ' . PHP_EOL . $resultExec . PHP_EOL);
        }

        $arrResult = [
            'email' => $email,
            'login' => $login,
            'password' => self::DEFAULT_PASSOWD,
        ];
        return $arrResult;
    }

    public static function delete($login, $password)
    {
        $userApiHash = self::login($login, $password);
        print
            '===================================' . PHP_EOL .
            '======   USER DELETE START   ======' . PHP_EOL .
            '===================================' . PHP_EOL;
        $requestData = array(
            'method' => "user:delete",
            "data" => [],
            "request_id" => "sdfsdfsd234wdf23sdf3r2"
        );
        $url = FeatureContext::getSiteUrl()."/test/access/";
        $payload = json_encode($requestData);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'User-Api-Hash:' . $userApiHash
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private static function login($login, $pass)
    {
        print
            '===================================' . PHP_EOL .
            '======   USER LOGIN START   =======' . PHP_EOL .
            '===================================' . PHP_EOL;
        $requestData = array(
            'method' => "user:login",
            "data" => [
                "login" => $login,
                "password" => $pass
            ],
            "request_id" => "sdfsdfsd234wdf23sdf3r2"
        );
        $url = FeatureContext::getSiteUrl()."/test/access/";
        $payload = json_encode($requestData);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private static function generateString($numAlpha = 6)
    {
        $listAlpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return str_shuffle(
            substr(str_shuffle($listAlpha), 0, $numAlpha)
        );
    }

    private static function generateLogin()
    {
        $numAlpha = rand(5, 12);
        return self::generateString($numAlpha);
    }

    private static function generateEmail()
    {
        $numAlpha = rand(5, 15);
        $name = self::generateString($numAlpha);
        return $name . '@ta.com';
    }

}