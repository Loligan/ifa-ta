<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 10.1.18
 * Time: 15.37
 */

namespace TestAutomation\All4BomBundle\Features\Context\src\PageObject;


class LoginPageObject extends PageObject
{
    const PATH = "/login";

    const USERNAME_INPUT = './/*[@id="login_username"]';
    const PASSWORD_INPUT = './/*[@id="login_password"]';
    const LOGIN_INPUT = './/*[@id="m_login_signin_submit"]';

    public static function openUrlLoginPage($url){
        self::openURLPage($url.self::PATH);
    }

    public static function checkOnLoginPage(){
        self::checkPrefix(self::PATH);
    }

    public static function sendKeysInUsernameInput($value){
        self::findElementAndSendKey(self::USERNAME_INPUT,$value);
    }

    public static function sendKeysInPasswordInput($value){
        self::findElementAndSendKey(self::PASSWORD_INPUT,$value);
    }

    public static function clickOnLoginButton(){
        self::findElementAndClick(self::LOGIN_INPUT);
    }
}