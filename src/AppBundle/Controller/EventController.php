<?php

/* EventController for event actions
*/

namespace AppBundle\Controller;


use AppBundle\Entity\Event; //Include the entity for database/model parsing
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;             //gitHub.com123
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


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
         //Create new Event object
        $event = new Event;

        //Pass in Event object so a form can be built with the current fields 
        $form = $this->createFormBuilder($event)->add('name', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('category', EntityType::class, array('class' => 'AppBundle:Category', 'choice_label' => 'name', 'attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('details', TextareaType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('day', DateTimeType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('street_address', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('city', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('zipcode', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('save', SubmitType::class, array('label' => 'Create Event', 'attr' =>
                 array('class' => 'btn btn-primary')))->getForm();

        //Handle request
        $form->handleRequest($request);

        //Check to see if data is submitted
        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $details = $form['details']->getData();
            $day = $form['day']->getData();
            $street_address = $form['street_address']->getData();
            $city = $form['city']->getData();
            $zipcode = $form['zipcode']->getData();
            
            //Get current date and time
            $now = new \DateTime("now");

            //Set data fields
            $event->setName($name);
            $event->setCategory($category);
            $event->setDay($day);
            $event->setDetails($details);
            $event->setStreetAddress($street_address);
            $event->setCity($city);
            $event->setZipcode($zipcode);
            $event->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();

            //Save event data to DB
            $em->persist($event);
            $em->flush();

            //Flash message 
            $this->addFlash(
                   'notice',
                   'Event Saved'
            );

            //Redirect to event_list which is index.html.twig
            return $this->redirectToRoute('event_list');
        }

        // Render create.html.twig template from event directory - app/Resources/views/event
        return $this->render('event/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/event/edit/{id}", name="event_edit")
     */
    public function editAction($id, Request $request)
    {
         //Create new Event object
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')->find($id);

        if(!$event){
            throw $this->createNotFoundException('No event found for id ' .$id);
        }

        //Get data fields so they can stick to the form
        $event->setName($event->getName());
        $event->setCategory($event->getCategory());
        $event->setDay($event->getDay());
        $event->setDetails($event->getDetails());
        $event->setStreetAddress($event->getStreetAddress());
        $event->setCity($event->getCity());
        $event->setZipcode($event->getZipcode());
   

        //Pass in Event object so a form can be built with the current fields 
        $form = $this->createFormBuilder($event)->add('name', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('category', EntityType::class, array('class' => 'AppBundle:Category', 'choice_label' => 'name', 'attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('details', TextareaType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('day', DateTimeType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('street_address', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('city', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('zipcode', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))
        ->add('save', SubmitType::class, array('label' => 'Edit Event', 'attr' =>
                 array('class' => 'btn btn-primary')))->getForm();

        //Handle request
        $form->handleRequest($request);

        //Check to see if data is submitted
        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $details = $form['details']->getData();
            $day = $form['day']->getData();
            $street_address = $form['street_address']->getData();
            $city = $form['city']->getData();
            $zipcode = $form['zipcode']->getData();
        
            $em = $this->getDoctrine()->getManager();
            $event = $em->getRepository('AppBundle:Event')->find($id);

            //Update events data
            $event->setName($name);
            $event->setCategory($category);
            $event->setDay($day);
            $event->setDetails($details);
            $event->setStreetAddress($street_address);
            $event->setCity($city);
            $event->setZipcode($zipcode);
       
            $em->flush();

            //Flash message 
            $this->addFlash(
                   'notice',
                   'Event Updated'
            );

            //Redirect to event_list which is index.html.twig
            return $this->redirectToRoute('event_list');
        }

        // Render create.html.twig template from event directory - app/Resources/views/event
        return $this->render('event/edit.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/event/delete/{id}", name="event_delete")
     */
    public function deleteAction($id)
    {
       $em = $this->getDoctrine()->getManager();
         $event = $em->getRepository('AppBundle:Event')->find($id);

         if(!$event){

            throw $this->createNotFoundException(
                'No event found with id of ' .$id
                );
         }

        //Remove event $id 
         $em->remove($event);
         $em->flush();

         
         $this->addFlash(
                'notice',
                'Event Deleted'
            );

            return $this->redirectToRoute('event_list');
    }
    
}
