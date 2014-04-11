<?php

namespace MN\MatchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MN\MatchBundle\Entity\TeamCategory;
use MN\MatchBundle\Form\TeamCategoryType;

/**
 * TeamCategory controller.
 *
 * @Route("/admin/teamcategory")
 */
class TeamCategoryController extends Controller
{

    /**
     * Lists all TeamCategory entities.
     *
     * @Route("/", name="admin_teamcategory")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MNMatchBundle:TeamCategory')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TeamCategory entity.
     *
     * @Route("/", name="admin_teamcategory_create")
     * @Method("POST")
     * @Template("MNMatchBundle:TeamCategory:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TeamCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_teamcategory_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a TeamCategory entity.
    *
    * @param TeamCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(TeamCategory $entity)
    {
        $form = $this->createForm(new TeamCategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_teamcategory_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TeamCategory entity.
     *
     * @Route("/new", name="admin_teamcategory_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TeamCategory();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TeamCategory entity.
     *
     * @Route("/{id}", name="admin_teamcategory_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:TeamCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeamCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TeamCategory entity.
     *
     * @Route("/{id}/edit", name="admin_teamcategory_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:TeamCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeamCategory entity.');
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
    * Creates a form to edit a TeamCategory entity.
    *
    * @param TeamCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TeamCategory $entity)
    {
        $form = $this->createForm(new TeamCategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_teamcategory_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TeamCategory entity.
     *
     * @Route("/{id}", name="admin_teamcategory_update")
     * @Method("PUT")
     * @Template("MNMatchBundle:TeamCategory:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:TeamCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeamCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_teamcategory_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TeamCategory entity.
     *
     * @Route("/{id}", name="admin_teamcategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MNMatchBundle:TeamCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TeamCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_teamcategory'));
    }

    /**
     * Creates a form to delete a TeamCategory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_teamcategory_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
