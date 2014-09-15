<?php

namespace JPG\LunchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JPG\LunchBundle\Entity\Holiday;
use JPG\LunchBundle\Form\HolidayType;

/**
 * Holiday controller.
 *
 * @Route("/setup/menu/Holiday")
 */
class HolidayController extends Controller
{

    /**
     * Lists all Holiday entities.
     *
     * @Route("/", name="setup_menu_Holiday")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JPGLunchBundle:Holiday')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Holiday entity.
     *
     * @Route("/", name="setup_menu_Holiday_create")
     * @Method("POST")
     * @Template("JPGLunchBundle:Holiday:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Holiday();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('setup_menu_holiday_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Holiday entity.
     *
     * @param Holiday $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Holiday $entity)
    {
        $form = $this->createForm(new HolidayType(), $entity, array(
            'action' => $this->generateUrl('setup_menu_holiday_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Holiday entity.
     *
     * @Route("/new", name="setup_menu_Holiday_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Holiday();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Holiday entity.
     *
     * @Route("/{id}", name="setup_menu_Holiday_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JPGLunchBundle:Holiday')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Holiday entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Holiday entity.
     *
     * @Route("/{id}/edit", name="setup_menu_Holiday_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JPGLunchBundle:Holiday')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Holiday entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Holiday entity.
    *
    * @param Holiday $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Holiday $entity)
    {
        $form = $this->createForm(new HolidayType(), $entity, array(
            'action' => $this->generateUrl('setup_menu_holiday_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Holiday entity.
     *
     * @Route("/{id}", name="setup_menu_Holiday_update")
     * @Method("PUT")
     * @Template("JPGLunchBundle:Holiday:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JPGLunchBundle:Holiday')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Holiday entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('setup_menu_holiday_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Holiday entity.
     *
     * @Route("/{id}", name="setup_menu_Holiday_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JPGLunchBundle:Holiday')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Holiday entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('setup_menu_holiday'));
    }

    /**
     * Creates a form to delete a Holiday entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('setup_menu_holiday_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
