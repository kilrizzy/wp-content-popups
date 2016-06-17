<?php

class ContentPopups
{

    public $pluginDir = __DIR__;
    public $pluginPath;

    public $optionSections;
    public $sitemapPath;
    public $sitemapIndexPath;
    public $sitemapURISeparator;

    public function __construct($options = [])
    {
        if (isset($options['pluginDir'])) {
            $this->pluginDir = $options['pluginDir'];
        }
        if (isset($options['pluginPath'])) {
            $this->pluginPath = $options['pluginPath'];
        }

        add_action('init', array($this, 'init'));
    }

    public function init()
    {
        $this->createContentPopupsPostType();
        add_action('wp_enqueue_scripts',  array($this, 'enqueueAssets'), 999);
        add_action('wp_footer',  array($this, 'addPopupsToFooter'), 999);
    }

    public function enqueueAssets()
    {
        global $wp_styles;

        if (!is_admin()) {
            print_r(get_template_directory_uri());
            wp_register_style('colorbox-css', $this->pluginPath . '/resources/colorbox/example1/colorbox.css', array(), '', 'all');
            wp_register_script('colorbox-js', $this->pluginPath  . '/resources/colorbox/jquery.colorbox-min.js', array('jquery'), '', false);
            wp_enqueue_script('colorbox-js');
            wp_enqueue_style('colorbox-css');
        }

    }

    public function addPopupsToFooter(){
        $output = array();
        $contentPopups = ContentPopup::getAll();
        $template = new ContentPopupsTemplate();
        $templateResponse = $template->get($this->pluginDir . '/templates/footer.php', array('contentPopups' => $contentPopups));
        $output[] = $templateResponse;
        $output = implode("\n", $output);
        echo $output;
    }

    public function createContentPopupsPostType()
    {
        $postType = new ContentPopupsPostType();
        $postType->name = 'contentpopup';
        $postType->urlSlug = 'contentpopup';
        $postType->labelPlural = 'Content Popups';
        $postType->labelSingular = 'Content Popup';
        $postType->iconCSSContent = '\f130';
        $postType->supports = array(
            'title',
            'editor',
        );
        $postType->create();
    }

}