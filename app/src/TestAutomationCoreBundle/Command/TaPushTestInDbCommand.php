<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 9/2/17
 * Time: 4:25 PM
 */

namespace TestAutomationCoreBundle\Command;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TestAutomationCoreBundle\Entity\Feature;
use TestAutomationCoreBundle\Entity\Scenario;
use TestAutomationCoreBundle\src\GenerateScenarioDB\PushScenarioWorker;

class TaPushTestInDbCommand extends ContainerAwareCommand
{
    private $pathFeature;

    protected function configure()
    {
        $this
            ->setName('ta-core:push:test-in-db')
            ->setDescription('...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $pathSave = $this->getContainer()->getParameter('ta.path_save_features');
        $this->pathFeature = __DIR__ . '/../../' . $pathSave;
        $this->push();
    }

    private function push()
    {
        print "DB, rep init".PHP_EOL;
        /**@var Registry $doctrine */
        $doctrine = self::getContainer()->get('doctrine');
        $featureRepository = $doctrine->getRepository('TestAutomationCoreBundle:Feature');
        $scenarioRepository = $doctrine->getRepository('TestAutomationCoreBundle:Scenario');
        print "Get all features".PHP_EOL;
        $featuresSQLite = PushScenarioWorker::getAllFeatures();
        foreach ($featuresSQLite as $feature) {
            print "Push ".$feature['feature'].PHP_EOL;
            $featureObject = null;
            print "Find features in db ".PHP_EOL;
            $featureSearchResult = $featureRepository->findBy(['feature' => $feature['feature']]);
            if (count($featureSearchResult) != 0) {
                print "Features find".PHP_EOL;
                $featureObject = $featureSearchResult[0];
            } else {
                print "Features not find. Create new".PHP_EOL;
                $featureObject = new Feature();
                $featureObject->setFeature($feature['feature']);
                $featureObject->setTags($feature['tags']);
                /**@var Feature $featureObject */
                $featureObject = $doctrine->getManager()->merge($featureObject);
                $doctrine->getManager()->flush();
            }
            $nameFile = $feature['nameTable'] . '.feature';
            $id = $feature['id'];
            print "Get all scenario".PHP_EOL;
            $scnariosSQLite = PushScenarioWorker::getAllScenarioFeatures($id);
            $scenarioDataFile = $feature['feature'];
            foreach ($scnariosSQLite as $scenario) {
                $stepsText = $this->genSteps($feature, $scenario);
                $scenarioSearchResult = $scenarioRepository->findBy(['steps'=>$stepsText]);
                if(count($scenarioSearchResult)>0){
                    continue;
                }
                $scenarioId = $feature['id'].'-'.$scenario['id'];
                $scenarioObject = new Scenario();
                $scenarioObject->setTagId($scenarioId);
                $scenarioObject->setFeatureId($featureObject);
                $scenarioObject->setIsSmoke($scenario['isSmoke']);

                $tagsText = $feature['tags'];
                $tagsScenario = $tagsText." @ID=".$scenarioId;
                $scenarioObject->setSteps($stepsText);
                $scenarioNameText = $this->genScenarioName($feature, $scenario);
                $scenarioDataFile = $scenarioDataFile . PHP_EOL . $tagsScenario . PHP_EOL . $scenarioNameText . PHP_EOL . $stepsText;
                $scenarioObject->setScenario($scenarioNameText);
                $doctrine->getManager()->merge($scenarioObject);
                $doctrine->getManager()->flush();
            }



        }
    }

    public function genScenarioName($feature, $scenario)
    {
        $steps = $feature['scenario'];
        foreach ($scenario as $key => $value) {
            $steps = str_replace('<' . $key . '>', $value, $steps);
        }
        return $steps;
    }

    public function genSteps($feature, $scenario)
    {
        $steps = $feature['steps'];
        foreach ($scenario as $key => $value) {
            $steps = str_replace('<' . $key . '>', $value, $steps);
        }
        return $steps;
    }

}