<?php
/**
 * Created by : Vincent SAISSET
 * Date: 22/08/13
 * Time: 09:30
 */

namespace Icap\DropzoneBundle\Controller;

use Claroline\CoreBundle\Event\Log\LogResourceReadEvent;
use Claroline\CoreBundle\Event\Log\LogResourceUpdateEvent;
use Icap\DropzoneBundle\Entity\Criterion;
use Icap\DropzoneBundle\Entity\Dropzone;
use Icap\DropzoneBundle\Event\Log\LogCriterionCreateEvent;
use Icap\DropzoneBundle\Event\Log\LogCriterionDeleteEvent;
use Icap\DropzoneBundle\Event\Log\LogCriterionUpdateEvent;
use Icap\DropzoneBundle\Form\CriterionDeleteType;
use Icap\DropzoneBundle\Form\CriterionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CriterionController extends DropzoneBaseController
{
    /**
     * @Route(
     *      "/{resourceId}/edit/addcriterion/{page}/{criterionId}",
     *      name="icap_dropzone_edit_add_criterion",
     *      requirements={"resourceId" = "\d+", "criterionId" = "\d+", "page" = "\d+"},
     *      defaults={"criterionId" = 0}
     * )
     * @ParamConverter("dropzone", class="IcapDropzoneBundle:Dropzone", options={"id" = "resourceId"})
     * @Template()
     */
    public function editAddCriterionAction($dropzone, $page, $criterionId)
    {
        $this->isAllowToOpen($dropzone);
        $this->isAllowToEdit($dropzone);

        $criterion = new Criterion();
        if ($criterionId != 0) {
            $criterion = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('IcapDropzoneBundle:Criterion')
                ->find($criterionId);
        } else {
            $criterion->setDropzone($dropzone);
        }

        $form = $this->createForm(new CriterionType(), $criterion);

        if ($this->getRequest()->isXMLHttpRequest()) {

            return $this->render(
                'IcapDropzoneBundle:Criterion:editAddCriterionModal.html.twig',
                array(
                    'workspace' => $dropzone->getResourceNode()->getWorkspace(),
                    '_resource' => $dropzone,
                    'dropzone' => $dropzone,
                    'form' => $form->createView(),
                    'criterion' => $criterion,
                    'page' => $page
                )
            );
        }

        return array(
            'workspace' => $dropzone->getResourceNode()->getWorkspace(),
            '_resource' => $dropzone,
            'dropzone' => $dropzone,
            'form' => $form->createView(),
            'criterion' => $criterion,
            'page' => $page
        );
    }

    /**
     * @Route(
     *      "/{resourceId}/edit/createcriterion/{page}/{criterionId}",
     *      name="icap_dropzone_edit_create_criterion",
     *      requirements={"resourceId" = "\d+", "criterionId" = "\d+", "page" = "\d+"},
     *      defaults={"criterionId" = 0}
     * )
     * @ParamConverter("dropzone", class="IcapDropzoneBundle:Dropzone", options={"id" = "resourceId"})
     * @Template("IcapDropzoneBundle:Dropzone:editAddCriteria.html.twig")
     */
    public function editCreateCriterionAction($dropzone, $page, $criterionId)
    {
        $this->isAllowToOpen($dropzone);
        $this->isAllowToEdit($dropzone);

        $event = null;
        $criterion = new Criterion();
        if ($criterionId != 0) {
            $criterion = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('IcapDropzoneBundle:Criterion')
                ->find($criterionId);
            $event = new LogCriterionUpdateEvent($dropzone, $criterion);
        } else {
            $criterion->setDropzone($dropzone);
            $event = new LogCriterionCreateEvent($dropzone, $criterion);
        }

        $form = $this->createForm(new CriterionType(), $criterion);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $criterion = $form->getData();
            $criterion->setDropzone($dropzone);

            $em = $this->getDoctrine()->getManager();
            $em->persist($criterion);
            $em->persist($dropzone);
            $em->flush();


            $this->dispatch($event);

            return $this->redirect(
                $this->generateUrl(
                    'icap_dropzone_edit_criteria_paginated',
                    array(
                        'resourceId' => $dropzone->getId(),
                        'page' => $page
                    )
                )
            );
        }

        return array(
            'workspace' => $dropzone->getResourceNode()->getWorkspace(),
            '_resource' => $dropzone,
            'dropzone' => $dropzone,
            'form' => $form->createView(),
            'criterion' => $criterion,
            'page' => $page
        );
    }


    /**
     * @Route(
     *      "/{resourceId}/edit/deletecriterion/{page}/{criterionId}/{number}",
     *      name="icap_dropzone_edit_delete_criterion",
     *      requirements={"resourceId" = "\d+", "criterionId" = "\d+", "page" = "\d+", "number" = "\d+"}
     * )
     * @ParamConverter("dropzone", class="IcapDropzoneBundle:Dropzone", options={"id" = "resourceId"})
     * @ParamConverter("criterion", class="IcapDropzoneBundle:Criterion", options={"id" = "criterionId"})
     * @Template()
     */
    public function editDeleteCriterionAction($dropzone, $page, $criterion, $number)
    {
        $this->isAllowToOpen($dropzone);
        $this->isAllowToEdit($dropzone);

        $form = $this->createForm(new CriterionDeleteType(), $criterion);


        if ($this->getRequest()->isXMLHttpRequest()) {

            return $this->render(
                'IcapDropzoneBundle:Criterion:editDeleteCriterionModal.html.twig',
                array(
                    'workspace' => $dropzone->getResourceNode()->getWorkspace(),
                    '_resource' => $dropzone,
                    'dropzone' => $dropzone,
                    'criterion' => $criterion,
                    'form' => $form->createView(),
                    'page' => $page,
                    'number' => $number
                )
            );
        }

        return array(
            'workspace' => $dropzone->getResourceNode()->getWorkspace(),
            '_resource' => $dropzone,
            'dropzone' => $dropzone,
            'criterion' => $criterion,
            'form' => $form->createView(),
            'page' => $page,
            'number' => $number
        );
    }

    /**
     * @Route(
     *      "/{resourceId}/edit/removecriterion/{page}/{criterionId}",
     *      name="icap_dropzone_edit_remove_criterion",
     *      requirements={"resourceId" = "\d+", "criterionId" = "\d+", "page" = "\d+"}
     * )
     * @ParamConverter("dropzone", class="IcapDropzoneBundle:Dropzone", options={"id" = "resourceId"})
     * @ParamConverter("criterion", class="IcapDropzoneBundle:Criterion", options={"id" = "criterionId"})
     * @Template("IcapDropzoneBundle:Dropzone:editDeleteCriterion.html.twig")
     */
    public function editRemoveCriterionAction(Dropzone $dropzone, $page, Criterion $criterion)
    {
        $this->isAllowToOpen($dropzone);
        $this->isAllowToEdit($dropzone);

        $form = $this->createForm(new CriterionDeleteType(), $criterion);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $criterion = $form->getData();
            $criterion->setDropzone($dropzone);

            $em = $this->getDoctrine()->getManager();
            $em->remove($criterion);
            $em->flush();

            $event = new LogCriterionDeleteEvent($dropzone, $criterion);
            $this->dispatch($event);

            if ($dropzone->hasCriteria() === false) {
                $this->getRequest()->getSession()->getFlashBag()->add(
                    'warning',
                    $this->get('translator')->trans('Warning your peer review offers no criteria on which to base correct copies', array(), 'icap_dropzone')
                );
            }

            return $this->redirect(
                $this->generateUrl(
                    'icap_dropzone_edit_criteria_paginated',
                    array(
                        'resourceId' => $dropzone->getId(),
                        'page' => $page
                    )
                )
            );
        }

        return array(
            'workspace' => $dropzone->getResourceNode()->getWorkspace(),
            '_resource' => $dropzone,
            'dropzone' => $dropzone,
            'criterion' => $criterion,
            'form' => $form->createView(),
            'page' => $page
        );
    }
}