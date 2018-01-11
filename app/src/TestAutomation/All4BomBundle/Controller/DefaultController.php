<?php

namespace TestAutomation\All4BomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TestAutomationCoreBundle\Entity\QueueTest;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $features = $this->getDoctrine()->getEntityManager()
            ->createQuery("SELECT f.id, f.feature, f.tags,(SELECT count(s.id) FROM TestAutomationCoreBundle:Scenario s WHERE s.featureId=f) count_s FROM TestAutomationCoreBundle:Feature f")->getResult();
        return $this->render('TestAutomationAll4BomBundle:Default:index.html.twig', ['features' => $features]);
    }

    public function viewScenariosAction($feature)
    {

        $scenarios = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:Scenario')->createQueryBuilder('s')->
        select('s.id, s.isSmoke, s.tagId')->where('s.featureId=' . $feature)->getQuery()->getResult();
        return $this->render('@TestAutomationAll4Bom/Default/viewScenarios.html.twig', ['scenarios' => $scenarios]);
    }

    public function viewScenarioAction($scenario)
    {
        $scenarioEntity = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:Scenario')->find($scenario);
        if (is_null($scenarioEntity)) {
            return $this->render('@TestAutomationAll4Bom/Default/viewScenario.html.twig', []);
        }
        $lastQueueTest = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->findOneBy(['scenarioId' => $scenarioEntity], ['testRange' => 'DESC'], 1);
        $lastBehatReport = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:BehatReport')->findOneBy(['queueTestId' => $lastQueueTest]);
        $lastConsoleReport = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:ConsoleReport')->findOneBy(['queueTestId' => $lastQueueTest]);
        $lastImageReport = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:ImageReport')->findBy(['queueTestId' => $lastQueueTest]);
        return $this->render('@TestAutomationAll4Bom/Default/viewScenario.html.twig', [
            'scenario' => $scenarioEntity,
            'queueTestData' => $lastQueueTest,
            'behatTestData' => $lastBehatReport,
            'consoleTestData' => $lastConsoleReport,
            'imageTestData' => $lastImageReport,
        ]);
    }

    public function viewReportAction($queue_test)
    {
        $lastQueueTest = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->find($queue_test);
        $scenarioEntity = $lastQueueTest->getScenarioId();
        if (is_null($scenarioEntity)) {
            return $this->render('@TestAutomationAll4Bom/Default/viewScenario.html.twig', []);
        }
        $lastBehatReport = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:BehatReport')->findOneBy(['queueTestId' => $lastQueueTest]);
        $lastConsoleReport = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:ConsoleReport')->findOneBy(['queueTestId' => $lastQueueTest]);
        $lastImageReport = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:ImageReport')->findBy(['queueTestId' => $lastQueueTest]);
        return $this->render('@TestAutomationAll4Bom/Default/viewScenario.html.twig', [
            'scenario' => $scenarioEntity,
            'queueTestData' => $lastQueueTest,
            'behatTestData' => $lastBehatReport,
            'consoleTestData' => $lastConsoleReport,
            'imageTestData' => $lastImageReport,
        ]);
    }

    public function viewScenarioInfoByTestRangeAction($scenario, $testRange)
    {
        $scenarioEntity = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:Scenario')->find(['id' => $scenario]);
        if (is_null($scenarioEntity)) {
            return $this->render('@TestAutomationAll4Bom/Default/viewScenario.html.twig', []);
        }
        $lastQueueTest = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->findOneBy(['scenarioId' => $scenarioEntity, 'testRange' => $testRange]);
        $lastBehatReport = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:BehatReport')->findOneBy(['queueTestId' => $lastQueueTest]);
        $lastConsoleReport = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:ConsoleReport')->findOneBy(['queueTestId' => $lastQueueTest]);
        $lastImageReport = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:ImageReport')->findBy(['queueTestId' => $lastQueueTest]);

        return $this->render('@TestAutomationAll4Bom/Default/viewScenario.html.twig', [
            'scenario' => $scenarioEntity,
            'queueTestData' => $lastQueueTest,
            'behatTestData' => $lastBehatReport,
            'consoleTestData' => $lastConsoleReport,
            'imageTestData' => $lastImageReport,
        ]);
    }

    public function viewLastRangeFailAction()
    {
        $lastRange = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->getLastTestRange();
        $scenarios = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->findBy(['status' => 'FAIL', 'testRange' => $lastRange]);
        return $this->render('@TestAutomationAll4Bom/Default/viewAllFailsLastRange.html.twig', ['scenarios' => $scenarios]);

    }

    public function viewLastRangeResultAction($range)
    {

        $rep = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest');
        if ($range == -1) {
            $range = $rep->getLastTestRange();
        }
        $allRanges = $rep->createQueryBuilder('q')->select('q.testRange')->distinct()->orderBy('q.testRange', 'DESC')->getQuery()->getResult();
        $testRanges = $rep->findBy(['testRange' => $range]);
        return $this->render('@TestAutomationAll4Bom/Default/rangeResult.html.twig', ['range' => $range, 'testRanges' => $testRanges, 'all_ranges' => $allRanges]);
    }

    public function testControllerAction()
    {
        $users = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:User')->findAll();

        return $this->render('@TestAutomationAll4Bom/Default/testController.html.twig', ['users' => $users]);
    }

    public function sendRunAllAction(Request $request)
    {
        $url = $request->request->get("url");
        $runnerTests = $this->get('runner_tests');
        $idsReport = $request->request->get('idsReport');
        $usrRep = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:User');
        $this->getDoctrine()->getEntityManager()->createQueryBuilder()
            ->update('TestAutomationCoreBundle:User','u')
            ->set('u.isActiveReport','?1')
            ->setParameter(1,false)
            ->getQuery()->execute();
        if (is_array($idsReport)) {
            foreach ($idsReport as $idReport) {
                $usr = $usrRep->find($idReport);
                $usr->setIsActiveReport(true);
                $this->getDoctrine()->getManager()->merge($usr);
                $this->getDoctrine()->getManager()->flush();
            }
        }
        $countSend = $runnerTests->sendAll($url);
        return new JsonResponse(['send' => $countSend]);
    }

    public function sendRunSmokeAction(Request $request)
    {
        $url = $request->request->get("url");
        $runnerTests = $this->get('runner_tests');
        $idsReport = $request->request->get('idsReport');
        $usrRep = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:User');
        $this->getDoctrine()->getEntityManager()->createQueryBuilder()
            ->update('TestAutomationCoreBundle:User','u')
            ->set('u.isActiveReport','?1')
            ->setParameter(1,false)
            ->getQuery()->execute();
        if (is_array($idsReport)) {
            foreach ($idsReport as $idReport) {
                $usr = $usrRep->find($idReport);
                $usr->setIsActiveReport(true);
                $this->getDoctrine()->getManager()->merge($usr);
                $this->getDoctrine()->getManager()->flush();
            }
        }
        $countSend = $runnerTests->sendSmoke($url);
        return new JsonResponse(['send' => $countSend]);
    }

    public function stopAllAction()
    {
        $runnerTests = $this->get('runner_tests');
        $runnerTests->stopAll();
        return new JsonResponse(['status' => 'ok']);
    }

    public function pauseAllAction()
    {
        $runnerTests = $this->get('runner_tests');
        $runnerTests->pauseAll();
        return new JsonResponse(['status' => 'ok']);
    }

    public function rerunFailScenariosAction($range)
    {
        $rep = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest');
        if ($range == -1) {
            $range = $rep->getLastTestRange();
        }
        $newRange = $rep->getLastTestRange()+1;
        $scenarios = $rep->findBy(['testRange'=>$range,'status'=>QueueTest::STATUS_FAIL]);
        /**@var QueueTest $scenario*/
        foreach ($scenarios as $scenario){
            $newScenario = new QueueTest();
            $newScenario->setUrl($scenario->getUrl());
            $newScenario->setStatus(QueueTest::STATUS_IN_PROGRESS);
            $scenarioId = $scenario->getScenarioId();
            $newScenario->setScenarioId($scenarioId);
            $newScenario->setTestRange($newRange);
            $this->getDoctrine()->getManager()->persist($newScenario);
            $this->getDoctrine()->getManager()->flush();
        }
        return new JsonResponse([
            'send' => count($scenarios),
        ]);
    }

    public function resumeAllAction()
    {
        $runnerTests = $this->get('runner_tests');
        $runnerTests->continueAll();
        return new JsonResponse(['status' => 'ok']);
    }

    public function lastStatsAction()
    {
        $testRange = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->getLastTestRange();
        $fail = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->createQueryBuilder('e')->select('count(e.id)')->where('e.status=' . "'" . QueueTest::STATUS_FAIL . "'")->andWhere('e.testRange=' . $testRange)->getQuery()->getSingleScalarResult();
        $pass = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->createQueryBuilder('e')->select('count(e.id)')->where('e.status=' . "'" . QueueTest::STATUS_PASS . "'")->andWhere('e.testRange=' . $testRange)->getQuery()->getSingleScalarResult();
        $inProgress = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->createQueryBuilder('e')->select('count(e.id)')->where('e.status=' . "'" . QueueTest::STATUS_IN_PROGRESS . "'")->andWhere('e.testRange=' . $testRange)->getQuery()->getSingleScalarResult();
        return new JsonResponse([
            'fail' => $fail,
            'pass' => $pass,
            'in_progress' => $inProgress,
            'test_range' => $testRange
        ]);
    }

    public function getCountScenariosInQueueAction()
    {
        $result = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->
        createQueryBuilder('e')->
        select('count(e.id)')->where("e.status='IN PROGRESS'")->getQuery()->getSingleScalarResult();
        return new JsonResponse(['in_progress' => $result]);
    }

    public function getCountScenariosPauseAction()
    {
        $result = $this->getDoctrine()->getRepository('TestAutomationCoreBundle:QueueTest')->
        createQueryBuilder('e')->
        select('count(e.id)')->where("e.status='" . QueueTest::STATUS_PAUSE . "'")->getQuery()->getSingleScalarResult();
        return new JsonResponse(['pause' => $result]);
    }

    public function ggAction(Request $request)
    {
        $url = $request->request->get("url");
        var_dump($url);
        return new JsonResponse(['pause' => 1]);
    }


}
