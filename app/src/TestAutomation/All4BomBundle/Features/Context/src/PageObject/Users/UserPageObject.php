<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 10.1.18
 * Time: 16.14
 */

namespace TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users;


use TestAutomation\All4BomBundle\Features\Context\src\PageObject\PageObject;

class UserPageObject extends PageObject
{
    const LEFT_PANEL_NAME = './/*[@class="m-card-profile__name" and normalize-space(text())="VALUE"]';
    const PROFILE_BUTTON = './/*[text()="Profile"]';
    const OVERVIEW_BUTTON = './/*[text()="Overview"]';
    const DOCUMENTS_BUTTON = './/*[text()="Documents"]';

    public static function checkName($firstNameWithLastName){
        $xpath = str_replace('VALUE',$firstNameWithLastName,self::LEFT_PANEL_NAME);
        self::findElement($xpath);
    }

    public static function clickOnProfileButton(){
        self::findElementAndClick(self::PROFILE_BUTTON);
    }

    public static function clickOnOverviewButton(){
        self::findElementAndClick(self::OVERVIEW_BUTTON);
    }

    public static function clickOnDocumentsButton(){
        self::findElementAndClick(self::DOCUMENTS_BUTTON);
    }
}