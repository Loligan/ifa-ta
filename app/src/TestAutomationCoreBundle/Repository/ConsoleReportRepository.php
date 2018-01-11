<?php

namespace TestAutomationCoreBundle\Repository;

use TestAutomationCoreBundle\Entity\ConsoleReport;
use TestAutomationCoreBundle\Entity\QueueTest;

/**
 * ConsoleReportRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConsoleReportRepository extends \Doctrine\ORM\EntityRepository
{
    public function updateAfterScenario($id,$output){
//        $this->getEntityManager()->clear();
        $queueTestRep = $this->getEntityManager()->getRepository('TestAutomationCoreBundle:QueueTest');
        $consoleReportRep = $this->getEntityManager()->getRepository('TestAutomationCoreBundle:ConsoleReport');
        $queueTestObject = $queueTestRep->find($id);
        if($queueTestObject!=null){
            $status = $queueTestObject->getStatus();
            if($status==QueueTest::STATUS_FAIL){
                $consoleReportObject = $consoleReportRep->findOneBy(['queueTestId'=>$queueTestObject]);
                if(is_null($consoleReportObject)){
                    $consoleReportObject = new ConsoleReport();
                    $consoleReportObject->setQueueTestId($queueTestObject);
                }
                $consoleReportObject->setOutput($output);
                $this->getEntityManager()->merge($consoleReportObject);
                $this->getEntityManager()->flush();
            }
        }
    }

    public function check($id){
//        $this->getEntityManager()->clear();
        $queueTestRep = $this->getEntityManager()->getRepository('TestAutomationCoreBundle:QueueTest');
        $queueTestObject = $queueTestRep->find($id);
        if($queueTestObject==null){
            return false;
        }else{
            return true;
        }
    }

    public function setInProgressStatus($tagId){

    }

}
