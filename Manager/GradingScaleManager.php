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
    public function updateGradingScales($tab, Dropzone $dropzone)
    {

        $countCorrection = count($tab)-1;

        echo $countCorrection;

        for ($indice = 0; $indice<=$countCorrection; $indice++) {
            var_dump($indice);
            var_dump($tab[$indice]["scaleName"]);
            var_dump($tab[$indice]["id"]);
            $gradingScales = $this->gradingScaleRepo->findBy(
                array(
                'dropzone' => $dropzone->getId(),
                'scaleName' => $tab[$indice]["scaleName"]
                )
            );
            if (count($gradingScales) == 0) {
                echo "<br />pas trouvé";
                var_dump($tab[$indice]["scaleName"]);
                $this->insertGradingScale($tab[$indice]["scaleName"], $dropzone);
            }
            else {
                echo "<br />trouvé";
                var_dump($tab[$indice]["scaleName"]);
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
     *  To update gradingScale table
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

}
