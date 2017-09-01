<?php

/* EventController for event actions
*/

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;             //Do you comments foR THIS FILE
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    /**
     * @Route("/events", name="event_list")
     */
    public function indexAction(Request $request)
    {
        // Render index.html.twig from category directory in app/Resources/views/events
        return $this->render('events/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/event/create", name="event_create")
     */
    public function createAction(Request $request)
    {
        // Render create.html.twig from category directory in app/Resources/views/events
        return $this->render('events/create.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

     /**
     * @Route("/event/edit/{id}", name="event_edit")
     */
    public function editAction(Request $request)
    {
        // Render edit.html.twig from category directory - app/Resources/views/events
        return $this->render('events/edit.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/event/delete/{id}", name="event_delete")
     */
    public function deleteAction(Request $request)
    {
         // No view to render
    }
}
