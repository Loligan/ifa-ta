<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 11.1.18
 * Time: 11.33
 */

namespace TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users;


use TestAutomation\All4BomBundle\Features\Context\src\PageObject\PageObject;

class UserDocumentsAddNewPoiPageObject extends PageObject
{
    const PATH = "/documents/create-proof-of-identity";

    const SUBTYPE_SELECT = './/select[@id="proof_of_identity_form_subtype"]';
    const SUBTYPE_OPTION = './/select[@id="proof_of_identity_form_subtype"]/option[text()="VALUE"]';
    const FILE_INPUT = './/*[@id="proof_of_identity_form_file"]';
    const SAVE_BUTTON = './/button[@type="submit"][normalize-space(text())="Save"]';

    public static function checkOnPage(){
        self::checkPrefix(self::PATH);
    }

    public static function clickOnSubtypeSelect(){
        self::findElementAndClick(self::SUBTYPE_SELECT);
    }

    public static function clickOnSubtypeOption($value){
        $xpath = str_replace('VALUE',$value,self::SUBTYPE_OPTION);
        self::findElementAndClick($xpath);
    }

    public static function sendFileInInput($filePath){
        $filePath = self::FILES_PATH.$filePath;
        self::findElementAndSendFile(self::FILE_INPUT,$filePath);
    }

    public static function clickOnSaveButton(){
        self::findElementAndClick(self::SAVE_BUTTON);
    }
}