<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 10.1.18
 * Time: 16.14
 */

namespace TestAutomation\All4BomBundle\Features\Context\src\PageObject\Crm\Users;


use TestAutomation\All4BomBundle\Features\Context\src\PageObject\PageObject;

class UserOverviewPageObject extends PageObject
{
    const PATH_ONE = '/overview';
    const PATH_TWO = '/users';

    const LOGIN_CREDENTIALS_DEFAULT_EMAIL = './/*[@class="about"][.//*[normalize-space(text())="Default email"]]//*[text()="VALUE"]';
    const LOGIN_CREDENTIALS_DEFAULT_PHONE = './/*[@class="about"][.//*[normalize-space(text())="Default phone"]]//*[text()="VALUE"]';

    const PERSONAL_INFO_FIRST_NAME = './/*[@class="about"][.//*[normalize-space(text())="First name"]]//*[normalize-space(text())="VALUE"]';
    const PERSONAL_INFO_LAST_NAME = './/*[@class="about"][.//*[normalize-space(text())="Last name"]]//*[normalize-space(text())="VALUE"]';
    const PERSONAL_INFO_DATE_OF_BIRTH = './/*[@class="about"][.//*[normalize-space(text())="Date of birth"]]//*[normalize-space(text())="VALUE"]';
    const PERSONAL_INFO_COUNTRY = './/*[@class="about"][.//*[normalize-space(text())="Country"]]//*[normalize-space(text())="VALUE"]';
    const PERSONAL_INFO_CITY_VILLAGE = './/*[@class="about"][.//*[normalize-space(text())="City/Village"]]//*[normalize-space(text())="VALUE"]';
    const PERSONAL_INFO_REGION_DISTRICT = './/*[@class="about"][.//*[normalize-space(text())="Region/District"]]//*[normalize-space(text())="VALUE"]';


    public static function checkOnPage(){
        self::checkPrefix(self::PATH_ONE);
        self::checkPrefix(self::PATH_TWO);
    }

    public static function checkLoginCredentialsDefaultEmail($email){
        $xpath = str_replace('VALUE',$email,self::LOGIN_CREDENTIALS_DEFAULT_EMAIL);
        self::findElement($xpath);
    }

    public static function checkLoginCredentialsDefaultPhone($phone){
        $xpath = str_replace('VALUE',$phone,self::LOGIN_CREDENTIALS_DEFAULT_PHONE);
        self::findElement($xpath);
    }

    public static function checkPersonalInfoFirstName($firstName){
        $xpath = str_replace('VALUE',$firstName,self::PERSONAL_INFO_FIRST_NAME);
        self::findElement($xpath);
    }

    public static function checkPersonalInfoLastName($lastName){
        $xpath = str_replace('VALUE',$lastName,self::PERSONAL_INFO_LAST_NAME);
        self::findElement($xpath);
    }

    public static function checkPersonalInfoDateOfBirth($dateOfBirth){
        $xpath = str_replace('VALUE',$dateOfBirth,self::PERSONAL_INFO_DATE_OF_BIRTH);
        self::findElement($xpath);
    }

    public static function checkPersonalInfoCountry($country){
        $xpath = str_replace('VALUE',$country,self::PERSONAL_INFO_COUNTRY);
        self::findElement($xpath);
    }

    public static function checkPersonalInfoCityVillage($cityVillage){
        $xpath = str_replace('VALUE',$cityVillage,self::PERSONAL_INFO_CITY_VILLAGE);
        self::findElement($xpath);
    }

    public static function checkPersonalInfoRegionDistrict($regionDistrict){
        $xpath = str_replace('VALUE',$regionDistrict,self::PERSONAL_INFO_REGION_DISTRICT);
        self::findElement($xpath);
    }




}