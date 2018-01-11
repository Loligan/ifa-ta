<?php

namespace TestAutomationCoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\FromPdf\CreateCableAssembliesPdf;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\FromPdf\EditAndRemoveCableAssembliesPdf;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\FromPdf\EditCableAssembliesPdf;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\FromPdf\RemoveCableAssembliesPdf;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Standard\CreateCableAssemblies;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Standard\EditAndRemoveCableAssemblies;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Standard\EditCableAssemblies;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Standard\RemoveCableAssemblies;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\FromPdf\CreateFromPdf;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\FromPdf\EditAndRemoveFromPdf;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\FromPdf\EditFromPdf;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\FromPdf\RemoveFromPdf;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\BomCableCreateCreateStandardRevision;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\BomConnectorCreateCreateStandardRevision;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\BomShrinkCreateCreateStandardRevision;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\BomTermsCreateStandardRevision;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\CheckIndexBomBug;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Draft\ImportXLSPinoutDetails;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Draft\CableCreateDraft;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Draft\ConnectorCreateDraft;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Draft\CustomDimentionCreateDraft;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Draft\TextCreateDraft;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CableRawMaterials\GeneralInfo\CreateScenarioCrmGeneralInfo;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CableRawMaterials\GeneralInfo\EditAndRemoveScenarioCrmGeneralInfo;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CableRawMaterials\GeneralInfo\EditScenarioCrmGeneralInfo;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CableRawMaterials\GeneralInfo\RemoveScenarioCrmGeneralInfo;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\Tenders\Standard\Create\CreateTenderStandard;
use TestAutomationCoreBundle\Entity\QueueTest;
use TestAutomationCoreBundle\Entity\Scenario;

class TaSendInRabbitTestsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ta-core:send-in:rabbit')
            ->setDescription('...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       if(!$this->checkQueueRabbitMQ()){
           print "Send messages";
           $ids = $this->getContainer()->get('doctrine')->getRepository('TestAutomationCoreBundle:QueueTest')->findBy(["status"=>QueueTest::STATUS_IN_PROGRESS],null,100);
           foreach ($ids as $id){
               $tag = $id->getScenarioId()->getTagId();
               $this->send(trim($tag));
           }
       }else{
           print "Queue rabbit not be empty";
       }
    }

    private function checkQueueRabbitMQ()
    {
        print 'CHECK RABBITMQ START'.PHP_EOL;
        /** @var \OldSound\RabbitMqBundle\RabbitMq\Producer $rabbit */
        $rabbit = $this->getContainer()->get('old_sound_rabbit_mq.run_test_by_tag_producer');
        $result = $rabbit->getChannel()->queue_declare('run_test_by_tag', false, true, false, false);
        print 'CHECK RABBITMQ FINISH'.PHP_EOL;
        if ($result[1]) {
            return true; //есть задачи в очереди
        }
        return false; //очередь
    }


    private function send($id)
    {
        print 'SEND: '.$id.PHP_EOL;
        /** @var \OldSound\RabbitMqBundle\RabbitMq\Producer $rabbit */
        $rabbit = $this->getContainer()->get('old_sound_rabbit_mq.run_test_by_tag_producer');
        $rabbit->publish($id);
    }
}
