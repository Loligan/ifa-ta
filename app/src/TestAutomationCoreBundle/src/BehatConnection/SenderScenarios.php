<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 26.10.17
 * Time: 14.51
 */

namespace TestAutomationCoreBundle\src\BehatConnection;


use Doctrine\Bundle\DoctrineBundle\Registry;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use Symfony\Component\HttpFoundation\Request;
use TestAutomationCoreBundle\Entity\QueueTest;

class SenderScenarios
{
    /**@var Registry $doctrine */
    private $doctrine;
    /**@var Producer $producer */
    private $producer;


    public function __construct(Registry $doctrine, Producer $producer)
    {
        $this->doctrine = $doctrine;
        $this->producer = $producer;
    }

    public function sendSmoke($url)
    {
        $testRange = $this->doctrine->getRepository("TestAutomationCoreBundle:QueueTest")->getNewTestRange();
        $scenarios = $this->getIds(true);
        foreach ($scenarios as $scenario) {
            $qTest = new QueueTest();
            $qTest->setStatus(QueueTest::STATUS_IN_PROGRESS);
            $qTest->setScenarioId($scenario);
            $qTest->setTestRange($testRange);
            $qTest->setUrl($url);
            $this->doctrine->getManager()->merge($qTest);
            $this->doctrine->getManager()->flush();
        }
        return count($scenarios);
    }

    public function sendAll($url)
    {
        $testRange = $this->doctrine->getRepository("TestAutomationCoreBundle:QueueTest")->getNewTestRange();
        $scenarios = $this->getIds(false);
        foreach ($scenarios as $scenario) {
            $qTest = new QueueTest();
            $qTest->setStatus(QueueTest::STATUS_IN_PROGRESS);
            $qTest->setScenarioId($scenario);
            $qTest->setTestRange($testRange);
            $qTest->setUrl($url);
            $this->doctrine->getManager()->merge($qTest);
            $this->doctrine->getManager()->flush();
        }
        return count($scenarios);
    }

    public function stopAll()
    {
        $this->doctrine->getRepository("TestAutomationCoreBundle:QueueTest")->createQueryBuilder('e')->update()->set("e.status", "'" . QueueTest::STATUS_REMOVED . "'")->where("e.status='" . QueueTest::STATUS_IN_PROGRESS . "'")->orWhere("e.status='" . QueueTest::STATUS_PAUSE . "'")->getQuery()->execute();
    }

    public function pauseAll()
    {
        $this->doctrine->getRepository("TestAutomationCoreBundle:QueueTest")->createQueryBuilder('e')->update()->set("e.status", "'" . QueueTest::STATUS_PAUSE . "'")->where("e.status='" . QueueTest::STATUS_IN_PROGRESS . "'")->getQuery()->execute();
    }

    public function continueAll()
    {
        $this->doctrine->getRepository("TestAutomationCoreBundle:QueueTest")->createQueryBuilder('e')->update()->set("e.status", "'" . QueueTest::STATUS_IN_PROGRESS . "'")->where("e.status='" . QueueTest::STATUS_PAUSE . "'")->getQuery()->execute();
    }

    /**
     * @return \TestAutomationCoreBundle\Entity\Scenario[]
     */
    private function getIds($isSmoke = false)
    {
        $scenarioRep = $this->doctrine->getRepository('TestAutomationCoreBundle:Scenario');
        if ($isSmoke == true) {
            $scenarios = $scenarioRep->findBy(['isSmoke' => $isSmoke]);
        } else {
            $scenarios = $scenarioRep->findBy([]);
        }
        return $scenarios;
    }


}