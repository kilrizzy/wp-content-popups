<?php

class ContentPopup
{
    public $id;
    public $title;
    public $date;
    public $post;
    public $postUrl;
    public $url;
    public $content;

    public function __construct($post = false)
    {
        if ($post) {
            $this->post = $post;
            $this->setupFromPost();
        }
    }

    public function setupFromPost()
    {
        $this->id = $this->post->ID;
        $this->title = $this->post->post_title;
        $this->date = $this->post->post_date;
        $this->postUrl = get_post_permalink($this->id);
        $this->url = trim($this->post->post_excerpt);
        $this->slug = get_post_meta($this->id, 'slug', true);
        $this->content = get_the_content('...Read More');
        $this->content = apply_filters('the_content', $this->content);
        $this->content = str_replace(']>', ']]&gt;', $this->content);
    }

    public static function getBySlug($slug)
    {
        $posts = self::getAll();
        if (!empty($slug)) {
            foreach ($posts as $post) {
                if ($post->slug == $slug) {
                    return $post;
                }
            }
        }
        return false;
    }

    public static function getByTitle($title)
    {
        $posts = self::getAll();
        if (!empty($title)) {
            foreach ($posts as $post) {
                if ($post->title == $title) {
                    return $post;
                }
            }
        }
        return false;
    }

    public function getMostRecent()
    {
        $args = array(
            'post_type' => 'contentpopup',
            'posts_per_page' => '1',
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $this->post = $query->posts[0];
            $this->setupFromPost();
        }
    }

    public function getByPostId($id)
    {
        $args = array(
            'post_type' => 'contentpopup',
            'posts_per_page' => '1',
            'p' => $id
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $this->post = $query->posts[0];
            $this->setupFromPost();
        }
    }

    public static function getAll($argOverrides = array())
    {
        $posts = array();
        $args = array(
            'post_type' => 'contentpopup',
            'posts_per_page' => '-1',
            'orderby' => 'menu_order',
            'order' => 'ASC',
        );
        $args = array_merge($args, $argOverrides);
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $posts[] = new static($query->post);
            }
        }
        return $posts;
    }

}