<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 10.1.18
 * Time: 16.10
 */

namespace TestAutomation\All4BomBundle\Features\Context\src\PageObject\Clients;


use TestAutomation\All4BomBundle\Features\Context\src\PageObject\PageObject;

class ClientsPageObject extends PageObject
{
    const PATH = '/clients';
    const EMAIL_USER_TABLE = './/*[contains(@href,"/overview")][text()="VALUE"]';
    const ADD_CLIENT_BUTTON = './/*[@data-original-title="Add new client"]';

    const CLIENT_REGISTRATION_POPUP_ADD_NEW_CLIENT_USING_EMAIL = './/*[text()="Add new client using email"]';
    const CLIENT_REGISTRATION_POPUP_EMAIL_INPUT = './/*[@name="email"]';
    const CLIENT_REGISTRATION_POPUP_SUBMIT_BUTTON = './/button[normalize-space(text())="Submit"]';
    const CLIENT_REGISTRATION_POPUP_SUCCESS_CONFIM_REGISTRATION_LABEL = './/*[normalize-space(text())="Success! New client has been created."]';
    const CLIENT_REGISTRATION_POPUP_SUCCESS_LOGIN_LABEL_LOGIN = './/div[./div[text()="Login"]][./div[text()="VALUE"]]';
    const CLIENT_REGISTRATION_POPUP_SUCCESS_LOGIN_LABEL_PASSWORD = './/div[./div[text()="Password"]]';
    const CLIENT_REGISTRATION_POPUP_SUCCESS_LOGIN_CLOSE_BUTTON  = './/button[@type="reset"]';

    public static function checkOnPage(){
        self::checkPrefix(self::PATH);
    }

    public static function clickOnEmailUserInTable($email){
        $xpath = str_replace('VALUE',$email,self::EMAIL_USER_TABLE);
        self::findElementAndClick($xpath);
    }

    public static function clickOnAddClientButton(){
        self::findElementAndClick(self::ADD_CLIENT_BUTTON);
    }

    public static function clickOnClientRegistrationPopupAddNewClientUsingEmailText(){
        self::findElementAndClick(self::CLIENT_REGISTRATION_POPUP_ADD_NEW_CLIENT_USING_EMAIL);
    }

    public static function sendKeysInClientRegistrationPopupEmailInput($email){
        self::findElementAndSendKey(self::CLIENT_REGISTRATION_POPUP_EMAIL_INPUT,$email);
    }

    public static function clickOnClientRegistrationPopupSubmitButton(){
        self::findElementAndClick(self::CLIENT_REGISTRATION_POPUP_SUBMIT_BUTTON);
    }

    public static function checkPopupRegistrationSuccessLabel(){
        self::findElement(self::CLIENT_REGISTRATION_POPUP_SUCCESS_CONFIM_REGISTRATION_LABEL);
    }

    public static function checkPopupRegistrationSuccessEmail($email){
        $xpath = str_replace('VALUE',$email,self::CLIENT_REGISTRATION_POPUP_SUCCESS_LOGIN_LABEL_LOGIN);
        self::findElement($xpath);
    }

    public static function getPopupRegistrationSuccessPassword(){
        $element = self::findElement(self::CLIENT_REGISTRATION_POPUP_SUCCESS_LOGIN_LABEL_PASSWORD);
        $textNodeElement = $element->getText();
        return trim($textNodeElement);
    }

    public static function popupRegistrationSuccessClickCloseButton(){
        self::findElementAndClick(self::CLIENT_REGISTRATION_POPUP_SUCCESS_LOGIN_CLOSE_BUTTON);
    }


}