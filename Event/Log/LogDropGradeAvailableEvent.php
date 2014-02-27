<?php

namespace Icap\DropzoneBundle\Event\Log;

use Claroline\CoreBundle\Event\Log\AbstractLogResourceEvent;
use Claroline\CoreBundle\Event\Log\LogGenericEvent;
use Icap\NotificationBundle\Entity\NotifiableInterface;
use Icap\DropzoneBundle\Entity\Document;
use Icap\DropzoneBundle\Entity\Drop;
use Icap\DropzoneBundle\Entity\Dropzone;
use Icap\DropzoneBundle\Entity\Correction;

class LogDropGradeAvailableEvent extends AbstractLogResourceEvent implements NotifiableInterface {

    const ACTION = 'resource-icap_dropzone-drop_grade_available';
    protected $dropzone;
    protected $drop;
    protected $details;

    /**
     * @param Wiki $wiki
     * @param Section $section
     * @param Contribution $contribution
    */
    public function __construct(Dropzone $dropzone, Drop $drop)
    {
        $this->dropzone = $dropzone;
        $this->drop = $drop;
        $this->details = array(
                'drop' => $drop,
                'dropzoneId' => $dropzone->getId(),
                'dropId' => $drop->getId(),
        );

        parent::__construct($dropzone->getResourceNode(), $this->details);
    }

    /**
     * @return array
     */
    public static function getRestriction()
    {
        return array(self::DISPLAYED_WORKSPACE);
    }

    /**
     * Get sendToFollowers boolean.
     * 
     * @return boolean
     */
    public function getSendToFollowers()
    {
        // notify only the drop's owner.
        return false;
    }

    /**
     * Get includeUsers array of user ids.
     * Reports are only reported to user witch have the manager role
     * @return array
     */
    public function getIncludeUserIds()
    {
        // notify only the drop's owner.
        $ids = array();
        $id = $this->drop->getUser()->getId();
        array_push($ids,$id);

        return $ids;
        
    }

    /**
     * Get excludeUsers array of user ids.
     *
     * @return array
     */
    public function getExcludeUserIds()
    {
        return array();
    }

    /**
     * Get actionKey string.
     *
     * @return string
     */
    public function getActionKey()
    {
        return $this::ACTION;
    }

    /**
     * Get iconTypeUrl string.
     *
     * @return string
     */
    public function getIconKey()
    {
        return "dropzone";
    }

    /**
     * Get details
     *
     * @return array
     */
    public function getNotificationDetails()
    {
        $notificationDetails = array_merge($this->details, array());
        $notificationDetails['resource'] = array(
            'id' => $this->dropzone->getId(),
            'name' => $this->resource->getName(),
            'type' => $this->resource->getResourceType()->getName()
        );

        return $notificationDetails;
    }

    /**
     * Get if event is allowed to create notification or not
     *
     * @return boolean
     */
    public function isAllowedToNotify()
    {
        return true;
    }
}