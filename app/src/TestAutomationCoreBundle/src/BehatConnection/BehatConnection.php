<?php

namespace TestAutomationCoreBundle\src\BehatConnection;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use function Symfony\Component\Debug\Tests\testHeader;
use TestAutomationCoreBundle\Entity\BehatReport;
use TestAutomationCoreBundle\Entity\QueueTest;
use TestAutomationCoreBundle\Repository\QueueTestRepository;

class BehatConnection
{
    const NUMBER_MAX_SAVE_SCREEN = 5;

    private $isEnable = true;

    /**@var QueueTest $queueTest */
    private $queueTest;
    /**@var BehatReport $behatReport */
    private $behatReport;
    private $screenshots = [];
    private $steps = '';
    private $failStep = '';
    private $doctrine;

    /**
     * BehatConnection constructor.
     * @param Registry $doctrine
     */
    public function __construct($doctrine)
    {
        if ($this->isEnable) {
            $this->doctrine = $doctrine;
        }
    }


    public function beforeScenario(BeforeScenarioScope $scope,&$url)
    {
        if ($this->isEnable) {
            print "BEFORE SCENARIO";
            $tagsId = $this->getId($scope);
            $this->queueTest = $this->doctrine->getRepository('TestAutomationCoreBundle:QueueTest')->getQueue($tagsId);
            var_dump(is_null($this->queueTest));
            $url=$this->queueTest->getUrl();
            $str =  PHP_EOL.PHP_EOL."!!! TEST QUEUE ID: " . $this->queueTest->getId() . " !!!".PHP_EOL.PHP_EOL;
            print $str;
            return $str;
        }
        return null;
    }

    public function afterScenario(AfterScenarioScope $scope)
    {
        if ($this->isEnable) {
            print "AFTER SCENARIO";
            $isPass = $scope->getTestResult()->isPassed();
            $behatStepsReport =
                '<span class="pass-steps">' . $this->steps . '</span>' .
                PHP_EOL .
                '<span class="fail-steps">' . $this->failStep . '</span>';
            if (count($this->screenshots) > 5) {
                $this->screenshots = array_slice($this->screenshots, -self::NUMBER_MAX_SAVE_SCREEN);
            }
            $this->doctrine
                ->getRepository('TestAutomationCoreBundle:BehatReport')
                ->afterScenarioUpdate($this->queueTest, $isPass, $behatStepsReport, $this->screenshots,$this->steps,$this->failStep);
        }
    }


    /**
     * @param AfterStepScope $scope
     * @var RemoteWebDriver $driver
     */
    public function afterStepScenario(AfterStepScope $scope, $driver)
    {
        if ($this->isEnable) {
            print "AFTER STEP";
            if ($driver != null) {
                $screenshot = $driver->takeScreenshot();
                array_push($this->screenshots, $screenshot);
            }
            $stepText = $scope->getStep()->getText();
            if ($scope->getTestResult()->isPassed()) {
                $this->steps = $this->steps . $stepText . PHP_EOL;
            } else {
                $this->failStep = $stepText;
            }
        }
    }

    public function getId(BeforeScenarioScope $scope)
    {
        if ($this->isEnable) {
            $tags = $scope->getScenario()->getTags();
            $scenarioId = null;
            foreach ($tags as $tag) {
                preg_match('/ID=([0-9]{1,}-[0-9]{1,})/', $tag, $result);
                if (!$result) {
                    continue;
                } else {
                    $scenarioId = $result[1];
                    break;
                }
            }
            return $scenarioId;
        }
    }


    public function disableBehatConnection()
    {
        $this->isEnable = false;
    }
}