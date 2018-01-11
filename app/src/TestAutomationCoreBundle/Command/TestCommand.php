<?php
/**
 * Created by PhpStorm.
 * User: meldon
 * Date: 7.9.17
 * Time: 17.02
 */

namespace TestAutomationCoreBundle\Command;


use Exception;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet;
use PHPExcel_Writer_Excel2007;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TestAutomation\All4BomBundle\Features\Context\src\PageObject\User\Product\ProductPage;
use TestAutomationCoreBundle\Entity\Scenario;

class TestCommand extends ContainerAwareCommand
{

    const ALPHABET =  ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    /**@var PHPExcel_Worksheet $list*/
    private $list;
    private $excel;

    private static $downloadFile;
    protected function configure()
    {
        $this
            ->setName('gg')
            ->setDescription('...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ProductPage::downloadFileByExportButton();
        die();

//        $result = $this->makeFileScenario("Part number", "T");
//        var_dump($result);
//        $result = $this->makeFileScenario("Indoor/Outdoor", "Indoor");
//        var_dump($result);
//        $result = $this->makeFileScenario("Datasheet", "http://11");
//        unlink('gen-new.xls');
        $this->createXls();
        $this->headAdd('1','P1');
        $this->headAdd('2','C1');
        $this->headAdd('3','P2');

        $this->bodyAdd(1,1,'1');
        $this->bodyAdd(1,2,'ggg');
        $this->bodyAdd(1,3,'1');

        $this->bodyAdd(2,1,'2');
        $this->bodyAdd(2,2,'fff');
        $this->bodyAdd(2,3,'2');
        $this->saveXls('gen-new.xls');
    }

    public function createXls(){
        $this->excel= new PHPExcel();
        $this->list= $this->excel->getSheet();
        $this->list->setCellValue('A1', 'Schema');
    }

    public function headAdd($column,$value){
        $column--;
        $this->list->setCellValue(self::ALPHABET[$column]."2", $value);
    }

    public function bodyAdd($column,$row,$value){
        $row--;
        $column+=2;
        var_dump(self::ALPHABET[$row].$column);
        $this->list->setCellValue(self::ALPHABET[$row].$column, $value);
    }

    public function saveXls($filePath){
        $writer = new PHPExcel_Writer_Excel2007($this->excel);
        $writer->save($filePath);
    }

}