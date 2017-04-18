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
$app->get('/', "AlaskaBlog\Controller\HomeController::indexAction")->bind('home');

// Déatails d'article avec les commentaires
$app->match('/article/{id}', "AlaskaBlog\Controller\HomeController::articleAction")->bind('article');


// Login form
$app->get('/login', "AlaskaBlog\Controller\HomeController::loginAction")->bind('login');

// Page d'accueil d'administration
$app->get('/admin', "AlaskaBlog\Controller\AdminController::indexAction")->bind('admin');


// Ajout nouvelle article
$app->match('/admin/article/add', "AlaskaBlog\Controller\AdminController::addArticleAction")->bind('admin_article_add');

// Modifier un article existant
$app->match('/admin/article/{id}/edit', "AlaskaBlog\Controller\AdminController::editArticleAction")->bind('admin_article_edit');


// Supprimer un article
$app->get('/admin/article/{id}/delete', "AlaskaBlog\Controller\AdminController::deleteArticleAction")
->bind('admin_article_delete');

// Modifier un commentaire
$app->match('/admin/comment/{id}/edit', "AlaskaBlog\Controller\AdminController::editCommentAction")
->bind('admin_comment_edit');

// Supprimer un commentaire
$app->get('/admin/comment/{id}/delete', "AlaskaBlog\Controller\AdminController::deleteCommentAction")
->bind('admin_comment_delete');

// Ajouter un utilisateur
$app->match('/admin/user/add', "AlaskaBlog\Controller\AdminController::addUserAction")
->bind('admin_user_add');

// Modifier un utilisateur
$app->match('/admin/user/{id}/edit', "AlaskaBlog\Controller\AdminController::editUserAction")
->bind('admin_user_edit');

// Supprimer un utilisateur
$app->get('/admin/user/{id}/delete', "AlaskaBlog\Controller\AdminController::deleteUserAction")
->bind('admin_user_delete');


////////////////////////////////////////////////////////////////////////////////////////////

$app->match('/{id}/signalement', "AlaskaBlog\Controller\AdminController::SignalementCommentAction")->bind('comment_signalement');


//////////////////////////////////////////////////////////////////////////////////////////