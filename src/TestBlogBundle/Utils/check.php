<?php

namespace TestBlogBundle\Utils;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class check extends Controller
{

    public function getCategories ($articles) {

        $array_categories = array();
        foreach ($articles as $a) {
            $explode_categories = explode(',', $a->getCategories());
            foreach ($explode_categories as $expl) {
                if (!(in_array($expl, $array_categories))) {
                    array_push($array_categories, $expl);
                }
            }
        }
        return $array_categories;
    }


    public function getArticles ($articles, $value) {

        $array_articles = array();

        foreach ($articles as $a) {
            $explode_categories = explode(',', $a->getcategories());
            foreach ($explode_categories as $expl) {
                if (( $expl == $value )) {
                    array_push($array_articles, $a);
                }
            }
        }
        return $array_articles;
    }

}