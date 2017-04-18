<?php

namespace AlaskaBlog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AlaskaBlog\Domain\Article;
use AlaskaBlog\Domain\User;
use AlaskaBlog\Form\Type\ArticleType;
use AlaskaBlog\Form\Type\CommentType;
use AlaskaBlog\Form\Type\UserType;

class AdminController {

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $articles = $app['dao.article']->findAll();
        $comments = $app['dao.comment']->findAll();
        $users = $app['dao.user']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'articles' => $articles,
            'comments' => $comments,
            'users' => $users));
    }

    /**
     * Add article controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addArticleAction(Request $request, Application $app) {
        $article = new Article();
        $articleForm = $app['form.factory']->create(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid() && (!empty($article->getContent())) && (!empty($article->getTitle()))) {

            $app['dao.article']->save($article);
            $app['session']->getFlashBag()->add('success', 'L’article a été créé avec succès.');

            return $app->redirect($app['url_generator']->generate('admin'));
        }

        if ($articleForm->isSubmitted() && (empty($article->getContent())) && (empty($article->getTitle()))) {

            $app['session']->getFlashBag()->add('error', 'Pour publier un article, veuillez compléter tous les champs!');
        }

        elseif ($articleForm->isSubmitted() && (empty($article->getContent()))) {

            $app['session']->getFlashBag()->add('error', 'Pour publier un article, veuillez compléter tous les champs!');
        }

        elseif ($articleForm->isSubmitted() && (empty($article->getTitle()))) {

            $app['session']->getFlashBag()->add('error', 'Pour publier un article, veuillez compléter tous les champs!');
        }

        return $app['twig']->render('article_form.html.twig', array(

            'title' => 'Nouvelle article',
            'articleForm' => $articleForm->createView()));
    }

    /**
     * Edit article controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editArticleAction($id, Request $request, Application $app) {
        $article = $app['dao.article']->find($id);
        $articleForm = $app['form.factory']->create(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid() && (!empty($article->getContent())) && (!empty($article->getTitle()))) {

            $app['dao.article']->save($article);
            $app['session']->getFlashBag()->add('success', 'L’article a été mis à jour.');

            return $app->redirect($app['url_generator']->generate('admin'));
        }

        if ($articleForm->isSubmitted() && (empty($article->getContent())) && (empty($article->getTitle()))) {

            $app['session']->getFlashBag()->add('error', 'Pour publier un article, veuillez compléter tous les champs!');
        }

        elseif ($articleForm->isSubmitted() && (empty($article->getContent()))) {

            $app['session']->getFlashBag()->add('error', 'Pour publier un article, veuillez compléter tous les champs!');
        }

        elseif ($articleForm->isSubmitted() && (empty($article->getTitle()))) {

            $app['session']->getFlashBag()->add('error', 'Pour publier un article, veuillez compléter tous les champs!');
        }

        return $app['twig']->render('article_form.html.twig', array(

            'title' => 'Modification de l\'article',
            'articleForm' => $articleForm->createView()));
    }

    /**
     * Delete article controller.
     *
     * @param integer $id Article id
     * @param Application $app Silex application
     */
    public function deleteArticleAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByArticle($id);
        // Delete the article
        $app['dao.article']->delete($id);

        $app['session']->getFlashBag()->add('success', 'L’article a été supprimé avec succès.');

        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Edit comment controller.
     *
     * @param integer $id Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editCommentAction($id, Request $request, Application $app) {
        
        $comment = $app['dao.comment']->find($id);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid() && (!empty($comment->getContent())) && (!empty($comment->getAuthor()))) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Le commentaire a été mis à jour.');
            return $app->redirect($app['url_generator']->generate('admin'));
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

        return $app['twig']->render('comment_form.html.twig', array(
            'title' => 'Edit comment',
            'commentForm' => $commentForm->createView()));
    }

    public function SignalementCommentAction($id, Request $request, Application $app) {
        
        $comment = $app['dao.comment']->find($id);
        $signalForm = $app['form.factory']->create(SignalType::class, $comment);
        $signalForm->handleRequest($request);
        $questionSignalement = 'êtes-vous vraiment sûr de vouloir signaler le commentaire ?';

        if ($signalForm->isSubmitted() && $_GET['signalement'] == 0) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'La confirmation a bien était effectué.');

            return $app->redirect($app['url_generator']->generate('admin'));
        }
        elseif ($signalForm->isSubmitted() && $_GET['signalement'] == 1) {

            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'La confirmation a bien était effectué pour retourner à la page d\'accueil.');

            return $app->redirect('../article/'.$comment->getArticle()->getId());

        }

        return $app['twig']->render('signalement.html.twig', array(

            'title' => 'Signalement commentaire',
            'comments' => $comment,
            'questionSignalement' => $questionSignalement,
            'questionRetirerSignalement' => 'êtes-vous vraiment sûr de bien vouloir retirer le signalement du commentaire ?',
            'signalement' => $_GET['signalement'],
            'signalForm' => $signalForm->createView()));
    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentAction($id, Application $app) {
        $app['dao.comment']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a été supprimé avec succès.');

        // Redirection vers la page d'administration
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addUserAction(Request $request, Application $app) {
        $user = new User();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid() && (!empty($user->getUsername())) && (!empty($user->getPassword()))) {

            // générer une valeur aléatoire de salt
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();

            // trouver l’encodeur par défaut
            $encoder = $app['security.encoder.bcrypt'];

            // calculer le mot de passe 
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'L’utilisateur a été correctement créé.');

            return $app->redirect($app['url_generator']->generate('admin'));
        }


        if ($userForm->isSubmitted() && (empty($user->getUsername())) && (empty($user->getPassword()))) {

            $app['session']->getFlashBag()->add('error', 'veuillez remplir tous les champs ! ');
        }

        elseif ($userForm->isSubmitted() && (empty($user->getPassword()))) {

            $app['session']->getFlashBag()->add('error', 'veuillez remplir tous les champs !');
        }

        elseif ($userForm->isSubmitted() && (empty($user->getUsername()))) {

            $app['session']->getFlashBag()->add('error', 'veuillez remplir tous les champs !');
        }




        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'Nouvelle utilisateur',
            'userForm' => $userForm->createView()));
    }

    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editUserAction($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid() && (!empty($user->getUsername())) && (!empty($user->getPassword()))) {

            $plainPassword = $user->getPassword();

            // trouver l’encodeur pour l’utilisateur

            $encoder = $app['security.encoder_factory']->getEncoder($user);

            // calculer le mot de passe

            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'L’utilisateur a été correctement mis à jour.');

            return $app->redirect($app['url_generator']->generate('admin'));
        }



        if ($userForm->isSubmitted() && (empty($user->getUsername())) && (empty($user->getPassword()))) {

            $app['session']->getFlashBag()->add('error', 'veuillez remplir tous les champs ! ');
        }

        elseif ($userForm->isSubmitted() && (empty($user->getPassword()))) {

            $app['session']->getFlashBag()->add('error', 'veuillez remplir tous les champs !');
        }

        elseif ($userForm->isSubmitted() && (empty($user->getUsername()))) {

            $app['session']->getFlashBag()->add('error', 'veuillez remplir tous les champs !');
        }

        return $app['twig']->render('user_form.html.twig', array(
            
            'title' => 'Modification de l\'utilisateur',
            'userForm' => $userForm->createView()));
    }

    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {
        
        // Supprimer tous les commentaires
        // $app['dao.comment']->deleteAllByUser($id);
        // Supprimer l’utilisateur

        $app['dao.user']->delete($id);

        $app['session']->getFlashBag()->add('success', 'L’utilisateur a été correctement supprimé.');
        // Rediriger vers la page d’accueil d’admin
        return $app->redirect($app['url_generator']->generate('admin'));
    }
}
