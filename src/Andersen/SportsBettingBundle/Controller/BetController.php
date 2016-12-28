<?php

namespace Andersen\SportsBettingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BetController extends Controller
{
    public function indexAction()
    {
        return $this->render('SportsBettingBundle:Bet:index.html.twig');
    }
}
