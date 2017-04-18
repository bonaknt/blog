<?php

namespace AlaskaBlog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AlaskaBlog\Domain\Comment;
use AlaskaBlog\Form\Type\CommentType;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {

        $articlesParPage = 5;
        $articleTotale = $app['dao.article']->nbArticles();

        $articleTotal = $articleTotale->rowCount();

        $pagesTotales = ceil($articleTotal / $articlesParPage);

        if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
           $_GET['page'] = intval($_GET['page']);
           $pageCourante = $_GET['page'];
        } else {
           $pageCourante = 1;
        }
        $depart = ($pageCourante-1)*$articlesParPage;


        $articles = $app['dao.article']->pagination($depart, $articlesParPage);

        return $app['twig']->render('index.html.twig', array('articles' => $articles, 'pagesTotales' => $pagesTotales, 'pageCourante' => $pageCourante));
    }
    
    /**
     * Article details controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function articleAction($id, Request $request, Application $app) {
        $article = $app['dao.article']->find($id);
        $commentFormView = null;

        // ajout des commentaires
        $comment = new Comment();
        $comment->setArticle($article);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);


        if ($commentForm->isSubmitted() && $commentForm->isValid() && (!empty($comment->getContent())) && (!empty($comment->getAuthor()))) {
            $commentFormView;
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Votre commentaire a été ajouté avec succès.');
            return $app->redirect('../article/'.$id);
        }

        if ($commentForm->isSubmitted() && (empty($comment->getContent())) && (empty($comment->getAuthor()))) {

            $app['session']->getFlashBag()->add('error', 'Pour publier un commentaire, veuillez compléter tous les champs des commentaires !');
        }

        elseif ($commentForm->isSubmitted() && (empty($comment->getContent()))) {

            $app['session']->getFlashBag()->add('error', 'Impossible d\'envoyer le commentaire, car le contenu du commentaire est vide !');
        }

        elseif ($commentForm->isSubmitted() && (empty($comment->getAuthor()))) {

            $app['session']->getFlashBag()->add('error', 'Impossible d\'envoyer le commentaire, car vous n\'avez pas rempli le champ "Pseudo" !');
        }

        $commentFormView = $commentForm->createView();

        $comments = $app['dao.comment']->findAllWithChildren($id);
        
        return $app['twig']->render('article.html.twig', array(
            'article' => $article,
            'comments' => $comments,
            'commentForm' => $commentFormView));
    }
    
    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }
}
