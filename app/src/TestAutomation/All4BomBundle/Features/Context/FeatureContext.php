<?php

namespace TestAutomation\All4BomBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Http\Client\Curl\Client;
use Symfony\Bridge\Monolog\Logger;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\Clients\ClientsPageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\LoginPageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\PageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users\UserDocumentsAddNewPoiPageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users\UserDocumentsAddNewPopPageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users\UserDocumentsAddNewPorPageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users\UserDocumentsPageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users\UserDocumentsTabPageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users\UserOverviewPageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users\UserPageObject;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\Users\UserProfilePageObject;
use TestAutomationCoreBundle\src\BehatConnection\BehatConnection;


class FeatureContext implements Context
{

//    const ENABLE_REPORT_CONNECTION = true;
    const ENABLE_REPORT_CONNECTION = false;

    private static $url = 'https://staging.crm.ifa-fx.com';
    private static $username = null;
    private static $password = null;
    private static $dataSave = [];

    /**
     * @var RemoteWebDriver $webDriver
     */
    private static $webDriver;
    /**@var BehatConnection $behatConnection */
    private static $behatConnection;
    private static $printStrId;

    public function __construct($session, $doctrine, $bconnection)
    {
        self::$behatConnection = $bconnection;
        if (!self::ENABLE_REPORT_CONNECTION) {
            self::$behatConnection->disableBehatConnection();
        }
    }


    public static function runChrome()
    {
        $range = 0;
        while (true) {
            $range++;
            if ($range > 10) {
                break;
            }
            sleep(3);
            try {
                $capabilities = DesiredCapabilities::chrome();
                self::$webDriver = RemoteWebDriver::create("hub:4444/wd/hub", $capabilities, 90 * 1000, 900 * 1000);
                self::$webDriver->manage()->window();
                self::$webDriver->manage()->window()->maximize();
            } catch (\Exception $e) {

                print $e->getMessage() . PHP_EOL;
            }
            if (self::$webDriver == null) {
                continue;
            }
            break;
        }
    }

    /**
     * @return RemoteWebDriver
     */
    public static function getWebDriver()
    {
        return self::$webDriver;
    }

    public static function getSiteUrl()
    {
        return self::$url;
    }

    public static function printUserGenerateInfo()
    {
        print
            PHP_EOL . PHP_EOL .
            "|-------------------------------------|" . PHP_EOL .
            "|------  GENERATE USER INFO   ---------|" . PHP_EOL .
            "|--------------------------------------|" . PHP_EOL .
            "|--------------------------------------|" . PHP_EOL .
            "|--------------------------------------|" .
            PHP_EOL . PHP_EOL;
    }

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     */
    public function BeforeScenario(BeforeScenarioScope $scope)
    {
        self::runChrome();
        self::$printStrId = self::$behatConnection->beforeScenario($scope, $url);
        if (self::ENABLE_REPORT_CONNECTION) {
            self::$url = $url;
        }
    }

    /**
     * @AfterScenario
     * @param AfterScenarioScope $scope
     */
    public function AfterScenario(AfterScenarioScope $scope)
    {
        self::$behatConnection->afterScenario($scope);
        self::printUserGenerateInfo();


//        if (!self::ENABLE_REPORT_CONNECTION) {
        file_put_contents("gen.png", self::$webDriver->takeScreenshot());
        file_put_contents("gen.html", self::$webDriver->getPageSource());
//        }
        if (self::$printStrId != null) {
            print self::$printStrId;
        }
        self::$webDriver->quit();
    }

    /**
     * @AfterStep
     * @param AfterStepScope $scope
     */
    public function AfterStep(AfterStepScope $scope)
    {
        self::$behatConnection->afterStepScenario($scope, self::$webDriver);
    }

    /**
     * @Given /^Create user by API == API ==$/
     */
    public function createUserByAPIAPI()
    {
        self::$username = 'admin_ifa_fx@site.com';
        self::$password = '12345678';
    }


    /**
     * @Given /^Sleep "([^"]*)"$/
     */
    public function sleepStep($arg1)
    {
        sleep($arg1);
    }

