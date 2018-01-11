<?php

namespace TestAutomationCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BehatReport
 *
 * @ORM\Table(name="behat_report")
 * @ORM\Entity(repositoryClass="TestAutomationCoreBundle\Repository\BehatReportRepository")
 */
class BehatReport
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
     * @ORM\Column(name="steps", type="text",nullable=true)
     */
    private $steps;

    /**
     * @var string
     *
     * @ORM\Column(name="pass_step", type="text",nullable=true)
     */
    private $passStep;
    /**
     * @var string
     *
     * @ORM\Column(name="fail_step", type="text",nullable=true)
     */
    private $failStep;



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
     * Set steps
     *
     * @param string $steps
     *
     * @return BehatReport
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * Get steps
     *
     * @return string
     */
    public function getSteps()
    {
        return $this->steps;
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

    /**
     * @return string
     */
    public function getPassStep()
    {
        return $this->passStep;
    }

    /**
     * @param string $passStep
     */
    public function setPassStep($passStep)
    {
        $this->passStep = $passStep;
    }

    /**
     * @return string
     */
    public function getFailStep()
    {
        return $this->failStep;
    }

    /**
     * @param string $failStep
     */
    public function setFailStep($failStep)
    {
        $this->failStep = $failStep;
    }




}

