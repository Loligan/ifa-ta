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
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\ClearBomSaveConnector;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\NewCable\NewRFCable;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\NewConnector\NewIDCConnector;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\NewCable\NewLanCable;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\NewConnector\NewRFConnector;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Bom\NewConnector\NewRJConnector;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Draft\CableCreateDraft;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Draft\ConnectorCreateDraft;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Draft\CustomDimentionCreateDraft;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\Draft\TextCreateDraft;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CA\Version\Standard\PinoutDetails\ImportXLSPinoutDetails;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CableRawMaterials\GeneralInfo\CreateScenarioCrmGeneralInfo;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CableRawMaterials\GeneralInfo\EditAndRemoveScenarioCrmGeneralInfo;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CableRawMaterials\GeneralInfo\EditScenarioCrmGeneralInfo;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\CableRawMaterials\GeneralInfo\RemoveScenarioCrmGeneralInfo;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\Product\CheckCustomIDCConnectorInOnlyCustomTable;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\Product\CheckCustomLanCableInOnlyCustomTable;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\Product\CheckXLS\CheckXLSCustomIDCConnector;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\Product\CheckProductResultInTable;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\Product\CheckXLS\CheckXLSCustomLanCable;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\Product\HightData;
use TestAutomation\All4BomBundle\Features\Context\src\GeneratorScenario\Tenders\Standard\Create\CreateTenderStandard;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\User\Project\Version\Standart\CreateProjectDefaultPinoutDetailsTab;

class TaGenerateSqliteDbCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ta-core:generate:sqlite-db')
            ->setDescription('...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }

}
