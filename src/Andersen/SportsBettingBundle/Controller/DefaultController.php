<?php

namespace Andersen\SportsBettingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SportsBettingBundle:Default:index.html.twig');
    }
}
