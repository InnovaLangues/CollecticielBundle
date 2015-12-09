<?php
/**
 * Created by : VINCENT Eric
 * Date: 10/05/2015
*/

namespace Innova\CollecticielBundle\Entity;

use Claroline\CoreBundle\Entity\Resource\ResourceNode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Innova\CollecticielBundle\Repository\ReturnReceiptTypeRepository")
 * @ORM\Table(name="innova_collecticielbundle_return_recept_type")
 */
class ReturnReceiptType {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="type_name", type="text", nullable=false)
     */
    protected $typeName;

    /**
     * Lien avec la table ReturnReceipt
    */
    /**
     * @ORM\OneToMany(
     *      targetEntity="Innova\CollecticielBundle\Entity\ReturnReceipt",
     *      mappedBy="returnReceiptType"
     * )
     */
    protected $returnreceipts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->returnreceipts = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set typeName
     *
     * @param string $typeName
     *
     * @return ReturnReceiptType
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;

        return $this;
    }

    /**
     * Get typeName
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Add returnreceipt
     *
     * @param \Innova\CollecticielBundle\Entity\ReturnReceipt $returnreceipt
     *
     * @return ReturnReceiptType
     */
    public function addReturnreceipt(\Innova\CollecticielBundle\Entity\ReturnReceipt $returnreceipt)
    {
        $this->returnreceipts[] = $returnreceipt;

        return $this;
    }

    /**
     * Remove returnreceipt
     *
     * @param \Innova\CollecticielBundle\Entity\ReturnReceipt $returnreceipt
     */
    public function removeReturnreceipt(\Innova\CollecticielBundle\Entity\ReturnReceipt $returnreceipt)
    {
        $this->returnreceipts->removeElement($returnreceipt);
    }

    /**
     * Get returnreceipts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReturnreceipts()
    {
        return $this->returnreceipts;
    }
}
