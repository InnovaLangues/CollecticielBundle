<?php

namespace Innova\CollecticielBundle\Event\Log;

use Claroline\CoreBundle\Event\Log\AbstractLogResourceEvent;
use Claroline\CoreBundle\Event\Log\LogGenericEvent;
use Icap\NotificationBundle\Entity\NotifiableInterface;
use Innova\CollecticielBundle\Entity\Document;
use Innova\CollecticielBundle\Entity\Drop;
use Innova\CollecticielBundle\Entity\Dropzone;
use Innova\CollecticielBundle\Entity\Correction;

class LogCorrectionReportEvent extends AbstractLogResourceEvent implements NotifiableInterface {

    const ACTION = 'resource-innova_collecticiel-correction_report';
    protected $dropzone;
    protected $details;
    private $role_manager;

    /**
     * @param Wiki $wiki
     * @param Section $section
     * @param Contribution $contribution
    */
    public function __construct(Dropzone $dropzone, Drop $drop, Correction $correction, $roleManager)
    {
        $this->dropzone = $dropzone;
        $this->role_manager =  $roleManager;
        $this->details = array(
            'report' => array(
                'drop' => $drop,
                'correction' => $correction,
                'report_comment' => $correction->getReportComment(),
                'dropzoneId' => $dropzone->getId(),
                'dropId' => $drop->getId(),
                'correctionId' => $correction->getId()
            )
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
        //Reports are only reported to user witch have the manager role
        return false;
    }

    /**
     * Get includeUsers array of user ids.
     * Reports are only reported to user witch have the manager role
     * @return array
     */
    public function getIncludeUserIds()
    {
        // In order to get users with the manager role.
        //getting the  workspace.
        
        $ResourceNode = $this->dropzone->getResourceNode();
        $workspace = $ResourceNode->getWorkspace();
        // getting the  Manager role
        $role = $this->role_manager->getManagerRole($workspace);

        // to finaly have the users.
        $users = $role->getUsers();
        $ids = array();
        foreach ($users as $user) {
           array_push($ids,$user->getId());
        }
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