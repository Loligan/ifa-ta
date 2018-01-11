<?php

namespace TestAutomation\All4BomBundle\Features\Context\src\PageObject\My;

use TestAutomation\All4BomBundle\Features\Context\src\PageObject\PageObject;

class LoginPageObject extends PageObject
{
    const PATH = "/login";

    const LOGIN_INPUT = './/*[@id="login_email"]';
    const PASSWORD_INPUT = './/*[@id="login_password"]';
    const LOGIN_BUTTON= './/*[@id="login_grecaptcha"]';

    public static function openUrlLoginPage($url)
    {
        self::openURLPage($url . self::PATH);
    }

    public static function checkOnLoginPage()
    {
        self::checkPrefix(self::PATH);
    }

    public static function sendKeysInLoginInput($value){
        self::findElementAndSendKey(self::LOGIN_INPUT,$value);
    }

    public static function sendKeysInPasswordInput($value){
        self::findElementAndSendKey(self::PASSWORD_INPUT,$value);
    }

    public static function clickOnLoginButton(){
        self::findElementAndClick(self::LOGIN_BUTTON);
    }

}