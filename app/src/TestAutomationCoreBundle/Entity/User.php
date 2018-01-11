<?php

namespace TestAutomationCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;



    /**
     * @var string
     * @ORM\Column(name="last_date_report", type="date", nullable=true)
     */
    private $lastDateReport;

    /**
     * @var string
     * @ORM\Column(name="is_active_report", type="boolean", nullable=true)
     */
    private $isActiveReport;



    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @return mixed
     */
    public function getLastDateReport()
    {
        return $this->lastDateReport;
    }

    /**
     * @param mixed $lastDateReport
     */
    public function setLastDateReport($lastDateReport)
    {
        $this->lastDateReport = $lastDateReport;
    }

    /**
     * @return string
     */
    public function getisActiveReport()
    {
        return $this->isActiveReport;
    }

    /**
     * @param string $isActiveReport
     */
    public function setIsActiveReport($isActiveReport)
    {
        $this->isActiveReport = $isActiveReport;
    }


}