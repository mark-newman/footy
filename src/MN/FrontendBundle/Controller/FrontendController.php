<?php

namespace MN\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MN\PlayerBundle\Entity\Player;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Map;

class FrontendController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $last_match = $em->getRepository('MNMatchBundle:Game')->getLastGame();

        return compact('last_match');
    }

    /**
     * @Route("/match/list", name="match")
     * @Template()
     */
    public function matchAction()
    {
        $em = $this->getDoctrine()->getManager();

        $matches = $em->getRepository('MNMatchBundle:Game')->findBy(array(), array('date'=>'desc'));

        return compact('matches');
    }

    /**
     * @Route("/player/list", name="player")
     * @Template()
     */
    public function playerAction()
    {
        $em = $this->getDoctrine()->getManager();

        $players = $em->getRepository('MNPlayerBundle:Player')->findAll();

        return compact('players');
    }

    /**
     * @Route("/player/{id}", name="player_profile")
     * @Template()
     */
    public function playerProfileAction(Player $player)
    {
        return compact('player');
    }

    public function nextGameWidgetAction(){
        $em = $this->getDoctrine()->getManager();

        $next_match = $em->getRepository('MNMatchBundle:Game')->getNextGame();

        return $this->render('MNFrontendBundle:Partials:nextGameWidget.html.twig', compact('next_match'));
    }

    public function atAGlanceMatchWidgetAction(){
        $em = $this->getDoctrine()->getManager();

        $team_categories = $em->getRepository('MNMatchBundle:TeamCategory')->findAll();

        return $this->render('MNFrontendBundle:Partials:atAGlanceMatchWidget.html.twig', compact('team_categories'));
    }

    public function atAGlancePlayerWidgetAction(){
        $em = $this->getDoctrine()->getManager();

        $players = $em->getRepository('MNPlayerBundle:Player')->findAll();

        return $this->render('MNFrontendBundle:Partials:atAGlancePlayerWidget.html.twig', compact('players'));
    }

    public function playerVitalStatisticsWidgetAction(Player $player){

        return $this->render('MNFrontendBundle:Partials:playerVitalStatisticsWidget.html.twig', compact('player'));
    }

    /**
     * @param array $players
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/map")
     */
    public function playerLocationsWidgetAction($players=array()){

        $em = $this->getDoctrine()->getManager();

        $players = array($em->getRepository('MNPlayerBundle:Player')->find(1));

        $map = new Map();

        foreach ($players as $player) {
            $marker = new Marker();
            $marker->setPrefixJavascriptVariable('marker_');
            $marker->setPosition($player->getLongitude(), $player->getLatitude(), true);
            $marker->setAnimation(Animation::DROP);

            $marker->setOption('clickable', false);
            $marker->setOption('flat', true);
            $marker->setOptions(array(
                'clickable' => false,
                'flat'      => true,
            ));
            $map->addMarker($marker);
        }

        return $this->render('MNFrontendBundle:Partials:playerLocationWidget.html.twig', compact('map'));
    }
}
