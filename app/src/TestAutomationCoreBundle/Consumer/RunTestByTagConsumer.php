<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 4.9.17
 * Time: 14.31
 */

namespace TestAutomationCoreBundle\Consumer;


use Doctrine\Bundle\DoctrineBundle\Registry;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TestAutomationCoreBundle\Entity\QueueTest;
use TestAutomationCoreBundle\Entity\Scenario;
use TestAutomationCoreBundle\Repository\QueueTestRepository;

class RunTestByTagConsumer extends Controller implements ConsumerInterface
{
    private $doctrine;
    private $em;
    private $pathSave;
    private $pathSaveFeatureFile;

    /**
     * RunTestByTagConsumer constructor.
     */
    public function __construct(Registry $doctrine, $pathSave)
    {
        $this->doctrine = $doctrine;
        $this->pathSave = $pathSave;
        $this->em = $doctrine->getManager();
    }

    /**
     * @param AMQPMessage $msg The message
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        print "[" . date("H:i:s") . "]" . "///=======================///" . PHP_EOL;
        $body = $msg->getBody();
        $body = trim($body);
        print "Body: " . $body . PHP_EOL;
        $idTag = "ID=" . $body;
        print "Make file from id: " . $idTag . PHP_EOL;
        $res = $this->makeFileScenario($idTag);
        if (is_null($res)) {
            return;
        }
        $dir = __DIR__ . "/../../../vendor/bin/behat";
        print "Shell exec" . PHP_EOL;
        $consoleOutput = shell_exec('php ' . $dir . ' --tags="' . $idTag . '"');
        print "File unset" . PHP_EOL;
        unlink($this->pathSaveFeatureFile);
        var_dump('php ' . $dir . ' --tags="' . $idTag . '"');
        print "PREG MARCH" . PHP_EOL;
        preg_match("/!!! TEST QUEUE ID:.*([0-9]*) !!!/U", $consoleOutput, $result);
        var_dump($result);
        $id = null;
        print "FOREACH" . PHP_EOL;
        print "Parse result" . PHP_EOL;
        foreach ($result as $item) {
            if (ctype_digit($item)) {
                $id = (int)$item;
                break;
            }
        }
        var_dump($id);


        if (strstr($consoleOutput, 'Facebook\WebDriver\Exception\NoSuchDriverException') != false) {
            $this->doctrine->getRepository('TestAutomationCoreBundle:QueueTestRepository')->getQueueById($id);
            $this->send($body);
        }


        if ($id != null) {
            print "Update after scenario" . PHP_EOL;
            $this->doctrine->getRepository('TestAutomationCoreBundle:ConsoleReport')->updateAfterScenario($id, $consoleOutput);
        } else {
            print 'ID NOT FOUND  "' . $body . '"' . PHP_EOL;
        }

    }

    private function makeFileScenario($id)
    {

        /**@var Scenario $scenarioObject */
        $scenarioObject = $this->doctrine->getRepository("TestAutomationCoreBundle:Scenario")->getScenarioByTagId($id);
        if (is_null($scenarioObject)) {
            print 'SCENARIO OBJECT IS NULL'.PHP_EOL;
            return null;
        }
        $idEntity = $scenarioObject->getId();

        $steps = $scenarioObject->getSteps();
        $scenario = $scenarioObject->getScenario();
        $feature = $scenarioObject->getFeatureId()->getFeature();
        $tags = $scenarioObject->getFeatureId()->getTags() . " @" . $id;

        $scenarioText = "Feature: " . $feature . PHP_EOL . PHP_EOL .
            $tags . PHP_EOL .
            "Scenario: " . $scenario . PHP_EOL . $steps;
        $this->pathSaveFeatureFile = __DIR__ . '/../../' . $this->pathSave . "/F" . $idEntity . ".feature";
        print "FILE GEN PUT CONTENT: " . $this->pathSaveFeatureFile . PHP_EOL;
        file_put_contents($this->pathSaveFeatureFile, $scenarioText);
        return true;
    }


    private function send($id)
    {
        /** @var \OldSound\RabbitMqBundle\RabbitMq\Producer $rabbit */
        $rabbit = $this->getContainer()->get('old_sound_rabbit_mq.run_test_by_tag_producer');
        $rabbit->publish($id);
    }
}