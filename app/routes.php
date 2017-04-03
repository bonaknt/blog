<?php

use Symfony\Component\HttpFoundation\Request;
use AlaskaBlog\Domain\Comment;
use AlaskaBlog\Domain\Article;
use AlaskaBlog\Domain\User;
use AlaskaBlog\Form\Type\CommentType;
use AlaskaBlog\Form\Type\ArticleType;
use AlaskaBlog\Form\Type\UserType;
use AlaskaBlog\Form\Type\SignalType;


// Page d'accueil
$app->get('/', function () use ($app) {

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
})->bind('home');

// Déatails d'article avec les commentaires
$app->match('/article/{id}', function ($id, Request $request) use ($app) {
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

        $app['session']->getFlashBag()->add('error', 'Pour publier un commentaire, veuillez compléter tous les champs des commentaires !');
    }

    elseif ($commentForm->isSubmitted() && (empty($comment->getAuthor()))) {

        $app['session']->getFlashBag()->add('error', 'Pour publier un commentaire, veuillez compléter tous les champs des commentaires !');
    }

    $commentFormView = $commentForm->createView();

    $comments = $app['dao.comment']->findAllWithChildren($id);

    return $app['twig']->render('article.html.twig', array(
        'article' => $article, 
        'comments' => $comments,
        'commentForm' => $commentFormView));
})->bind('article');


// Login form
$app->get('/login', function(Request $request) use ($app) {

    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),

    ));
})->bind('login');

// Page d'accueil d'administration
$app->get('/admin', function() use ($app) {

    $articles = $app['dao.article']->findAll();
    $comments = $app['dao.comment']->findAll();
    $users = $app['dao.user']->findAll();

    return $app['twig']->render('admin.html.twig', array(
        'articles' => $articles,
        'comments' => $comments,
        'users' => $users));

})->bind('admin');


// Ajout nouvelle article
$app->match('/admin/article/add', function(Request $request) use ($app) {

    $article = new Article();
    $articleForm = $app['form.factory']->create(ArticleType::class, $article);
    $articleForm->handleRequest($request);

    if ($articleForm->isSubmitted() && $articleForm->isValid()) {
        $app['dao.article']->save($article);
        $app['session']->getFlashBag()->add('success', 'L’article a été créé avec succès.');
    }

    return $app['twig']->render('article_form.html.twig', array(
        'title' => 'Nouvelle article',
        'articleForm' => $articleForm->createView()));

})->bind('admin_article_add');

// Modifier un article existant
$app->match('/admin/article/{id}/edit', function($id, Request $request) use ($app) {

    $article = $app['dao.article']->find($id);
    $articleForm = $app['form.factory']->create(ArticleType::class, $article);
    $articleForm->handleRequest($request);

    if ($articleForm->isSubmitted() && $articleForm->isValid()) {
        $app['dao.article']->save($article);
        $app['session']->getFlashBag()->add('success', 'L’article a été mis à jour.');
    }

    return $app['twig']->render('article_form.html.twig', array(
        'title' => 'Modification de l\'article',
        'articleForm' => $articleForm->createView()));

})->bind('admin_article_edit');

// Supprimer un article
$app->get('/admin/article/{id}/delete', function($id, Request $request) use ($app) {
    // Delete all associated comments
    $app['dao.comment']->deleteAllByArticle($id);
    // Delete the article
    $app['dao.article']->delete($id);
    $app['session']->getFlashBag()->add('success', 'L’article a été supprimé avec succès.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));

})->bind('admin_article_delete');

// Modifier un commentaire existant
$app->match('/admin/comment/{id}/edit', function($id, Request $request) use ($app) {

    $comment = $app['dao.comment']->find($id);
    $commentForm = $app['form.factory']->create(CommentType::class, $comment);
    $commentForm->handleRequest($request);

    if ($commentForm->isSubmitted() && $commentForm->isValid()) {
        $app['dao.comment']->save($comment);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a été mis à jour.');
    }

    return $app['twig']->render('comment_form.html.twig', array(
        'title' => 'Edit comment',
        'commentForm' => $commentForm->createView()));
})->bind('admin_comment_edit');

////////////////////////////////////////////////////////////////////////////////////////////

$app->match('/{id}/signalement', function($id, Request $request) use ($app) {

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

})->bind('comment_signalement');



//////////////////////////////////////////////////////////////////////////////////////////

// Supprimer un commentaire
$app->get('/admin/comment/{id}/delete', function($id, Request $request) use ($app) {
    $app['dao.comment']->delete($id);
    $app['session']->getFlashBag()->add('success', 'Le commentaire a été supprimé avec succès.');
    // Redirection vers la page d'administration
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_comment_delete');

// Ajout d'un utilisateur
$app->match('/admin/user/add', function(Request $request) use ($app) {
    $user = new User();
    $userForm = $app['form.factory']->create(UserType::class, $user);
    $userForm->handleRequest($request);
    if ($userForm->isSubmitted() && $userForm->isValid()) {
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
    }
    return $app['twig']->render('user_form.html.twig', array(
        'title' => 'Nouvelle utilisateur',
        'userForm' => $userForm->createView()));
})->bind('admin_user_add');

// Modifier un utilisateur existant
$app->match('/admin/user/{id}/edit', function($id, Request $request) use ($app) {
    $user = $app['dao.user']->find($id);
    $userForm = $app['form.factory']->create(UserType::class, $user);
    $userForm->handleRequest($request);
    if ($userForm->isSubmitted() && $userForm->isValid()) {
        $plainPassword = $user->getPassword();
        // trouver l’encodeur pour l’utilisateur
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // calculer le mot de passe
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password); 
        $app['dao.user']->save($user);
        $app['session']->getFlashBag()->add('success', 'L’utilisateur a été correctement mis à jour.');
    }
    return $app['twig']->render('user_form.html.twig', array(
        'title' => 'Modification de l\'utilisateur',
        'userForm' => $userForm->createView()));
})->bind('admin_user_edit');

// Supprimer un utilisateur
$app->get('/admin/user/{id}/delete', function($id, Request $request) use ($app) {
    // Supprimer tous les commentaires
   // $app['dao.comment']->deleteAllByUser($id);
    // Supprimer l’utilisateur
    $app['dao.user']->delete($id);
    $app['session']->getFlashBag()->add('success', 'L’utilisateur a été correctement supprimé.');
    // Rediriger vers la page d’accueil d’admin
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_user_delete');