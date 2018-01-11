<?php

namespace TestAutomationCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QueueTest
 *
 * @ORM\Table(name="queue_test")
 * @ORM\Entity(repositoryClass="TestAutomationCoreBundle\Repository\QueueTestRepository")
 */
class QueueTest
{
    const STATUS_IN_PROGRESS = 'IN PROGRESS';
    const STATUS_FAIL = 'FAIL';
    const STATUS_PASS = 'PASS';
    const STATUS_REMOVED = 'REMOVED';
    const STATUS_PAUSE = 'PAUSE';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="testRange", type="integer")
     */
    private $testRange;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var Scenario
     * @ORM\ManyToOne(targetEntity="TestAutomationCoreBundle\Entity\Scenario")
     * @ORM\JoinColumn(name="scenario_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $scenarioId;

    /**
     * @var ConsoleReport
     * @ORM\OneToMany(targetEntity="TestAutomationCoreBundle\Entity\ConsoleReport", mappedBy="queueTestId")
     */
    private $consoleReport;

    /**
     * @var BehatReport
     * @ORM\OneToOne(targetEntity="TestAutomationCoreBundle\Entity\BehatReport", mappedBy="queueTestId")
     */
    private $behatReport;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return QueueTest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set testRange
     *
     * @param integer $testRange
     *
     * @return QueueTest
     */
    public function setTestRange($testRange)
    {
        $this->testRange = $testRange;

        return $this;
    }

    /**
     * Get testRange
     *
     * @return int
     */
    public function getTestRange()
    {
        return $this->testRange;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return QueueTest
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return Scenario
     */
    public function getScenarioId()
    {
        return $this->scenarioId;
    }

    /**
     * @param Scenario $scenarioId
     */
    public function setScenarioId($scenarioId)
    {
        $this->scenarioId = $scenarioId;
    }

    /**
     * @return ConsoleReport
     */
    public function getConsoleReport()
    {
        return $this->consoleReport;
    }

    /**
     * @param ConsoleReport $consoleReport
     */
    public function setConsoleReport($consoleReport)
    {
        $this->consoleReport = $consoleReport;
    }

    /**
     * @return BehatReport
     */
    public function getBehatReport()
    {
        return $this->behatReport;
    }



}

