<?php

namespace MN\UsefulBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createFrontendMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setCurrentUri($request->getRequestUri());

        $menu->addChild('Home', array('route' => 'home'));
        $menu->addChild('Matches', array('route' => 'match'));
        $menu->addChild('Players', array('route' => 'player'));

        if($request->get('_route') == 'player_profile'){
            $menu['Players']->setCurrent(true);
        }

        return $menu;
    }

    public function createAdminMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->setCurrentUri($request->getRequestUri());

        $menu->addChild('Main Site', array('route' => 'home'));

        $menu->addChild('Matches', array('route' => 'admin_game'));

        $menu->addChild('Players', array('route' => 'admin_player', 'links' => array('player_profile')));

        $menu->addChild('Team Groups', array('route' => 'admin_teamcategory'));

        return $menu;
    }
}