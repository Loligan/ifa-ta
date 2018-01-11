<?php

namespace TestAutomationCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConsoleReport
 *
 * @ORM\Table(name="console_report")
 * @ORM\Entity(repositoryClass="TestAutomationCoreBundle\Repository\ConsoleReportRepository")
 */
class ConsoleReport
{
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
     * @ORM\Column(name="output", type="text", nullable=true)
     */
    private $output;
    /**
     * @var QueueTest
     * @ORM\OneToOne(targetEntity="TestAutomationCoreBundle\Entity\QueueTest")
     * @ORM\JoinColumn(name="queue_test_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $queueTestId;

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
     * Set output
     *
     * @param string $output
     *
     * @return ConsoleReport
     */
    public function setOutput($output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Get output
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return QueueTest
     */
    public function getQueueTestId()
    {
        return $this->queueTestId;
    }

    /**
     * @param QueueTest $queueTestId
     */
    public function setQueueTestId($queueTestId)
    {
        $this->queueTestId = $queueTestId;
    }


}

