<?php

namespace JPG\LunchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/parent")
     * @Template()
     */
    public function parentOrderAction()
    {
    	return array();
    }

    /**
     * @Route("/setup")
     * @Template()
     */
    public function setupAction()
    {
    	return array();
    }

}
