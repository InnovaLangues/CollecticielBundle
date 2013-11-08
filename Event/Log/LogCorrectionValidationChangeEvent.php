<?php

namespace Icap\DropzoneBundle\Event\Log;

use Claroline\CoreBundle\Event\Log\AbstractLogResourceEvent;
use Claroline\CoreBundle\Event\Log\LogGenericEvent;
use Icap\DropzoneBundle\Entity\Correction;
use Icap\DropzoneBundle\Entity\Drop;
use Icap\DropzoneBundle\Entity\Dropzone;

class LogCorrectionValidationChangeEvent extends AbstractLogResourceEvent implements PotentialEvaluationEndInterface {

    const ACTION = 'resource-icap_dropzone-correction_validation_change';

    private $correction;

    /**
     * @param Dropzone $dropzone
     * @param Drop $drop
     */
    public function __construct(Dropzone $dropzone, Drop $drop, Correction $correction)
    {
        $this->correction = $correction;

        $documentsDetails = array();
        foreach ($drop->getDocuments() as $document) {
            $documentsDetails[] = $document->toJson();
        }

        $details = array(
            'dropzone'  => array(
                'id' => $dropzone->getId(),
            ),
            'drop'  => array(
                'id' => $drop->getId(),
                'documents' => $documentsDetails,
                'owner' => array(
                    'id' => $drop->getUser()->getId(),
                    'lastName' => $drop->getUser()->getLastName(),
                    'firstName' => $drop->getUser()->getFirstName(),
                    'username' => $drop->getUser()->getUsername(),
                )
            ),
            'correction' => $correction->toJson(true)
        );

        parent::__construct($dropzone->getResourceNode(), $details);
    }

    /**
     * @return array
     */
    public static function getRestriction()
    {
        return array(LogGenericEvent::DISPLAYED_WORKSPACE);
    }

    /**
     * @return array
     */
    public function getCorrection()
    {
        return $this->correction;
    }
}