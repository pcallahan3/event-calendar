<?php

/* CategoryController for category actions
*/

namespace AppBundle\Controller;

use AppBundle\Entity\Category; //Include the entity for database/model parsing
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        // Render create.html.twig from category directory - app/Resources/views/category
        return $this->render('category/create.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
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
