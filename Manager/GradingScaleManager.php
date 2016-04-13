<?php

namespace Innova\CollecticielBundle\Manager;

use JMS\DiExtraBundle\Annotation as DI;
use Innova\CollecticielBundle\Entity\GradingScale;
use Innova\CollecticielBundle\Entity\Dropzone;

/**
 * @DI\Service("innova.manager.gradingscale_manager")
 */
class GradingScaleManager
{

    private $container;
    private $em;
    private $gradingScaleRepo;

    /**
     * @DI\InjectParams({
     *     "container"  = @DI\Inject("service_container"),
     *     "em"         = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct($container, $em)
    {
        $this->container = $container;
        $this->em = $em;
        $this->gradingScaleRepo = $this->em->getRepository('InnovaCollecticielBundle:GradingScale');
    }

    /**
     *  To update gradingScale table
     *
     * @param tab
     * @return boolean
     */
    public function manageGradingScales($tab, Dropzone $dropzone)
    {

        foreach (array_keys($tab) as $key) {
            if (empty($tab[$key]["id"])) {
                echo "<br /> Pas trouvé ";
                echo "<br />" . $key;
                $gradingScaleData = $this->insertGradingScale($tab[$key]["scaleName"], $dropzone);
            }
            else
            {
                echo "<br /> Trouvé" ;
                echo "<br />" . $tab[$key]["id"];
                echo "<br />" . $tab[$key]["scaleName"];
                $gradingScale = $this->gradingScaleRepo->find($tab[$key]["id"]);
                $gradingScaleData = $this->updateGradingScale($tab[$key]["scaleName"], $gradingScale);
            }

            //$em->persist($dropzone);
            $this->em->persist($gradingScaleData);
        }

echo "<br />--------------<br />";

        $this->em->flush();

        return true;
    }

    /**
     *  To insert gradingScale table
     *
     * @param scaleName
     * @param Dropzone
     * @return gradingScale
     */
    public function insertGradingScale($scaleName, Dropzone $dropzone)
    {
echo "<br />";
echo "--- Dropzone : " . $dropzone->getId() . "---";
echo "<br />";

        // Add a new grading Scale
        $gradingScale = new GradingScale();
        $gradingScale->setScaleName($scaleName);
        $gradingScale->setDropzone($dropzone);

        return $gradingScale;

    }

    /**
     *  To update gradingScale table
     *
     * @param scaleName
     * @param Dropzone
     * @return gradingScale
     */
    public function updateGradingScale($scaleName, GradingScale $gradingScale)
    {
        // update an existing grading Scale
        $gradingScale->setScaleName($scaleName);

        return $gradingScale;
    }

}
