<?php

/* EventController for event actions
*/

namespace AppBundle\Controller;


use AppBundle\Entity\Event; //Include the entity for database/model parsing
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;             //gitHub.com123
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    /**
     * @Route("/events", name="event_list")
     */
    public function indexAction(Request $request)
    {

        $events = $this->getDoctrine()->getRepository('AppBundle:Event')->findAll();
        // Render index.html.twig from category directory in app/Resources/views/events
        return $this->render('event/index.html.twig', [
            'events' => $events
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
