<?php

namespace Icap\DropzoneBundle\Voter;


use Claroline\CoreBundle\Entity\Resource\ResourceNode;
use Claroline\CoreBundle\Manager\MaskManager;
use Claroline\CoreBundle\Entity\User;
use Icap\DropzoneBundle\Entity\Dropzone;
use Icap\DropzoneBundle\Entity;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("icap.manager.drop_voter")
 */
class DropVoter
{

    private $container;
    private $maskManager;

    /**
     * @DI\InjectParams({
     *     "container" = @DI\Inject("service_container"),
     *        "maskManager" = @DI\Inject("claroline.manager.mask_manager")
     * })
     */
    public function __construct($container, MaskManager $maskManager)
    {
        $this->container = $container;
        $this->maskManager = $maskManager;
    }

    public function isAllowToOpenDrop(Drop $drop)
    {
        $collection = new ResourceCollection(array($drop->getResourceNode()));
        if (false === $this->get('security.context')->isGranted('OPEN', $collection)) {
            throw new AccessDeniedException();
        }
    }
} 