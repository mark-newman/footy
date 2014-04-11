<?php

namespace MN\MatchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MN\MatchBundle\Entity\ResultType;
use MN\MatchBundle\Form\ResultTypeType;

/**
 * ResultType controller.
 *
 * @Route("/admin/resulttype")
 */
class ResultTypeController extends Controller
{

    /**
     * Lists all ResultType entities.
     *
     * @Route("/", name="admin_resulttype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MNMatchBundle:ResultType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ResultType entity.
     *
     * @Route("/", name="admin_resulttype_create")
     * @Method("POST")
     * @Template("MNMatchBundle:ResultType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ResultType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_resulttype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ResultType entity.
    *
    * @param ResultType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ResultType $entity)
    {
        $form = $this->createForm(new ResultTypeType(), $entity, array(
            'action' => $this->generateUrl('admin_resulttype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ResultType entity.
     *
     * @Route("/new", name="admin_resulttype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ResultType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ResultType entity.
     *
     * @Route("/{id}", name="admin_resulttype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:ResultType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ResultType entity.
     *
     * @Route("/{id}/edit", name="admin_resulttype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:ResultType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultType entity.');
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
    * Creates a form to edit a ResultType entity.
    *
    * @param ResultType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ResultType $entity)
    {
        $form = $this->createForm(new ResultTypeType(), $entity, array(
            'action' => $this->generateUrl('admin_resulttype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ResultType entity.
     *
     * @Route("/{id}", name="admin_resulttype_update")
     * @Method("PUT")
     * @Template("MNMatchBundle:ResultType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:ResultType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_resulttype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ResultType entity.
     *
     * @Route("/{id}", name="admin_resulttype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MNMatchBundle:ResultType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ResultType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_resulttype'));
    }

    /**
     * Creates a form to delete a ResultType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_resulttype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
