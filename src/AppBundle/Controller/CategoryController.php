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
            die($name);
        }

        // Render create.html.twig template from category directory - app/Resources/views/category
        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/category/edit/{id}", name="category_edit")
     */
    public function editAction(Request $request)
    {
        // Render edit.html.twig from category directory - app/Resources/views/category
        return $this->render('category/edit.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="category_delete")
     */
    public function deleteAction(Request $request)
    {
         // No view to render
    }
}