    /**
     * @Given /^Exception "([^"]*)"$/
     */
    public function exceptionStep($arg1)
    {
        throw new \Exception('EXCEPTION STEP');
    }

    /**
     * @Given /^Open Login page == path: \/login ==$/
     */
    public function openLoginPagePathLogin()
    {
        LoginPageObject::openUrlLoginPage(self::$url);
    }

    /**
     * @Given /^Check is this Login page == path: \/login ==$/
     */
    public function checkIsThisLoginPagePathLogin()
    {
        LoginPageObject::checkOnLoginPage();
    }

    /**
     * @Given /^Send keys in Username input create username api data == path: \/login ==$/
     */
    public function sendKeysInUsernameInputCreateUsernameApiDataPathLogin()
    {
        LoginPageObject::sendKeysInUsernameInput(self::$username);
    }

    /**
     * @Given /^Send keys in Password input create password api data== path: \/login ==$/
     */
    public function sendKeysInPasswordInputCreatePasswordApiDataPathLogin()
    {
        LoginPageObject::sendKeysInPasswordInput(self::$password);
    }

    /**
     * @Given /^Click on Login button == path: \/login ==$/
     */
    public function clickOnLoginButtonPathLogin()
    {
        LoginPageObject::clickOnLoginButton();
    }

    /**
     * @Given /^Check is this Clients page == path: \/clients ==$/
     */
    public function checkIsThisClientsPagePathClients()
    {
        ClientsPageObject::checkOnPage();
    }

    /**
     * @Given /^Click on email "([^"]*)" in clients table == path: \/clients ==$/
     */
    public function clickOnEmailInClientsTablePathClients($arg1)
    {
        ClientsPageObject::clickOnEmailUserInTable($arg1);
    }

    /**
     * @Given /^Check on Overview Client Page == path: \/clients ==$/
     */
    public function checkOnOverviewClientPagePathClients()
    {
        UserOverviewPageObject::checkOnPage();
    }

