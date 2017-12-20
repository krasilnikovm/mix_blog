<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render(':default:index.html.twig');
    }

    /**
     * @Route("/posts/{page}", name="posts", defaults={ "page": 1})
     */
    public function postsAction($page)
    {
        $countRecords = 5;
        $offset = 1 * ($page - 1) * $countRecords;
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findBy([],[], $countRecords, $offset );

        $paginator = $this->get('knp_paginator'); //(1)
        $target = $posts; //(2) array('a', 'b', ... 'u');
        // uses event subscribers to paginate $target
        $slice = $paginator->paginate($target, $page/*page*/, $countRecords/*limit*/); //(3)
        // $slice is a pagination view, represents the paginated data
        if(!$posts) {
            throw $this->createNotFoundException("Not found page with number " . $page );
        }


        return $this->render(':default:posts.html.twig', ['posts' => $posts, 'pagination' => $slice]);
    }

    /**
     * @Route("/post/{id}", name="post")
     */
    public function postAction($id)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($id);


        if(!$post) {
            throw $this->createNotFoundException("No post with id " . $id);
        }

        return $this->render(
            ":default:post.html.twig", [
                'article' => $post->getArticle(),
                'title' => $post->getTitle(),
                'author' => $post->getUser()->getUserName()]);
    }

}
