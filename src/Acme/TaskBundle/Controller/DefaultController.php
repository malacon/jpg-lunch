<?php

namespace Acme\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\TaskBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/task")
     * @Template()
     */
    public function indexAction(Request $request)
    {
    	$task = new Task();
    	$task->setTask('Write a blog post');
    	$task->setDueDate(new \DateTime('tomorrow'));

    	$form = $this->createFormBuilder($task)
    		->add('task', 'text')
    		->add('dueDate', 'date', array('widget' => 'single_text'))
    		->add('save', 'submit')
    		->getForm();

    	$form->handleRequest($request);

    	if ($form->isValid()) {
    		return $this->redirect($this->generateUrl('task_success'));
    	}

    	return array('form' => $form->createView());
    }
}
