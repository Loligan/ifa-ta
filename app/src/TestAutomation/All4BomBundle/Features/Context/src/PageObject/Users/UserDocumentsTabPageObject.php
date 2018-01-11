<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 11.1.18
 * Time: 11.25
 */

namespace TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users;


use TestAutomation\All4BomBundle\Features\Context\src\PageObject\PageObject;

class UserDocumentsTabPageObject extends PageObject
{
    const DOCUMENTS_TAB = './/*[normalize-space(text())="Documents"][contains(@href,"/documents")]';
    const ADD_NEW_POI_TAB = './/*[normalize-space(text())="Add new POI"][contains(@href,"/documents/create-proof-of-identity")]';
    const ADD_NEW_POR_TAB = './/*[normalize-space(text())="Add new POR"][contains(@href,"/documents/create-proof-of-residence")]';
    const ADD_NEW_POP_TAB = './/*[normalize-space(text())="Add new POP"][contains(@href,"/documents/create-proof-of-payment")]';

    public static function clickOnDocumentTab(){
        self::findElementAndClick(self::DOCUMENTS_TAB);
    }

    public static function clickOnAddNewPoiTab(){
        self::findElementAndClick(self::ADD_NEW_POI_TAB);
    }

    public static function clickOnAddNewPorTab(){
        self::findElementAndClick(self::ADD_NEW_POR_TAB);
    }

    public static function clickOnAddNewPopTab(){
        self::findElementAndClick(self::ADD_NEW_POP_TAB);
    }
}