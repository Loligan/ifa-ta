<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 10.1.18
 * Time: 18.14
 */

namespace TestAutomation\All4BomBundle\Features\Context\src\PageObject\Crm\Users;


use TestAutomation\All4BomBundle\Features\Context\src\PageObject\PageObject;

class UserProfilePageObject extends PageObject
{
    const PATH_ONE = '/users';
    const PATH_TWO = '/profile';
    const NAME_INPUT = './/*[@id="user_name"]';
    const LAST_NAME_INPUT = './/*[@id="user_lastName"]';
    const ADDRESS_INPUT = './/*[@id="user_address"]';
    const CITY_INPUT = './/*[@id="user_city"]';

    const COUNTRY_SELECT = './/select[@id="user_countryAlpha3"]';
    const COUNTRY_OPTION = './/select[@id="user_countryAlpha3"]/option[text()="VALUE"]';

    const BDAY_DAY_SELECT = './/select[@id="user_birthday_day"]';
    const BDAY_DAY_OPTION = './/select[@id="user_birthday_day"]/option[text()="VALUE"]';

    const BDAY_MONTH_SELECT = './/select[@id="user_birthday_month"]';
    const BDAY_MONTH_OPTION = './/select[@id="user_birthday_month"]/option[text()="VALUE"]';

    const BDAY_YEAR_SELECT = './/select[@id="user_birthday_year"]';
    const BDAY_YEAR_OPTION = './/select[@id="user_birthday_year"]/option[text()="VALUE"]';

    const SAVE_BUTTON = './/*[@id="user_submit"]';
    const SUCCESS_LABEL = './/*[normalize-space(text())="Success update user."]';

    public static function checkOnPage(){
        self::checkPrefix(self::PATH_ONE);
        self::checkPrefix(self::PATH_TWO);
    }
    public static function sendKeysInNameInput($value)
    {
        self::findElementAndSendKey(self::NAME_INPUT ,$value);
    }

    public static function sendKeysInLastNameInput($value)
    {
        self::findElementAndSendKey(self::LAST_NAME_INPUT, $value);
    }

    public static function sendKeysInAddressInput($value)
    {
        self::findElementAndSendKey(self::ADDRESS_INPUT, $value);
    }

    public static function sendKeysInCityInput($value)
    {
        self::findElementAndSendKey(self::CITY_INPUT, $value);
    }

    public static function clickOnCountrySelect(){
        self::findElementAndClick(self::COUNTRY_SELECT);
    }

    public static function clickOnCountryOption($value){
        $xpath = str_replace('VALUE',$value,self::COUNTRY_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnBdayDaySelect(){
        self::findElementAndClick(self::BDAY_DAY_SELECT);
    }

    public static function clickOnBdayDayOption($value){
        $xpath = str_replace('VALUE',$value,self::BDAY_DAY_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnBdayMonthSelect(){
        self::findElementAndClick(self::BDAY_MONTH_SELECT);
    }

    public static function clickOnBdayMonthOption($value){
        $xpath = str_replace('VALUE',$value,self::BDAY_MONTH_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnBdayYearSelect(){
        self::findElementAndClick(self::BDAY_YEAR_SELECT);
    }

    public static function clickOnBdayYearOption($value){
        $xpath = str_replace('VALUE',$value,self::BDAY_YEAR_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function clickOnSaveButton(){
        self::findElementAndClick(self::SAVE_BUTTON);
    }

    public static function checkSuccessLabel(){
        self::findElement(self::SUCCESS_LABEL);
    }
}