<?php

namespace MN\MatchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MN\MatchBundle\Entity\Game;
use MN\MatchBundle\Form\GameType;
use MN\MatchBundle\Form\QuickGameResultType;
use MN\MatchBundle\Entity\Team;
use MN\MatchBundle\Entity\TeamPlayer;

/**
 * Game controller.
 *
 * @Route("/admin/game")
 */
class GameController extends Controller
{

    /**
     * Lists all Game entities.
     *
     * @Route("/", name="admin_game")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MNMatchBundle:Game')->findBy(array(), array('date' => 'desc'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Game entity.
     *
     * @Route("/", name="admin_game_create")
     * @Method("POST")
     * @Template("MNMatchBundle:Game:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Game();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach($entity->getTeams() as $team){
                $team->setGame($entity);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_game'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Game entity.
    *
    * @param Game $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Game $entity)
    {
        $form = $this->createForm(new GameType(), $entity, array(
            'action' => $this->generateUrl('admin_game_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Game entity.
     *
     * @Route("/new", name="admin_game_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Game();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/{id}/subs", name="admin_manage_subs")
     * @Template()
     */
    public function manageSubsAction(Game $game){
        return compact('game');
    }

    /**
     * @Route("/subs/update/{id}/{value}", name="admin_subs_toggle")
     */
    public function subsToggleAction(TeamPlayer $team_player, $value)
    {
        $em = $this->getDoctrine()->getManager();
        $team_player->setPaid($value);
        $em->persist($team_player);
        $em->flush();
        return new Response(null, 200);
    }

    /**
     * Finds and displays a Game entity.
     *
     * @Route("/{id}/result", name="admin_game_result")
     * @Method("GET")
     * @Template()
     */
    public function gameResultAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
        }

        $resultForm = $this->createResultForm($entity);

        return array(
            'entity'      => $entity,
            'result_form'   => $resultForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Game entity.
     *
     * @Route("/{id}/edit", name="admin_game_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
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
    * Creates a form to edit a Game entity.
    *
    * @param Game $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Game $entity)
    {
        $form = $this->createForm(new GameType(), $entity, array(
            'action' => $this->generateUrl('admin_game_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
    * Creates a form to edit a Game entity.
    *
    * @param Game $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createResultForm(Game $entity)
    {
        $form = $this->createForm(new QuickGameResultType(), $entity, array(
            'action' => $this->generateUrl('admin_game_result_save', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }

    /**
     * Edits an existing Game entity.
     *
     * @Route("/save-result/{id}", name="admin_game_result_save")
     * @Method("PUT")
     * @Template("MNMatchBundle:Game:gameResult.html.twig")
     */
    public function saveResultAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
        }

        $resultForm = $this->createResultForm($entity);
        $resultForm->handleRequest($request);
        if ($resultForm->isValid()) {
            $entity->setPlayed(1);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_game'));
        }

        return array(
            'entity'      => $entity,
            'result_form'   => $resultForm->createView(),
        );
    }

    /**
     * Edits an existing Game entity.
     *
     * @Route("/{id}", name="admin_game_update")
     * @Method("PUT")
     * @Template("MNMatchBundle:Game:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MNMatchBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_game_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Game entity.
     *
     * @Route("/{id}", name="admin_game_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MNMatchBundle:Game')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Game entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_game'));
    }

    /**
     * Creates a form to delete a Game entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_game_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
