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
 * Version:           1.0.1
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
        add_filter('the_content', array($this, 'addiframetocontent'));
    }

    public function addiframetocontent($content)
    {
        if (get_post_type() == "post") {

            $model = get_post_meta(get_the_ID(), 'model', true);
            $font = get_post_meta(get_the_ID(), 'font', true);
            $text = urlencode(get_post_meta(get_the_ID(), 'text', true));

            ob_start();
            ?>
            <iframe src="<?php
            echo
                'https://ktwu.rpi-virtuell.de/wp-content/ktwu-iframe/cam.php' .
                '?model=' . $model .
                '&font=' . $font .
                '&text=' . $text;
            ?>"> height="400">
            </iframe>
            <?php
            return ob_get_clean();

        }
        return $content;
    }
}
