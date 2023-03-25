<?php
/**
 * @link              https://github.com/FreelancerAMP
 * @since             1.0.0
 * @package           RPI
 *
 * @wordpress-plugin
 * Plugin Name:       RPI Kirchentagswürfel
 * Plugin URI:        https://github.com/rpi-virtuell/rpi-kt-cube
 * Description:       Plugin um AR-Würfel Funktionen zur Verfügung zu stellen
 * Requires Plugins:
 * Version:           1.0.0
 * Author:            Daniel Reintanz
 * Author URI:        https://github.com/FreelancerAMP
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       RPI
 * Domain Path:       /languages
 */

class KtCube
{


    public function __construct()
    {
        add_action('wp_head', array($this, 'force_redirect'));
        define('KTCUBE_ASSETS_URL', plugin_dir_url(__FILE__) . '/assets/');
        add_filter('the_content', array($this, 'addiframetocontent'));
        wp_enqueue_script('rpi-kt-cube-script', plugin_dir_url(__FILE__) . 'js/viewer.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('rpi-kt-cube-posts-script', plugin_dir_url(__FILE__) . 'js/rndposts.js', array('jquery'), '1.0.0', true);
        wp_enqueue_style('rpi-kt-cube-tootfeed', plugin_dir_url(__FILE__) . 'css/tootfeed.css');
        wp_enqueue_style('rpi-kt-cube-cam', plugin_dir_url(__FILE__) . 'css/cam.css');
        add_action('wp_head', array($this, 'head_scripts'));
        add_shortcode('ar_posts_shuffle', array($this, 'shuffle_ar_posts'));
        add_shortcode('display_mastodon_feed', array($this, 'display_mastodon_feed'));
        add_filter('feedzy_feed_items', array($this, 'filter_redundant_items'), 10, 2);
        add_action('pre_get_posts', array($this, 'allow_draft_preview'));
        add_action('wp_head', array($this, 'send_matrix_message'));
        add_action('wp_head', array($this, 'handle_matrix_requests'));
        add_filter('the_content', array($this, 'single_ar_posts'));


    }

    /**
     * intend to prepare message for Matrix Channel
     * fires neue_zeitansage Hook on first preview to send
     *
     * @return void
     */
    public function send_matrix_message()
    {
        if (isset($_GET['key']) && $_GET['key'] == 'guest' && is_singular('post') && get_post_status() === 'draft') {
            global $post;

            if (!get_post_meta($post->ID, 'matrix_info', true)) {

                $c = new stdClass();
                $c->permalink = get_permalink($post);
                $c->post_title = $post->post_title;
                $c->post_status = $post->post_status;
                $c->post_id = $post->ID;
                $c->post_edit_url = get_edit_post_link($post->ID);;
                $c->content = get_post_meta($post->ID, 'text', true);
                $c->author_name = get_post_meta($post->ID, 'author', true);

                update_post_meta($post->ID, 'matrix_info', 1);

                do_action('neue_zeitansage', $c);
            }

        }


    }

    public function head_scripts()
    {
        ?>
        <script>
            KtCube = {};
            KtCube.pluginUrl = '<?php echo plugin_dir_url(__FILE__) ?>';
            KtCube.assetsUrl = '<?php echo KTCUBE_ASSETS_URL ?>';
            KtCube.scalefactor = <?php echo get_option('options_scale_factor',4) ?>;
            KtCube.zoomfactor = <?php echo get_option('options_zoom_factor',0.3) ?>;
        </script>
        <?php
    }

    public function addiframetocontent($content)
    {
        if (get_post_type() == "post") {


            $id = get_the_ID();
            $model = get_post_meta(get_the_ID(), 'model', true);
            $font = get_post_meta(get_the_ID(), 'font', true);
            $text_color = urlencode(get_post_meta(get_the_ID(), 'text_color', true));
            $text = urlencode(get_post_meta(get_the_ID(), 'text', true));
            $text_scale = get_post_meta(get_the_ID(), 'text_scale', true);
            $author = get_post_meta(get_the_ID(), 'author', true);

            ob_start();
            ?>
            <iframe id="cam" frameBorder="0" style="height:90vh; width: 100%" src="<?php
            echo
                plugin_dir_url(__FILE__) . '/cam.php' .
                '?model=' . $model .
                '&id=' . $id .
                '&font=' . $font .
                '&text_color=' . $text_color .
                '&text=' . $text .
                '&text_scale=' . $text_scale .
                '&author=' . $author;
            ?>">
            </iframe>
            <?php
            return ob_get_clean();

        } else {
            return $content;
        }
    }

    public function shuffle_ar_posts()
    {
        $arposts = get_posts(array('numberposts' => -1));
        $arpostsarray = array();

        foreach ($arposts as $arpost) {
            $obj = new stdClass();
            $obj->id = $arpost->ID;
            $obj->model = get_post_meta($arpost->ID, 'model', true);
            $obj->font = get_post_meta($arpost->ID, 'font', true);
            $obj->scale = get_post_meta($arpost->ID, 'text_scale', true);
            $obj->color = get_post_meta($arpost->ID, 'text_color', true);
            $obj->text = get_post_meta($arpost->ID, 'text', true);
            $obj->author = get_post_meta($arpost->ID, 'author', true);
            $arpostsarray[] = $obj;
        }
        shuffle($arpostsarray);
        ob_start();
        ?>
        <iframe id="cam" frameBorder="0" style="height:90vh; width: 100%" src="<?php
        echo
            plugin_dir_url(__FILE__) . '/cam.php' .
            '?shuffle=on'
        ?>">
        </iframe>
        <script>
            const ARPosts =<?php echo json_encode($arpostsarray) ?>;
        </script>
        <?php
        return ob_get_clean();
    }
    public function single_ar_posts($return)
    {
        if(is_singular('post') ){

            $arpost = get_post(get_the_ID());

            $obj = new stdClass();
            $obj->id = $arpost->ID;
            $obj->model = get_post_meta($arpost->ID, 'model', true);
            $obj->font = get_post_meta($arpost->ID, 'font', true);
            $obj->scale = get_post_meta($arpost->ID, 'text_scale', true);
            $obj->color = get_post_meta($arpost->ID, 'text_color', true);
            $obj->text = get_post_meta($arpost->ID, 'text', true);
            $obj->author = get_post_meta($arpost->ID, 'author', true);
            $arpostsarray[] = $obj;
            ob_start();
            ?>
            <iframe id="cam" frameBorder="0" style="height:90vh; width: 100%; border: 0;" src="<?php
            echo
                plugin_dir_url(__FILE__) . '/cam.php'
            ?>">
            </iframe>
            <script>
                const ARPosts =<?php echo json_encode($arpostsarray) ?>;
            </script>
            <?php
            return ob_get_clean();
        }
        return $return;
    }

    public function display_mastodon_feed()
    {
        ob_start();
        ?>
        <body>
        <toot-feed>@zeitansagen@reliverse.social</toot-feed>

        <script src="<?php echo plugin_dir_url(__FILE__) ?>/js/tootfeed.js"></script>
        </body>
        <?php
        return ob_get_clean();
    }

    public function filter_redundant_items($items, $feedURL)
    {
        foreach ($items as $key => $item) {
            $zeitansagen = get_posts(array(
                'numberposts' => 1,
                'category' => 0,
                'orderby' => 'date',
                'order' => 'DESC',
                'include' => array(),
                'exclude' => array(),
                'meta_key' => 'feedzy_item_url',
                'meta_value' => $item->url,
                'post_type' => 'zeitansagen',));

            if (!empty($zeitansagen)) {
                unset($items[$key]);
            }
        }
        return $items;
    }

    public function allow_draft_preview($query)
    {
        if (isset($_GET['key']) && $_GET['key'] == 'guest') {
            if ($query->is_main_query()) {
                $query->set('post_status', array('publish', 'draft'));
            }
        }
    }

    public function force_redirect()
    {

        if (isset($_GET['key']) && $_GET['key'] == 'guest' && get_post_status() === 'publish') {
            wp_redirect(get_post_permalink());
        }

    }

    public function handle_matrix_requests()
    {
        if (is_user_logged_in() && current_user_can('delete_posts') && isset($_GET['do_delete']) && $_GET['do_delete'] == 'yes') {
            wp_update_post(array(
                'id' => get_the_ID(),
                'post_status' => 'trash'
            ));
        }
        if (is_user_logged_in() && current_user_can('publish_posts') && isset($_GET['do_publish']) && $_GET['do_publish'] == 'yes') {
            wp_update_post(array(
                'id' => get_the_ID(),
                'post_status' => 'publish'
            ));

        }
    }
}

new KtCube();
