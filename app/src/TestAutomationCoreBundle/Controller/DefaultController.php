<?php

namespace TestAutomationCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TestAutomationCoreBundle:Default:index.html.twig');
    }
}
