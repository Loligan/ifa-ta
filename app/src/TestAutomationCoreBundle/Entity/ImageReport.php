<?php

namespace TestAutomationCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageReport
 *
 * @ORM\Table(name="image_report")
 * @ORM\Entity(repositoryClass="TestAutomationCoreBundle\Repository\ImageReportRepository")
 */
class ImageReport
{
    private $dataImage;

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
     * @ORM\Column(name="path", type="string", nullable=true)
     */
    private $path;

    /**
     * @var QueueTest
     * @ORM\ManyToOne(targetEntity="TestAutomationCoreBundle\Entity\QueueTest")
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
     * Set path
     *
     * @param string $path
     *
     * @return ImageReport
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
     * Get data
     *
     * @return string
     */
    public function getDataNull()
    {
        $dir = 'media/images/main/' . $this->genPath($this->getId());
        return $dir . $this->getId() . '.jpg';
    }

    public function upload()
    {
        $dir = $this->pathToImage($this->getId());
        $this->path = $this->path . $this->getId() . '.jpg';
        $path = $dir . $this->getId() . '.jpg';
        file_put_contents($path, $this->dataImage);
        $this->setPath($this->path);
    }

    private function pathToImage($id)
    {
        $dir = 'media/images/main/' . $this->genPath($id);
        $this->path = $dir;
        $fullPath = $this->getBaseDirectory() . $dir;
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0777, true);
        }
        return $fullPath;
    }

    private function genPath($id)
    {
        $idString = sprintf('%008d', $id);
        return substr($idString, 0, 2) . '/'
            . substr($idString, 2, 2) . '/'
            . substr($idString, 4, 2) . '/';
    }

    private function getBaseDirectory()
    {
        return __DIR__ . '/../../../web/';
    }

    public function getFullPath()
    {
        return $this->getBaseDirectory() . $this->getPath();
    }

    /**
     * @param mixed $dataImage
     */
    public function setDataImage($dataImage)
    {
        $this->dataImage = $dataImage;
    }


}

