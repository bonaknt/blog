<?php

namespace AlaskaBlog\DAO;

use AlaskaBlog\Domain\Comment;

class CommentDAO extends DAO 
{
    // ...

    /** 
     * Saves a comment into the database.
     *
     * @param \AlaskaBlog\Domain\Comment $comment The comment to save
     */
    public function save(Comment $comment) {
        $commentData = array(
            'art_id' => $comment->getArticle()->getId(),
            'usr_name' => $comment->getAuthor(),
            'com_content' => $comment->getContent(),
            'signalement' => $comment->getSignalement(),
            'parent_id' => $comment->getParentId()
            );

        if ($comment->getId()) {
            // The comment has already been saved : update it
            $this->getDb()->update('t_comment', $commentData, array('com_id' => $comment->getId()));
        } else {
            // The comment has never been saved : insert it
            $this->getDb()->insert('t_comment', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }
    
    /**
     * @var \AlaskaBlog\DAO\ArticleDAO
     */
    private $articleDAO;

    /**
     * @var \AlaskaBlog\DAO\UserDAO
     */
    private $userDAO;

    public function setArticleDAO(ArticleDAO $articleDAO) {
        $this->articleDAO = $articleDAO;
    }

    public function setUserDAO($userDAO) {
        $this->userDAO = $userDAO;
    }



    /**
     * Removes all comments for a user
     * 
     * @param integer $userId The id of the user
     */
    public function deleteAllByUser($userId) {
        $this->getDb()->delete('t_comment', array('usr_id' => $userId));
    }


    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id The comment id
     *
     * @return \MicroCMS\Domain\Comment|throws an exception if no matching comment is found
     */
    public function find($id) {
        $sql = "select * from t_comment where com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);
    }

    // ...

    /**
     * Removes a comment from the database.
     *
     * @param @param integer $id The comment id
     */
    public function delete($id) {
        // Delete the comment
        $this->getDb()->delete('t_comment', array('com_id' => $id));
        $this->getDb()->delete('t_comment', array('parent_id' => $id));
    }
        /**
     * Removes all comments for an article
     *
     * @param $articleId The id of the article
     */
    public function deleteAllByArticle($articleId) {
        $this->getDb()->delete('t_comment', array('art_id' => $articleId));
    }
    /**
     * Return a list of all comments for an article, sorted by date (most recent last).
     *
     * @param integer $articleId The article id.
     *
     * @return array A list of all comments for the article.
     */
    public function findAllByArticle($articleId) {
        // The associated article is retrieved only once
        $article = $this->articleDAO->find($articleId);

        // art_id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "select com_id, com_content, usr_name, parent_id, signalement from t_comment where art_id=? order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($articleId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
            $comment = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            $comment->setArticle($article);
            $comments[$comId] = $comment;
        }
        return $comments;
    }

    /**
     * Permet de récupérer les commentaires avec les enfants
     * @param $post_id
     * @param bool $unset_children Doit-t-on supprimer les commentaire qui sont des enfants des résultats ?
     * @return array
     */
    public function findAllWithChildren($articleId, $unset_children = true)
    {
        // On a besoin de 2 variables
        // comments_by_id ne sera jamais modifié alors que comments
        $comments_child = $comments = $this->findAllByArticle($articleId);
        foreach ($comments_child as $comId => $comment) {
            if ($comment->getParentId() != 0) {
                $comments[$comment->getParentId()]->children[] = $comment;
                $commentaire = new Comment();
                $commentaire->setChildren($comments[$comment->getParentId()]->children);
                if ($unset_children) {
                    unset($comments_child[$comId]);
                }
            }
        }
        return $comments_child;
    }



    public function findAll() {
        $sql = "select * from t_comment order by com_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }
    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \AlaskaBlog\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);
        $comment->setAuthor($row['usr_name']);
        $comment->setParentId($row['parent_id']);
        $comment->setSignalement($row['signalement']);
        if (array_key_exists('art_id', $row)) {
            // Find and set the associated article
            $articleId = $row['art_id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticle($article);
        }
        
        return $comment;
    }
}