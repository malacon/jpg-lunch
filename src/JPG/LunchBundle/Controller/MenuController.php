<?php

namespace JPG\LunchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JPG\LunchBundle\Entity\Menu;
use JPG\LunchBundle\Entity\Holiday;
use JPG\LunchBundle\Form\MenuType;

/**
 * Menu controller.
 *
 * @Route("/setup/menu")
 */
class MenuController extends Controller
{

    /**
     * Lists all Menu entities.
     *
     * @Route("/", name="setup_menu")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JPGLunchBundle:Menu')->findAll();
        $holiday = $em->getRepository('JPGLunchBundle:Holiday')->findAll();

        $menu = array();
        $holidays = array();
        foreach ($entities as $item => $entity) {
            
            $menu[$entity->getDate()] = array('description' => $entity->getDescription(), "id" => $entity->getId(), "date" => $entity->getDate());
        }
        foreach ($holiday as $item => $entity) {
            
            $holidays[] = $entity->getDate();
        }
        $menu = json_encode($menu, -1);
        $holidays = json_encode($holidays, -1);

        return array(
            'entities' => $entities,
            'menu' => $menu,
            'holidays' => $holidays
        );
    }

    /**
     * @Route("/holiday/{date}")
     */
    public function updateHoliday(Request $request, $date) {
        // Look for date in the DB
        $em = $this->getDoctrine()->getManager();
        $holiday = $em->getRepository('JPGLunchBundle:Holiday')->findBy(array('date' => $date));

        // If found, delete it
        if ($holiday) {
            $em->remove($holiday[0]);
        } 
        // If not found, add it
        else {
            $holiday = new Holiday();
            $holiday->setDate($date);
            $em->persist($holiday);
        }

        $em->flush();

        $response = new Response(json_encode($holiday, -1));
        $response->headers->set('Content-Type', 'application/json');
        return $response;        
    }

    /**
     * Saves from POST
     *
     * @Route("/save", name="setup_menu_save")
     * @Method("POST")
     */
    public function saveItemAction(Request $request) {
        // See if item exists
        // print_r($_GET);die();
        if ($request->query->get('id') == false) {
            $entity = new Menu();
            $entity->setDescription($request->query->get('description'));
            $entity->setDate($request->query->get('date'));
            // $form = $this->createCreateForm($entity);
            // $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

        } else {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('JPGLunchBundle:Menu')->find($request->query->get('id'));
            $entity->setDescription($request->query->get('description'));
            $em->flush();

            // $editForm = $this->createEditForm($entity);
            // $editForm->handleRequest($request);

            // if ($editForm->isValid()) {
            //     $em->flush();
            // }
        }
        $menu = array('description' => $entity->getDescription(), "id" => $entity->getId(), "date" => $entity->getDate());
        // $menu = json_encode($menu, -1);
        $response = new Response(json_encode($menu, -1));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Creates a new Menu entity.
     *
     * @Route("/", name="setup_menu_create")
     * @Method("POST")
     * @Template("JPGLunchBundle:Menu:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('setup_menu_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Menu $entity)
    {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('setup_menu_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     * @Route("/new", name="setup_menu_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Menu();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Menu entity.
     *
     * @Route("/{id}", name="setup_menu_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JPGLunchBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     * @Route("/{id}/edit", name="setup_menu_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JPGLunchBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
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
    * Creates a form to edit a Menu entity.
    *
    * @param Menu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Menu $entity)
    {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('setup_menu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}", name="setup_menu_update")
     * @Method("PUT")
     * @Template("JPGLunchBundle:Menu:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JPGLunchBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('setup_menu_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Menu entity.
     *
     * @Route("/{id}", name="setup_menu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JPGLunchBundle:Menu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Menu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('setup_menu'));
    }

    /**
     * Creates a form to delete a Menu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('setup_menu_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
