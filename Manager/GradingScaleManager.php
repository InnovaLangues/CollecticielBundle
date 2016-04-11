<?php
namespace Innova\CollecticielBundle\Manager;

use Claroline\CoreBundle\Entity\Workspace\Workspace;
use Claroline\CoreBundle\Manager\MaskManager;
use Claroline\CoreBundle\Entity\User;
use Innova\CollecticielBundle\Entity\Dropzone;
use Innova\CollecticielBundle\Event\Log\LogCorrectionUpdateEvent;
use JMS\DiExtraBundle\Annotation as DI;

use Innova\CollecticielBundle\Entity\Correction;
use Innova\CollecticielBundle\Entity\Drop;
use Innova\CollecticielBundle\Event\Log\LogDropEndEvent;
use Innova\CollecticielBundle\Event\Log\LogDropStartEvent;
use Innova\CollecticielBundle\Event\Log\LogDropReportEvent;
use Innova\CollecticielBundle\Form\CorrectionReportType;
use Innova\CollecticielBundle\Form\DropType;
use Innova\CollecticielBundle\Form\DocumentType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Claroline\CoreBundle\Library\Resource\ResourceCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Innova\CollecticielBundle\Entity\GradingScale;
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

        $countCorrection = count($tab);


$keys = array_keys($tab);
        echo $countCorrection;

  foreach (array_keys($tab) as $key) {
echo "<br />--------------<br />";
echo $key;
echo $tab[$key]["scaleName"] . "-";
echo $tab[$key]["id"] . "-";
echo "<br />--------------<br />";
}
echo "<br />--------------<br />";
        for ($indice = 0; $indice<$countCorrection; $indice++) {
}
die();
        for ($indice = 0; $indice<$countCorrection; $indice++) {
            echo "<br />";
            echo $indice . "-";
            echo $tab[$indice]["scaleName"] . "-";

            echo $tab[$indice]["scaleName"] . "-";
            echo $tab[$indice]["id"] . "-";


// echo "<br />OK";
// if (!isset($tab[$indice]["id"])) {
//             echo $tab[$indice]["id"] . "-";
// }
// else {
// echo "<br />KO";
// }


            if (!isset($tab[$indice]["id"])) {
//                $gradingScale = $this->gradingScaleRepo->find($tab[$indice]["id"]);
//                if (count($gradingScale) == 0) {
                    echo "<br />pas trouvé";
                    echo "<br />" . $tab[$indice]["scaleName"];
//                    $this->insertGradingScale($tab[$indice]["scaleName"], $dropzone);
            }
            else
            {
                $gradingScale = $this->gradingScaleRepo->find($tab[$indice]["id"]);
                    echo "<br />trouvé";
                    echo "<br />" . $gradingScale->getScaleName();
                    echo "<br />" . $tab[$indice]["scaleName"];
//                    if ($tab[$indice]["scaleName"] != $gradingScale->getScaleName()) {
                        $this->updateGradingScale($tab[$indice]["scaleName"], $gradingScale);
//                    }
            }

        }

/*
        $gradingScales = $this->resourceNodeRepo->findBy(array('dropzone' => $dropzone->getId()));

        foreach ($gradingScales as $gradingScale) {
            $resourceNode->setPublished($published);
            $this->em->persist($resourceNode);
        }
        $this->em->flush();
*/
        return true;
    }

    /**
     *  To insert gradingScale table
     *
     * @param scaleName
     * @param Dropzone
     * @return boolean
     */
    public function insertGradingScale($scaleName, Dropzone $dropzone)
    {


echo "<br />";
echo "<br />";
echo $dropzone->getId() . "---" . $dropzone->getManualState();
echo "<br />";
echo "<br />";

        // Add a new grading Scale
        $gradingScale = new GradingScale();
        $gradingScale->setScaleName($scaleName);
echo $gradingScale->getScaleName();
        $gradingScale->setDropzone($dropzone);
//echo $gradingScale->getDropzone();
//die();

        $this->em->persist($gradingScale);
        $this->em->flush();
        $this->em->refresh($gradingScale);

    }

    /**
     *  To update gradingScale table
     *
     * @param scaleName
     * @param Dropzone
     * @return boolean
     */
    public function updateGradingScale($scaleName, GradingScale $gradingScale)
    {

echo "<br />suis dans Update";
        echo "<br />scaleName : " . $scaleName;
        echo "<br />getScaleName :" . $gradingScale->getScaleName();
        // update an existing grading Scale
        $gradingScale->setScaleName($scaleName);

        $this->em->persist($gradingScale);
        $this->em->flush();

    }

}
