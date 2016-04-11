<?php
/**
 * Created by : Eric VINCENT
 * Date: 04/2016
 */

namespace Innova\CollecticielBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Innova\CollecticielBundle\Repository\GradingScaleRepository")
 * @ORM\Table(name="innova_collecticielbundle_grading_scale")
 */
class GradingScale {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="scale_name", type="text", nullable=false)
     */
    protected $scaleName;

    /**
     * Lien avec la table Dropzone
    */
    /**
     * @ORM\ManyToOne(
     *      targetEntity="Innova\CollecticielBundle\Entity\Dropzone",
     *      inversedBy="gradingScales"
     * )
     * @ORM\JoinColumn(name="dropzone_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $dropzone;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set scaleName
     *
     * @param string $scaleName
     *
     * @return GradingScale
     */
    public function setScaleName($scaleName)
    {
        $this->scaleName = $scaleName;

        return $this;
    }

    /**
     * Get scaleName
     *
     * @return string
     */
    public function getScaleName()
    {
        return $this->scaleName;
    }

    /**
     * Set dropzone
     *
     * @param \Innova\CollecticielBundle\Entity\Dropzone $dropzone
     *
     * @return GradingScale
     */
    public function setDropzone(\Innova\CollecticielBundle\Entity\Dropzone $dropzone)
    {
        $this->dropzone = $dropzone;

        return $this;
    }

    /**
     * Get dropzone
     *
     * @return \Innova\CollecticielBundle\Entity\Dropzone
     */
    public function getDropzone()
    {
        return $this->dropzone;
    }
}
