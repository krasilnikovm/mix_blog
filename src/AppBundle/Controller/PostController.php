<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    /**
     * @Route("/posts/{page}", name="posts", defaults={ "page": 1})
     */
    public function postsAction($page)
    {
        $countRecords = 5;
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findAll();

        $paginator = $this->get('knp_paginator'); //(1)

        $pages = $paginator->paginate($posts, $page/*page*/, $countRecords/*limit*/); //(3)
        // $slice is a pagination view, represents the paginated data
        if(!$posts) {
            throw $this->createNotFoundException("Not found page with number " . $page );
        }


        return $this->render(':post:posts.html.twig', ['posts' => $pages]);
    }

    /**
     * @Route("/post/{id}", name="post", requirements={"id"="\d+"})
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
            ":post:post.html.twig", [
                'id' => $post->getId(),
            'article' => $post->getArticle(),
            'title' => $post->getTitle(),
            'author' => $post->getUser()->getUserName()]);
    }

    /**
     * @Route("/post/new", name="adding_post")
     */
    public function creatingPostAction(Request $request)
    {
        $admin = $this->getUser();

        if (!$admin->hasRole('ROLE_ADMIN')) {
           throw $this->createNotFoundException("Page Not Found");
        }
        $post = new Post();

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('article', TextareaType::class)
            ->add('button', SubmitType::class, array('label' => 'Добавить'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCountLikes(0);
            $post->setDate(new DateTime());
            $post->setUser($admin);
            $em = $this->getDoctrine()->getManager();

            $em->persist($post);

            $em->flush();

            return $this->render('post/post_success.html.twig');
        }

        return $this->render(':post:post_form_content.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
    * @Route("/post/remove/{id}", name="remove_post", requirements={"id"="\d+"})
    **/
    public function removePost($id)
    {
        $user = $this->getUser();

        if ( $user === null || !$user->hasRole('ROLE_ADMIN')) {
           throw $this->createNotFoundException("Page Not Found");
        }

        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:Post')->find($id);
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('posts');
    }

    /**
    * @Route("/post/edit/{id}", name="edit_post", requirements={"id"="\d+"})
    */
    public function editPostAction($id, Request $request)
    {
      $user = $this->getUser();

      if ($user == null || !$user->hasRole('ROLE_ADMIN')) {
        throw $this->createNotFoundException("Page not found");
      }

      $em = $this->getDoctrine()->getManager();

      $post = $em->getRepository(Post::class)->find($id);

      $form = $this->createFormBuilder($post)
          ->add('title', TextType::class, ['data' => $post->getTitle()])
          ->add('article', TextareaType::class, ['data' => $post->getArticle()])
          ->add('button', SubmitType::class, array('label' => 'Изменить'))
          ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

          $em->persist($post);
          $em->flush();

          return $this->render('post/post_success.html.twig');
      }

      return $this->render(':post:post_form_edit_content.html.twig', array(
          'form' => $form->createView(),
      ));
    }
}
