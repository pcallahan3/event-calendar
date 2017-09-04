<?php

/* CategoryController for category actions
*/

namespace AppBundle\Controller;

use AppBundle\Entity\Category; //Include the entity for database/model parsing
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\DateType;



class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category_list")
     */
    public function indexAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        // Render index.html.twig template from category directory - app/Resources/views/category
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/create", name="category_create")
     */
    public function createAction(Request $request)
    {
        //Create new Category object
        $category = new Category;

        //Pass in Category object so a form can be built with the current fields 
        $form = $this->createFormBuilder($category)->add('name', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))->add('save', SubmitType::class, array('label' => 'Create Category', 'attr' =>
                 array('class' => 'btn btn-primary')))->getForm();

        //Handle request
        $form->handleRequest($request);

        //Check to see if data is submitted
        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            
            //Get current date and time
            $now = new \DateTime("now");

            //Set name and date
            $category->setName($name);
            $category->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();

            //Save category data to DB
            $em->persist($category);
            $em->flush();

            //Flash message 
            $this->addFlash(
                   'notice',
                   'Category Saved'
            );

            //Redirect to category_list which is index.html.twig
            return $this->redirectToRoute('category_list');
        }

        // Render create.html.twig template from category directory - app/Resources/views/category
        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/category/edit/{id}", name="category_edit")
     */
    public function editAction($id, Request $request)
    {
        //Get the current $id requested from the DB to be edited
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);

        //Pass in Category object so a form can be built with the current fields 
        $form = $this->createFormBuilder($category)->add('name', TextType::class, array('attr' => array('class' => 'form-control', 
                'style' => 'margin-bottom:15px')))->add('save', SubmitType::class, array('label' => 'Edit Category', 'attr' =>
                 array('class' => 'btn btn-primary')))->getForm();

        if(!$category){
            throw $this->createNotFoundException('Category not found for id ' .$id);
        }

        //Get $category name form DB and set new $category name
        $category->setName($category->getName());

        //Handle request
        $form->handleRequest($request);

        //Check to see if data is submitted
        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository('AppBundle:Category')->find($id);

            //Save category data to DB
            $category->setName($name);
            $em->flush();

            //Flash message 
            $this->addFlash(
                   'notice',
                   'Category Updated'
            );

            //Redirect to category_list which is index.html.twig
            return $this->redirectToRoute('category_list');
        }

        // Render edit.html.twig template from category directory - app/Resources/views/category
        return $this->render('category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="category_delete")
     */
    public function deleteAction($id)
    {
         $em = $this->getDoctrine()->getManager();
         $category = $em->getRepository('AppBundle:Category')->find($id);

         if(!$category){

            throw $this->createNotFoundException(
                'No category found with id of ' .$id
                );
         }

        //Remove category $id 
         $em->remove($category);
         $em->flush();


         $this->addFlash(
                'notice',
                'Category Deleted'
            );

            return $this->redirectToRoute('category_list');
    }
}
