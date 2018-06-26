<?php

namespace TestBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;

use TestBlogBundle\Utils\check;

class DefaultController extends Controller
{
    public function StartPageAction()
    {
        $check = new check();
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('TestBlogBundle:Article')->getArticles();
        $all_articles = $em->getRepository('TestBlogBundle:Article')->findAll();
        $cantArticles = count($all_articles);
        $array_categories = $check->getCategories($all_articles);

        return $this->render('Default/StartPage.html.twig', array(
            'articles' => $articles,
            'cantArticles' => $cantArticles,
            'categories' => $array_categories
        ));
    }

    public function MoreArticlesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('TestBlogBundle:Article')->getMoreArticles();

        return $this->render('Default/MoreArticles.html.twig', array(
            'articles' => $articles
        ));

    }

    public function FilterByCategoryAction ($value)
    {
        $check = new check();
        $em = $this->getDoctrine()->getManager();

        $all_articles = $em->getRepository('TestBlogBundle:Article')->findAll();
        $array_articles = $check->getArticles($all_articles, $value);

        return $this->render('Default/FilterByCategory.html.twig', array(
            'articles' => $array_articles
        ));

    }

    public function loginAction( )
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

    }

}
