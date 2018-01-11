<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 4.9.17
 * Time: 16.01
 */

namespace TestAutomationCoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TestAutomationCoreBundle\Entity\QueueTest;
use TestAutomationCoreBundle\Repository\QueueTestRepository;

class TaRunTestByTagCommand extends ContainerAwareCommand
{
    private $pathFeature;


    private $em;
    private $doctrine;

    protected function configure()
    {
        $this
            ->setName('ta-core:run:test')
            ->setDescription('...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->doctrine = $this->getContainer()->get('doctrine');
        $arr = ["id"=>"1-85"];

        $idTag = "ID=".$arr["id"];
        $dir = __DIR__ . "/../../../vendor/bin/behat";
        $consoleOutput = shell_exec('php ' . $dir . ' --tags="' . $idTag . '"');
        print "PREG MARCH".PHP_EOL;
        print $consoleOutput;
        preg_match("/!!! TEST QUEUE ID:.*([0-9]*) !!!/U", $consoleOutput, $result);
        $id = null;
        print "FOREACH".PHP_EOL;
        foreach ($result as $item) {
            if (ctype_digit($item)) {
                $id = (int)$item;
                break;
            }
        }

        if ($id != null) {
            $this->doctrine->getRepository('TestAutomationCoreBundle:ConsoleReport')->updateAfterScenario($id,$consoleOutput);
        }else{
            print 'ID NOT FOUND'.PHP_EOL;
        }


    }


}