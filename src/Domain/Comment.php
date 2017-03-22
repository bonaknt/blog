<?php

namespace AlaskaBlog\Domain;

class Comment {


    private $parent_id;



    /**
     * Comment id.
     *
     * @var integer
     */
    private $id;

    /**
     * Comment author.
     *
     * @var string
     */
    private $author;

    /**
     * Comment content.
     *
     * @var integer
     */
    private $content;

    /**
     * Associated article.
     *
     * @var \AlaskaBlog\Domain\Article
     */
    private $article;

    private $signalement;

    public $children;

    public function getSignalement() {
        return $this->signalement;
    }

    public function setSignalement($signaler) {
        $this->signalement = $signaler;
        return $this;
    }

    public function getChildren() {
        return $this->children;
    }

    public function setChildren($child) {
        $this->children = $child;
        return $this;
    }

    public function getParentId() {
        return $this->parent_id;
    }

    public function setParentId($parent_id) {
        $this->parent_id = $parent_id;
        return $this;
    }


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(Article $article) {
        $this->article = $article;
        return $this;
    }
}