    /**
     * @Given /^Check that Login credentials contains Default email "([^"]*)" == path: users\/\{id\}\/overview ==$/
     */
    public function checkThatLoginCredentialsContainsDefaultEmailPathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkLoginCredentialsDefaultEmail($arg1);
    }

    /**
     * @Given /^Check that Login credentials contains Default phone "([^"]*)" == path: users\/\{id\}\/overview ==$/
     */
    public function checkThatLoginCredentialsContainsDefaultPhonePathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkLoginCredentialsDefaultPhone($arg1);
    }

    /**
     * @Given /^Check that Personal info contains First name "([^"]*)" == path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsFirstNamePathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoFirstName($arg1);
    }

    /**
     * @Given /^Check that Personal info contains Last name "([^"]*)" == path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsLastNamePathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoLastName($arg1);
    }

    /**
     * @Given /^Check that Personal info contains Country "([^"]*)" == path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsCountryPathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoCountry($arg1);
    }

    /**
     * @Given /^Check that Personal info contains Date of birth "([^"]*)" == path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsDateOfBirthPathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoDateOfBirth($arg1);
    }

    /**
     * @Given /^Check that Personal info contains City\/Village "([^"]*)" == path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsCityVillagePathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoCityVillage($arg1);
    }

    /**
     * @Given /^Check that Personal info contains Region\/District "([^"]*)" == path: users\/\{id\}\/overview ==$/
     */
    public function checkThatPersonalInfoContainsRegionDistrictPathUsersIdOverview($arg1)
    {
        UserOverviewPageObject::checkPersonalInfoRegionDistrict($arg1);
    }

    /**
     * @Given /^Check that Name "([^"]*)" contains in left panel  == path: users\/\{id\}\/... ==$/
     */
    public function checkThatNameContainsInLeftPanelPathUsersIdOverview($arg1)
    {
        UserPageObject::checkName($arg1);
    }

    /**
     * @Given /^Click on \[Add client\] button == path: \/clients ==$/
     */
    public function clickOnAddClientButtonPathClients()
    {
        ClientsPageObject::clickOnAddClientButton();
    }

    /**
     * @Given /^Click on \[Add new client using email\] text in client registration popup == path: \/clients ==$/
     */
    public function clickOnAddNewClientUsingEmailTextInClientRegistrationPopupPathClients()
    {
        ClientsPageObject::clickOnClientRegistrationPopupAddNewClientUsingEmailText();
    }

    /**
     * @Given /^Send keys "([^"]*)" in email input in client registration popup == path: \/clients ==$/
     */
    public function sendKeysInEmailInputInClientRegistrationPopupPathClients($arg1)
    {
        ClientsPageObject::sendKeysInClientRegistrationPopupEmailInput($arg1);
    }

    /**
     * @Given /^Click on \[Submit\] button in client registration popup == path: \/clients ==$/
     */
    public function clickOnSubmitButtonInClientRegistrationPopupPathClients()
    {
        ClientsPageObject::clickOnClientRegistrationPopupSubmitButton();
    }

    /**
     * @Given /^I show success label user create == path: \/clients ==$/
     */
    public function iShowSuccessLabelUserCreatePathClients()
    {
        ClientsPageObject::checkPopupRegistrationSuccessLabel();
    }

    /**
     * @Given /^In success popup label contain email "([^"]*)" == path: \/clients ==$/
     */
    public function inSuccessPopupLabelContainEmailPathClients($arg1)
    {
        ClientsPageObject::checkPopupRegistrationSuccessEmail($arg1);
    }

    /**
     * @Given /^In success popup label contain password == path: \/clients ==$/
     */
    public function inSuccessPopupLabelContainPasswordPathClients()
    {
        ClientsPageObject::getPopupRegistrationSuccessPassword();
    }

    /**
     * @Given /^Save user "([^"]*)" password == path: \/clients ==$/
     */
    public function saveUserPasswordPathClients($arg1)
    {
        $password = ClientsPageObject::getPopupRegistrationSuccessPassword();
        self::$dataSave['user_login_info'][$arg1] = $password;
    }

    /**
     * @Given /^Press \[Close button\] == path: \/clients ==$/
     */
    public function pressCloseButtonPathClients()
    {
        ClientsPageObject::popupRegistrationSuccessClickCloseButton();
    }

    /**
     * @Given /^Refresh page$/
     */
    public function refreshPage()
    {
        self::getWebDriver()->navigate()->refresh();
    }

    /**
     * @Given /^Click on \[Profile\] button on left panel == path: users\/\{id\}\/\.\.\.==$/
     */
    public function clickOnProfileButtonOnLeftPanelPathUsersId()
    {
        UserPageObject::clickOnProfileButton();
    }

    /**
     * @Given /^Check on Users profile page == path: users\/\{id\}\/profile ==$/
     */
    public function checkOnUsersProfilePagePathUsersIdProfile()
    {
       UserProfilePageObject::checkOnPage();
    }

    /**
     * @Given /^Send keys "([^"]*)" in Name input == path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInNameInputPathUsersIdProfile($arg1)
    {
        UserProfilePageObject::sendKeysInNameInput($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Last Name input == path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInLastNameInputPathUsersIdProfile($arg1)
    {
        UserProfilePageObject::sendKeysInLastNameInput($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in Address input == path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInAddressInputPathUsersIdProfile($arg1)
    {
        UserProfilePageObject::sendKeysInAddressInput($arg1);
    }

    /**
     * @Given /^Send keys "([^"]*)" in City input == path: users\/\{id\}\/profile ==$/
     */
    public function sendKeysInCityInputPathUsersIdProfile($arg1)
    {
        UserProfilePageObject::sendKeysInCityInput($arg1);
    }

    /**
     * @Given /^Click on Country select$/
     */
    public function clickOnCountrySelect()
    {
        UserProfilePageObject::clickOnCountrySelect();
    }

    /**
     * @Given /^Click on Country option "([^"]*)"$/
     */
    public function clickOnCountryOption($arg1)
    {
        UserProfilePageObject::clickOnCountryOption($arg1);
    }

    /**
     * @Given /^Click on B\-day day select$/
     */
    public function clickOnBDayDaySelect()
    {
        UserProfilePageObject::clickOnBdayDaySelect();
    }

    /**
     * @Given /^Click on B\-day day option "([^"]*)"$/
     */
    public function clickOnBDayDayOption($arg1)
    {
        UserProfilePageObject::clickOnBdayDayOption($arg1);
    }

    /**
     * @Given /^Click on B\-day month select$/
     */
    public function clickOnBDayMonthSelect()
    {
        UserProfilePageObject::clickOnBdayMonthSelect();
    }

    /**
     * @Given /^Click on B\-day month option "([^"]*)"$/
     */
    public function clickOnBDayMonthOption($arg1)
    {
        UserProfilePageObject::clickOnBdayMonthOption($arg1);
    }

    /**
     * @Given /^Click on B\-day year select$/
     */
    public function clickOnBDayYearSelect()
    {
        UserProfilePageObject::clickOnBdayYearSelect();
    }

    /**
     * @Given /^Click on B\-day year option "([^"]*)"$/
     */
    public function clickOnBDayYearOption($arg1)
    {
        UserProfilePageObject::clickOnBdayYearOption($arg1);
    }

    /**
     * @Given /^Click on \[Save\] button$/
     */
    public function clickOnSaveButton()
    {
        UserProfilePageObject::clickOnSaveButton();
    }

    /**
     * @Given /^Show save success label$/
     */
    public function showSaveSuccessLabel()
    {
        UserProfilePageObject::checkSuccessLabel();
    }

    /**
     * @Given /^Click on \[Overview\] button on left panel == path: users\/\{id\}\/\.\.\.==$/
     */
    public function clickOnOverviewButtonOnLeftPanelPathUsersId()
    {
        UserPageObject::clickOnOverviewButton();
    }

    /**
     * @Given /^Click on \[Documents\] button on left panel == path: users\/\{id\}\/\.\.\. ==$/
     */
    public function clickOnDocumentsButtonOnLeftPanelPathUsersId()
    {
        UserPageObject::clickOnDocumentsButton();
    }

    /**
     * @Given /^Check on Documents page == path: users\/\{id\}\/documents ==$/
     */
    public function checkOnDocumentsPagePathUsersIdDocuments()
    {
        UserDocumentsPageObject::checkOnThePage();
    }

    /**
     * @Given /^Click on \[Add new POI\] tab == path: users\/\{id\}\/documents\/\.\.\. ==$/
     */
    public function clickOnAddNewPOITabPathUsersIdDocuments()
    {
        UserDocumentsTabPageObject::clickOnAddNewPoiTab();
    }

    /**
     * @Given /^Check on Add new POI page == path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function checkOnAddNewPOIPagePathUsersIdDocumentsCreateProofOfIdentity()
    {
        UserDocumentsAddNewPoiPageObject::checkOnPage();
    }

    /**
     * @Given /^Click on Subtype select == path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function clickOnSubtypeSelectPathUsersIdDocumentsCreateProofOfIdentity()
    {
        UserDocumentsAddNewPoiPageObject::clickOnSubtypeSelect();
    }

    /**
     * @Given /^Click on Subtype option with value "([^"]*)" == path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function clickOnSubtypeOptionWithValuePathUsersIdDocumentsCreateProofOfIdentity($arg1)
    {
        UserDocumentsAddNewPoiPageObject::clickOnSubtypeOption($arg1);
    }

    /**
     * @Given /^Send file in file input "([^"]*)" == path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function sendFileInFileInputPathUsersIdDocumentsCreateProofOfIdentity($arg1)
    {
        UserDocumentsAddNewPoiPageObject::sendFileInInput($arg1);
    }

    /**
     * @Given /^Click on \[Save\] button == path: users\/\{id\}\/documents\/create\-proof\-of\-identity ==$/
     */
    public function clickOnSaveButtonPathUsersIdDocumentsCreateProofOfIdentity()
    {
        UserDocumentsAddNewPoiPageObject::clickOnSaveButton();
    }

    /**
     * @Given /^Check in table "([^"]*)" line == path: users\/\{id\}\/documents ==$/
     */
    public function checkInTableLinePathUsersIdDocuments($arg1)
    {
        UserDocumentsPageObject::checkNumberTableLine($arg1);
    }

    /**
     * @Given /^Check in table "([^"]*)" line with Type "([^"]*)" == path: users\/\{id\}\/documents ==$/
     */
    public function checkInTableLineWithTypePathUsersIdDocuments($arg1, $arg2)
    {
        UserDocumentsPageObject::checkNumberTableLineByType($arg1,$arg2);
    }

    /**
     * @Given /^Click on \[Add new POR\] tab == path: users\/\{id\}\/documents\/\.\.\. ==$/
     */
    public function clickOnAddNewPORTabPathUsersIdDocuments()
    {
       UserDocumentsTabPageObject::clickOnAddNewPorTab();
    }

    /**
     * @Given /^Check on Add new POR page == path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function checkOnAddNewPORPagePathUsersIdDocumentsCreateProofOfResidence()
    {
        UserDocumentsAddNewPorPageObject::checkOnPage();
    }

    /**
     * @Given /^Click on Subtype select == path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function clickOnSubtypeSelectPathUsersIdDocumentsCreateProofOfResidence()
    {
        UserDocumentsAddNewPorPageObject::clickOnSubtypeSelect();
    }

    /**
     * @Given /^Click on Subtype option with value "([^"]*)" == path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function clickOnSubtypeOptionWithValuePathUsersIdDocumentsCreateProofOfResidence($arg1)
    {
        UserDocumentsAddNewPorPageObject::clickOnSubtypeOption($arg1);
    }

    /**
     * @Given /^Send file in file input "([^"]*)" == path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function sendFileInFileInputPathUsersIdDocumentsCreateProofOfResidence($arg1)
    {
        UserDocumentsAddNewPorPageObject::sendFileInInput($arg1);
    }

    /**
     * @Given /^Click on \[Save\] button == path: users\/\{id\}\/documents\/create\-proof\-of\-residence ==$/
     */
    public function clickOnSaveButtonPathUsersIdDocumentsCreateProofOfResidence()
    {
        UserDocumentsAddNewPorPageObject::clickOnSaveButton();
    }

    /**
     * @Given /^Click on \[Add new POP\] tab == path: users\/\{id\}\/documents\/\.\.\. ==$/
     */
    public function clickOnAddNewPOPTabPathUsersIdDocuments()
    {
        UserDocumentsTabPageObject::clickOnAddNewPopTab();
    }

    /**
     * @Given /^Check on Add new POP page == path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function checkOnAddNewPOPPagePathUsersIdDocumentsCreateProofOfPayment()
    {
        UserDocumentsAddNewPopPageObject::checkOnPage();
    }

    /**
     * @Given /^Click on Subtype select == path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function clickOnSubtypeSelectPathUsersIdDocumentsCreateProofOfPayment()
    {
        UserDocumentsAddNewPopPageObject::clickOnSubtypeSelect();
    }

    /**
     * @Given /^Click on Subtype option with value "([^"]*)" == path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function clickOnSubtypeOptionWithValuePathUsersIdDocumentsCreateProofOfPayment($arg1)
    {
        UserDocumentsAddNewPopPageObject::clickOnSubtypeOption($arg1);
    }

    /**
     * @Given /^Send file in file input "([^"]*)" == path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function sendFileInFileInputPathUsersIdDocumentsCreateProofOfPayment($arg1)
    {
        UserDocumentsAddNewPopPageObject::sendFileInInput($arg1);
    }

    /**
     * @Given /^Click on \[Save\] button == path: users\/\{id\}\/documents\/create\-proof\-of\-payment ==$/
     */
    public function clickOnSaveButtonPathUsersIdDocumentsCreateProofOfPayment()
    {
        UserDocumentsAddNewPopPageObject::clickOnSaveButton();
    }

}
