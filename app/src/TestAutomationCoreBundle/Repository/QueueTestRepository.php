<?php

namespace TestAutomationCoreBundle\Repository;

use TestAutomationCoreBundle\Entity\BehatReport;
use TestAutomationCoreBundle\Entity\QueueTest;
use TestAutomationCoreBundle\Entity\Scenario;

/**
 * QueueTestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QueueTestRepository extends \Doctrine\ORM\EntityRepository
{

    public function getQueueById($id){
        /**@var QueueTest $queueTestObject*/
        $queueTestObject = $this->find($id);
        if($queueTestObject!=null){
            $queueTestObject->setStatus(QueueTest::STATUS_IN_PROGRESS);
        }else{
            return null;
        }
    }


    public function getQueue($idTagText)
    {
        $tagId = trim(
            str_replace('@ID=', '', $idTagText)
        );
        $scenarioRepository = $this->getEntityManager()->getRepository('TestAutomationCoreBundle:Scenario');
        $resultSearchScenario = $scenarioRepository->findBy(['tagId' => $tagId]);
        if (count($resultSearchScenario) == 0) {
            throw new \Exception('Scenario with tag ' . $idTagText . 'not found');
        }
        $scenarioObject = $resultSearchScenario[count($resultSearchScenario) - 1];

        $queueSearchResult = $this->findBy([
            'status' => QueueTest::STATUS_IN_PROGRESS,
            'scenarioId' => $scenarioObject
        ]);

        if (count($queueSearchResult) == 0 || is_null($queueSearchResult)) {
            throw new \Exception("Test queue with id tag " . $idTagText . ' an status' . QueueTest::STATUS_IN_PROGRESS . ' not found');
        }
        if (is_array($queueSearchResult)) {
            $queueObject = $queueSearchResult[0];
        } else {
            $queueObject = $queueSearchResult;
        }
        return $queueObject;
    }

    public function createNew(Scenario $scenario, $url, $testRange)
    {
        $queueTestObject = new QueueTest();
        $queueTestObject->setStatus(QueueTest::STATUS_IN_PROGRESS);
        $queueTestObject->setUrl($url);
        $queueTestObject->setTestRange($testRange);
        $queueTestObject->setScenarioId($scenario);
        $this->getEntityManager()->merge($queueTestObject);
        $this->getEntityManager()->flush();

    }


    public function getNewTestRange()
    {
        $resultTestRangeSearch = $this->createQueryBuilder('q')->select('MAX(q.testRange)')->getQuery()->getOneOrNullResult();
        if ($resultTestRangeSearch == null) {
            $testRange = 0;
        } else {
            $testRange = $resultTestRangeSearch[1];
        }

        $testRange++;
        return $testRange;
    }


    public function getLastTestRange()
    {
        $resultTestRangeSearch = $this->createQueryBuilder('q')->select('MAX(q.testRange)')->getQuery()->getOneOrNullResult();
        if ($resultTestRangeSearch == null) {
            return null;
        } else {
            $testRange = $resultTestRangeSearch[1];
        }
        return $testRange;
    }

    public function getRerunId($testRange, $startId, $finId)
    {
        if (is_null($testRange)) {
            $testRange = $this->getLastTestRange();
        }
        if (is_null($startId)) {
            $result = $this->findBy(['testRange' => $testRange,'status'=>QueueTest::STATUS_FAIL]);
        }else{
            $query = $this->createQueryBuilder('b')->select('b')->where('b.id>='.$startId)->andWhere("b.status='".QueueTest::STATUS_FAIL."'");
            if(!is_null($finId)){
                $query->andWhere('b.id<='.$finId);
            }
            $result = $query->getQuery()->getResult();
        }
        return $result;
    }


}