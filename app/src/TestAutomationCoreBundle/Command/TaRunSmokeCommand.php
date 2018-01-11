<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 4.9.17
 * Time: 16.54
 */

namespace TestAutomationCoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TestAutomationCoreBundle\Entity\QueueTest;

class TaRunSmokeCommand extends ContainerAwareCommand
{
    private $testRange;
    private $defUrl = "http://all4bom.smartdesign.by/";
    protected function configure()
    {
        $this
            ->setName('ta-core:run:smoke')
            ->setDescription('...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->sendSmoke();
    }

    public function sendSmoke(){
        $this->testRange = $this->getContainer()->get('doctrine')->getRepository("TestAutomationCoreBundle:QueueTest")->getNewTestRange();
        $scenarios = $this->getIds();
        foreach ($scenarios as $scenario){
            $tagId = $scenario->getTagId();
            $tagId = trim($tagId);
            $this->getContainer()->get('doctrine')->getRepository("TestAutomationCoreBundle:QueueTest")->createNew($scenario,$this->defUrl,$this->testRange);
            $this->send($tagId);
        }
    }

    /**
     * @return \TestAutomationCoreBundle\Entity\Scenario[]
     */
    private function getIds(){
        $scenarioRep = $this->getContainer()->get('doctrine')->getRepository('TestAutomationCoreBundle:Scenario');
        $scenarios = $scenarioRep->findBy(['isSmoke'=> 1]);
        return $scenarios;
    }

    private function send($id)
    {
        /** @var \OldSound\RabbitMqBundle\RabbitMq\Producer $rabbit */
        $rabbit = $this->getContainer()->get('old_sound_rabbit_mq.run_test_by_tag_producer');
        $rabbit->publish($id);
    }

}