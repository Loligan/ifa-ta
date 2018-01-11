<?php

namespace TestAutomationCoreBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TestAutomationCoreBundle\Entity\QueueTest;

class TaSendRerunFailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ta:rerun')
            ->setDescription('<test range> <start id> <finish id>')
            ->addArgument('testRange', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('startId', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('finId', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $testRange = $input->getArgument('testRange');
        $startId = $input->getArgument('startId');
        $finId = $input->getArgument('finId');
        /**@var Registry $doctrine*/
        $doctrine = $this->getContainer()->get('doctrine');
        /**@var QueueTest[] $tests*/
        $tests = $doctrine->getRepository('TestAutomationCoreBundle:QueueTest')->getRerunId($testRange,$startId,$finId);
        if(count($tests)>0){
            $testRange = $this->getContainer()->get('doctrine')->getRepository("TestAutomationCoreBundle:QueueTest")->getNewTestRange();
        }

        foreach ($tests as $test){
            $defUrl = $test->getUrl();
            $scenario = $test->getScenarioId();
            $tagId = $scenario->getTagId();
            $tagId = trim($tagId);
            $this->getContainer()->get('doctrine')->getRepository("TestAutomationCoreBundle:QueueTest")->createNew($scenario,$defUrl,$testRange);
            $this->send($tagId);

        }
    }

    private function send($id)
    {
        /** @var \OldSound\RabbitMqBundle\RabbitMq\Producer $rabbit */
        $rabbit = $this->getContainer()->get('old_sound_rabbit_mq.run_test_by_tag_producer');
        $rabbit->publish($id);
    }

}
