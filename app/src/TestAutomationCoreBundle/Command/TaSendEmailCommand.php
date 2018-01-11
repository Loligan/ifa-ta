<?php

namespace TestAutomationCoreBundle\Command;

use Mailgun\Mailgun;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TestAutomationCoreBundle\Entity\QueueTest;

class TaSendEmailCommand extends ContainerAwareCommand
{
    private $data = [];
    private $html = null;
    private $title = null;
    private $host = "http://51.15.39.45";
    protected function configure()
    {
        $this
            ->setName('ta-core:email:send')
            ->setDescription('...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getResultLastTestRange();
        $doctrine = $this->getContainer()->get('doctrine');
        $users = $doctrine->getRepository('TestAutomationCoreBundle:User')->findBy(['isActiveReport' => true]);
        if (count($users) > 0) {

            $this->genHtml();
            $this->genTitle();
            foreach ($users as $user) {
                $this->sendEmail($user->getEmail());
                $user->setLastDateReport(new \DateTime());
                if ($this->data['inProgress'] == 0) {
                    $user->setIsActiveReport(false);
                }
                $doctrine->getManager()->merge($user);
                $doctrine->getManager()->flush();
            }
        }

    }


    private function getResultLastTestRange()
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $repQT = $doctrine->getRepository('TestAutomationCoreBundle:QueueTest');
        $lastTr = $repQT->getLastTestRange();
        $total = $repQT->createQueryBuilder('e')->select('count(e.id)')->where('e.testRange=' . $lastTr)->getQuery()->getSingleScalarResult();
        $fail = $repQT->createQueryBuilder('e')->select('count(e.id)')->where('e.testRange=' . $lastTr)->andWhere("e.status='" . QueueTest::STATUS_FAIL . "'")->getQuery()->getSingleScalarResult();
        $pass = $repQT->createQueryBuilder('e')->select('count(e.id)')->where('e.testRange=' . $lastTr)->andWhere("e.status='" . QueueTest::STATUS_PASS . "'")->getQuery()->getSingleScalarResult();
        $hostTest = $repQT->createQueryBuilder('e')->select('e.url')->where('e.testRange=' . $lastTr)->setMaxResults(1)->getQuery()->getResult();
        $inProgress = $repQT->createQueryBuilder('e')->select('count(e.id)')->where('e.testRange=' . $lastTr)->andWhere("e.status='" . QueueTest::STATUS_IN_PROGRESS . "'")->getQuery()->getSingleScalarResult();

        $this->data['fail'] = $fail;
        $this->data['pass'] = $pass;
        $this->data['inProgress'] = $inProgress;
        $this->data['total'] = $total;
        $this->data['testRange'] = $lastTr;
        $this->data['url'] = $hostTest[0]['url'];
    }

    private function genHtml()
    {;
        $htmlSource = file_get_contents(__DIR__ . '/../Resources/source_email/beefree-u6eodwycup.html');
        $htmlSource = str_replace('{{HOST_MY}}', $this->host, $htmlSource);
        $htmlSource = str_replace('{{IN_PROGRESS}}', $this->data['inProgress'], $htmlSource);
        $htmlSource = str_replace('{{TEST_RANGE}}', $this->data['testRange'], $htmlSource);
        $htmlSource = str_replace('{{PASS}}', $this->data['pass'], $htmlSource);
        $htmlSource = str_replace('{{FAIL}}', $this->data['fail'], $htmlSource);
        $htmlSource = str_replace('{{TOTAL}}', $this->data['total'], $htmlSource);
        $htmlSource = str_replace('{{URL}}', $this->data['url'], $htmlSource);
        $this->html = $htmlSource;
    }

    private function genTitle()
    {

        $this->title = "[TA][ALL4BOM][" . $this->data['url'] . "] ..::Report test result::..  " .
            "Test range: №" . $this->data['testRange'] .
            " Fail: " . $this->data['fail'] .
            " Pass: " . $this->data['pass'] .
            " In progress: " . $this->data['inProgress'];
    }


    private function sendEmail($email)
    {
        print 'SEND: '.$email.PHP_EOL;
        $apiKey = 'key-f29364b3f4c93a480cbd1e692ee15bf6';
        $domain = "sandbox28c24425934846ccbefa6fbc14cd6863.mailgun.org";
        $from = 'Mailgun Sandbox <postmaster@sandbox28c24425934846ccbefa6fbc14cd6863.mailgun.org>';


        $mgClient = new Mailgun($apiKey);
        try {
            $mgClient->sendMessage($domain,
                array('from' => 'Mailgun Sandbox <postmaster@sandbox28c24425934846ccbefa6fbc14cd6863.mailgun.org>',
                    'subject' => $this->title,
                    'to' => $email,
                    'html' => $this->html));
            print 'Send: '.$email.PHP_EOL;
        } catch (\Exception $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }
}