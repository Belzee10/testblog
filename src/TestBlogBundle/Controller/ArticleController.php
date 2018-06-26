<?php

namespace TestBlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use TestBlogBundle\Entity\Article;
use TestBlogBundle\Form\ArticleType;

/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     *
     */
    public function indexAction()
    {        
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('TestBlogBundle:Article')->findAll();

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Creates a new Article entity.
     *
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('TestBlogBundle\Form\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($article->getImage() == '') {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    'You must upload an image.'
                );
                goto BUCLE;
            }

            $categories = $article->getCategories();
            $fileName = md5(uniqid());
            $article->setAuthor($this->getUser());
            $article->setDate(new\DateTime('today'));
            $article->upload($fileName);
            $em->persist($article);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Article was created successfully.'
            );

            return $this->redirectToRoute('article_new');
        }

        BUCLE:
        return $this->render('article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Article entity.
     *
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     */
    public function editAction(Request $request, Article $article)
    {
        $img = $article->getImage();
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('TestBlogBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $image = $article->getImage();
            if ($image != null) {
                $fileName = md5(uniqid());
                $article->upload($fileName);
                $article->removeUpload($img);
            }
            else {
                $article->setImage($img);
            }
            $em->persist($article);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Article was updated successfully.'
            );

            return $this->redirectToRoute('article_edit', array('id' => $article->getId()));
        }

        return $this->render('article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Article entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('TestBlogBundle:Article')->findOneById($id);

        $article->removeUpload($article->getImage());
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('article_index');
    }
    /**
     * Creates a form to delete a User entity.
     *
     * @param Article $article The Article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function articleDetailsAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('TestBlogBundle:Article')->findOneBy(array('id' => $id));

        return $this->render('article/articleDetails.html.twig', array(
            'article' => $article,
        ));
    }


}
