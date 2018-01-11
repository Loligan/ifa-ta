<?php

namespace TestAutomationCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Scenario
 *
 * @ORM\Table(name="scenario")
 * @ORM\Entity(repositoryClass="TestAutomationCoreBundle\Repository\ScenarioRepository")
 */
class Scenario
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
     * @var bool
     *
     * @ORM\Column(name="isSmoke", type="boolean")
     */
    private $isSmoke;

    /**
     * @var string
     *
     * @ORM\Column(name="steps", type="text")
     */
    private $steps;

    /**
     * @var string
     *
     * @ORM\Column(name="scenario", type="text")
     */
    private $scenario;

    /**
     * @var string
     *
     * @ORM\Column(name="tagId", type="string")
     */
    private $tagId;

    /**
     * @var Feature
     * @ORM\ManyToOne(targetEntity="TestAutomationCoreBundle\Entity\Feature")
     * @ORM\JoinColumn(name="featureId", referencedColumnName="id",onDelete="CASCADE")
     */
    private $featureId;

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
     * Set isSmoke
     *
     * @param boolean $isSmoke
     *
     * @return Scenario
     */
    public function setIsSmoke($isSmoke)
    {
        $this->isSmoke = $isSmoke;

        return $this;
    }

    /**
     * Get isSmoke
     *
     * @return bool
     */
    public function getIsSmoke()
    {
        return $this->isSmoke;
    }

    /**
     * Set steps
     *
     * @param string $steps
     *
     * @return Scenario
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
     * Set scenario
     *
     * @param string $scenario
     *
     * @return Scenario
     */
    public function setScenario($scenario)
    {
        $scenario = str_replace("Scenario:","",$scenario);
        $this->scenario = $scenario;

        return $this;
    }

    /**
     * Get scenario
     *
     * @return string
     */
    public function getScenario()
    {
        return $this->scenario;
    }

    /**
     * @return Feature
     */
    public function getFeatureId()
    {
        return $this->featureId;
    }

    /**
     * @param Feature $featureId
     */
    public function setFeatureId($featureId)
    {
        $this->featureId = $featureId;
    }

    /**
     * @return string
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * @param string $tagId
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;
    }

}

