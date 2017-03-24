<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $categories = $this->getDoctrine()->getRepository("AppBundle:Category")->findAll();
        $lastBooks = $this->getDoctrine()->getRepository("AppBundle:Book")->findLast(3);
        $users = $this->getDoctrine()->getRepository("AppBundle:User")->findUserWithCount(2);

        return $this->render('default/index.html.twig', [
                    "categories" => $categories,
                    "lastBooks" => $lastBooks,
                    "users" => $users

        ]);
    }

    /**
     * @Route("/book/{slug}", name="show_book")
     */
    public function showBookAction(\AppBundle\Entity\Book $book) {
        $randomBooks = $this->getDoctrine()->getRepository("AppBundle:Book")->findRandom(3, $book);
        return $this->render('book/show.html.twig' , [
            "book" => $book,
            "randomBooks" => $randomBooks
        ]);
    }

    /**
     * @Route("/category/{id}", name="show_category")
     */
    public function showCategoryAction(\AppBundle\Entity\Category $category) {
        return $this->render('category/show.html.twig', [
                    "category" => $category
        ]);
    }

    /**
     * @Route("/user/{id}", name="show_user")
     */
    public function showUserAction(\AppBundle\Entity\User $user){
        $em = $this->getDoctrine()->getManager();

        return $this->render('user/show.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @Route("/search", name="search_book")
     */
    public function searchBook(Request $request)
    {
        $categories ="";
        $result ="";
        if($request->getMethod() === 'POST')
        {
            $category = $request->get('selectedCategory');
            $title= $request->get('searchTitle');

            $result = $this->getDoctrine()->getRepository("AppBundle:Book")->findByNameAndCategory($title, $category);

            $categories = $this->getDoctrine()->getRepository("AppBundle:Category")->findAll();

        }

        return $this->render('search/searchResult.html.twig', [
            'categories' => $categories,
            'result' =>  $result
        ]);
    }
}
