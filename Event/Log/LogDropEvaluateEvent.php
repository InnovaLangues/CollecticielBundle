<?php

namespace Icap\DropzoneBundle\Event\Log;

use Claroline\CoreBundle\Event\Log\AbstractLogResourceEvent;
use Claroline\CoreBundle\Event\Log\LogGenericEvent;
use Icap\DropzoneBundle\Entity\Drop;
use Icap\DropzoneBundle\Entity\Dropzone;

class LogDropEvaluateEvent extends AbstractLogResourceEvent {

    const ACTION = 'resource-icap_dropzone-drop_evaluate';

    /**
     * @param Dropzone $dropzone
     * @param Drop     $drop
     * @param string   $grade
     */
    public function __construct(Dropzone $dropzone, Drop $drop, $grade)
    {
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
            'result' => $grade
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
}