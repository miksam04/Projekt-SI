<?php

/**
 * CommentController class.
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Form\Type\CommentType;
use App\Interface\CommentServiceInterface;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller responsible for managing comments.
 *
 * This controller provides methods to create and display comments on posts.
 */
class CommentController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param CommentServiceInterface $commentService the service for managing comments
     * @param PostService             $postService    the service for managing posts
     */
    public function __construct(private readonly CommentServiceInterface $commentService, private readonly PostService $postService)
    {
    }

    /**
     * Displays the form to add a comment to a post.
     *
     * @param int     $id      the ID of the post to which the comment will be added
     * @param Request $request the HTTP request object
     *
     * @return Response the response containing the rendered form
     */
    #[Route('/post/{id}/comment/add', name: 'comment_add', methods: ['GET', 'POST'])]
    #[IsGranted(CommentVoter::CREATE, subject: 'comment')]
    public function add(int $id, Request $request): Response
    {
        $post = $this->postService->getPostById($id);

        $comment = new Comment();
        $comment->setPost($post);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->saveComment($comment);
            $this->addFlash('success', 'Comment added successfully!');

            return $this->redirectToRoute('post_show', ['id' => $id]);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'comments' => $post->getComments(),
            'comment_form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a comment.
     *
     * @param int     $id      the ID of the comment to delete
     * @param Request $request the HTTP request object
     *
     * @return Response the response containing the rendered form or redirect
     */
    #[Route('/comment/{id}/delete', name: 'comment_delete', methods: 'GET|DELETE')]
    #[IsGranted(CommentVoter::DELETE, subject: 'comment')]
    public function delete(int $id, Request $request): Response
    {
        $comment = $this->commentService->getCommentById($id);

        $postId = $comment->getPost()->getId();

        $formBuilder = $this->createFormBuilder(null, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('comment_delete', ['id' => $comment->getId()]),
        ]);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->deleteComment($comment);
            $this->addFlash('success', 'Comment deleted successfully!');

            return $this->redirectToRoute('post_show', ['id' => $postId]);
        }

        return $this->render('comment/delete.html.twig', [
            'form' => $form->createView(),
            'comment' => $comment,
            'postId' => $postId,
        ]);
    }
}
