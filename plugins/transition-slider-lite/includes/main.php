<?php

/*plugin class*/
class TransitionSlider {

	public $PLUGIN_VERSION;
	public $PLUGIN_DIR_URL;
	public $PLUGIN_DIR_PATH;

	// Singleton
	private static $instance = null;

	public static function get_instance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	protected function __construct() {
		$this->add_actions();
		register_activation_hook($this->my_plugin_basename(), array( $this, 'activation_hook' ) );
	}

	public function activation_hook($network_wide) {
	}

	public function enqueue_scripts() {
        wp_register_style( "transitionslider-animate-css", $this->PLUGIN_DIR_URL."css/animate.min.css", array(), $this->PLUGIN_VERSION);
		wp_register_style( "transitionslider-css", $this->PLUGIN_DIR_URL."css/style.min.css" , array(), $this->PLUGIN_VERSION);
		wp_register_style( "transitionslider-swiper-css", $this->PLUGIN_DIR_URL."css/swiper.min.css" , array(), $this->PLUGIN_VERSION);
		wp_register_style( "transitionslider-fontawesome-css", "https://use.fontawesome.com/releases/v5.8.2/css/all.css" , array(), $this->PLUGIN_VERSION);

        wp_register_script("transitionslider-lib-three", $this->PLUGIN_DIR_URL."js/lib//three.min.js", array('jquery'), $this->PLUGIN_VERSION);
        wp_register_script("transitionslider-lib-swiper", $this->PLUGIN_DIR_URL."js/lib/swiper.min.js", array('jquery'), $this->PLUGIN_VERSION);
        wp_register_script("transitionslider-lib-tween", $this->PLUGIN_DIR_URL."js/lib/Tween.min.js", array('jquery'), $this->PLUGIN_VERSION);
        wp_register_script("transitionslider-lib-webfontloader", $this->PLUGIN_DIR_URL."js/lib/webfontloader.js", array('jquery'), $this->PLUGIN_VERSION);

		wp_register_script("transitionslider-embed", $this->PLUGIN_DIR_URL."js/embed.js", array('jquery'), $this->PLUGIN_VERSION);
        wp_register_script("transitionslider-build", $this->PLUGIN_DIR_URL."js/build/transitionSlider.min.js", array('jquery'), $this->PLUGIN_VERSION);

	}

	public function admin_enqueue_scripts() {

		$this->enqueue_scripts();

	    wp_register_script("transitionslider-admin", $this->PLUGIN_DIR_URL."js/plugin_admin.js", array('transitionslider-layer-renderer', 'jquery', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-resizable'),$this->PLUGIN_VERSION);
	    wp_register_script("transitionslider-layer-renderer", $this->PLUGIN_DIR_URL."js/layer-renderer.js", array('jquery'),$this->PLUGIN_VERSION);
	    wp_register_script('transitionslider-sliders', $this->PLUGIN_DIR_URL."js/sliders.js", array('jquery'), $this->PLUGIN_VERSION);
	     wp_register_script('transitionslider-alpha-color-picker', $this->PLUGIN_DIR_URL.'js/alpha-color-picker.min.js', array( 'jquery', 'wp-color-picker' ), $this->PLUGIN_VERSION, true);

	    wp_register_style('transitionslider-alpha-color-picker-css', $this->PLUGIN_DIR_URL. 'css/alpha-color-picker.min.css', array( 'wp-color-picker'), $this->PLUGIN_VERSION);
	    wp_register_style('transitionslider-edit-slider-css', $this->PLUGIN_DIR_URL."css/transition-slider.min.css", array('transitionslider-alpha-color-picker-css'), $this->PLUGIN_VERSION);
	}

	protected function get_translation_array() {
		return Array(
            'objectL10n' => array(
                'loading' => esc_html__('Loading...', 'transitionslider')

            ));
	}

	public function admin_link($links) {
		array_unshift($links, '<a href="' . get_admin_url() . 'options-general.php?page=sliders">Admin</a>');
		return $links;
	}


	public function admin_menu() {

		add_options_page(
			esc_html__("Transition Slider Admin", "stx"),
			esc_html__("Transition Slider", "stx"),
			"publish_posts",
			"transition_slider_admin",
			array($this,"transition_slider_admin")
		);

		add_menu_page(
			esc_html__("Transition Slider", "stx"), //page title
			esc_html__("Transition Slider", "stx"), // menu title
			'publish_posts', //capability
			'transition_slider_admin',//menu slug
			array($this,'transition_slider_admin'), // function
			'dashicons-image-flip-horizontal' // icon
		);

		add_submenu_page(
			'transition_slider_admin',
			esc_html__("Sliders", "stx"),
			esc_html__("Sliders", "stx"),
		    'publish_posts',
		    'transition_slider_admin',
		    array($this,'transition_slider_admin')
		);

		add_submenu_page(
			'transition_slider_admin',
			esc_html__("Add new Slider", "stx"),
			esc_html__("Add new Slider", "stx"),
		    'publish_posts',
		    'transitionslider_add_new',
		    array($this,'transitionslider_add_new')
		);


		// Gutenberg block
		if (function_exists('register_block_type')) {

			// Register block, and explicitly define the attributes we accept.
			register_block_type( 'transitionslider/embed', array(
				'attributes' => array(
					'id' => array(
						'type' => 'string',
					)
				),
			) );

			add_action( 'enqueue_block_assets', array($this,'enqueue_block_assets'));
			add_action( 'enqueue_block_editor_assets', array($this,'enqueue_block_editor_assets'));

		}

	}

	public function transitionslider_add_new(){
		$_GET['action'] = "add_new";
		$this->transition_slider_admin();
	}

	public function enqueue_block_assets(){

	}

	public function enqueue_block_editor_assets(){

		wp_enqueue_script("transitionslider-blocks-js", $this->PLUGIN_DIR_URL."js/blocks-editor.min.js", array( 'wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element'), $this->PLUGIN_VERSION);

		$slider_ids = get_option('transitionslider_ids');

		$slider_names = array();

			foreach ($slider_ids as $id) {
				$_s = get_option('transitionslider_'.$id);
				array_push($slider_names, $_s["instanceName"]);
			}

		wp_localize_script( 'transitionslider-blocks-js','slider_ids', json_encode($slider_ids) );
		wp_localize_script( 'transitionslider-blocks-js','slider_names', json_encode($slider_names) );

	}

	//options page
	public function transition_slider_admin(){

		include_once( plugin_dir_path(__FILE__).'admin-actions.php' );

    }

	public function init() {
		add_shortcode( 'transitionslider', array($this, 'on_shortcode') );

	}

	public function plugins_loaded() {
		load_plugin_textdomain( 'transitionslider', false, dirname($this->my_plugin_basename()).'/lang/' );
	}

	protected function add_actions() {

		add_action('plugins_loaded', array($this, 'plugins_loaded') );

		add_action('init', array($this, 'init') );

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 5, 0 );

		if (is_admin()) {
			add_action('admin_menu', array($this, 'admin_menu'));
	        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'admin_link'));

            add_action( 'wp_ajax_transitionslider_save', array($this, 'save_slider') );
            add_action( 'wp_ajax_nopriv_transitionslider_save', array($this, 'save_slider') );

            add_action( 'wp_ajax_transitionslider_duplicate', array($this, 'duplicate_slider') );
            add_action( 'wp_ajax_nopriv_transitionslider_duplicate', array($this, 'duplicate_slider') );

            add_action( 'wp_ajax_transitionslider_delete', array($this, 'delete_slider') );
            add_action( 'wp_ajax_nopriv_transitionslider_delete', array($this, 'delete_slider') );

            add_action( 'wp_ajax_transitionslider_import', array($this, 'import_slider') );
            add_action( 'wp_ajax_nopriv_transitionslider_import', array($this, 'import_slider') );

            add_action( 'wp_ajax_transitionslider_export', array($this, 'export_sliders') );
            add_action( 'wp_ajax_nopriv_transitionslider_export', array($this, 'export_sliders') );

            add_action( 'wp_ajax_transitionslider_get_slider', array($this, 'get_slider') );
            add_action( 'wp_ajax_nopriv_transitionslider_get_slider', array($this, 'get_slider') );

            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );

		}
	}

	public function on_shortcode($atts, $content=null) {

		$args = shortcode_atts(
			array(
				'id' => '-1',
                'name' => '-1',
				'width' =>'-1',

				'height' =>'-1',
				'heighttablet' =>'-1',
				'heightmobile' =>'-1',

				'responsive' =>'-1',

				'ratio' =>'-1',
				'ratiotablet' =>'-1',
				'ratiomobile' =>'-1',

				'fullscreen' =>'-1',

				'size' =>'-1',

				'transition' =>'-1',
				'duration' =>'-1',
				'direction' =>'-1',
				'brightness' =>'-1',
				'easing' =>'-1',
				'distance' =>'-1',

			),
			$atts
		);

        $id = (int) $args['id'];
		$name = $args['name'];

		if($name != -1){
			$slider_ids = get_option('transitionslider_ids');

			foreach ($slider_ids as $id) {
				$_s = get_option('transitionslider_'.$id);
				if($_s && $_s['instanceName'] == $name){
					$slider = $_s;
					$id = $slider['id'];
					break;
				}
			}
		}else if($id != -1){
			$slider = get_option('transitionslider_'.$id);
		}

		$newSlides = array();

		foreach ($slider["slides"] as $slide) {

			if($args['transition'] != '-1')
				$slide['transitionEffect'] = $args['transition'];

			if($args['duration'] != '-1')
				$slide['transitionDuration'] = $args['duration'];

			if($args['direction'] != '-1')
				$slide['direction'] = $args['direction'];

			if($args['brightness'] != '-1')
				$slide['brightness'] = $args['brightness'];

			if($args['distance'] != '-1')
				$slide['distance'] = $args['distance'];

			if($args['easing'] != '-1')
				$slide['easing'] = $args['easing'];

			array_push($newSlides, $slide);
		}

		$slider['slides'] = $newSlides;

		if($args['ratio'] != -1) $slider['ratio'] = $args['ratio'];
		if($args['ratiotablet'] != -1) $slider['ratioTablet'] = $args['ratiotablet'];
		if($args['ratiomobile'] != -1) $slider['ratioMobile'] = $args['ratiomobile'];
		if($args['responsive'] != -1) $slider['responsive'] = $args['responsive'];
		if($args['fullscreen'] != -1) $slider['fullscreen'] = $args['fullscreen'];
		if($args['height'] != -1) $slider['height'] = $args['height'];
		if($args['heighttablet'] != -1) $slider['heightTablet'] = $args['heighttablet'];
		if($args['heightmobile'] != -1) $slider['heightMobile'] = $args['heightmobile'];

		if($args['size'] == "fixed") {
			$slider['responsive'] = false;
			$slider['fullscreen'] = false;
		}

		if($args['size'] == "responsive") {
			$slider['responsive'] = true;
			$slider['fullscreen'] = false;
		}

		if($args['size'] == "fullscreen") {
			$slider['fullscreen'] = true;
		}

        $slider['rootFolder'] = $this->PLUGIN_DIR_URL."";

        $output = '<div style="display: none;" class="slider_instance">'. htmlentities(wp_json_encode($slider)) .'</div>';

        wp_enqueue_script("transitionslider-lib-three");
		wp_enqueue_script("transitionslider-lib-swiper");
		wp_enqueue_script("transitionslider-lib-tween");
		wp_enqueue_script("transitionslider-lib-webfontloader");
		wp_enqueue_script("transitionslider-build");

	    wp_enqueue_style('transitionslider-animate-css');
	    wp_enqueue_style( "transitionslider-css");
	    wp_enqueue_style( "transitionslider-swiper-css");
	    wp_enqueue_style( "transitionslider-fontawesome-css");

	    wp_enqueue_script("transitionslider-embed");

		return $output;

	}

	public function sanitize_array($arr){
	   foreach ($arr as $key => $val) {

	      if(is_array($val))
	        $arr[$key] = $this->sanitize_array($val);
	      else
	        $arr[$key] = sanitize_textarea_field($val);

	   }

	   return $arr;
	}

	public function save_slider() {

        check_ajax_referer( 'stx_nonce', 'security' );

		$current_id = $page_id = '';

		$json = stripslashes($_POST['slider']);

        $slider = slider_objectToArray(json_decode($json));

		if (isset($_POST['id']) ) {
			$current_id = $_POST['id'];
		}

		$slider_ids = get_option('transitionslider_ids');
		if(!$slider_ids){
			$slider_ids = array();
		}
		$sliders = array();
		foreach ($slider_ids as $id) {
			$_slider = get_option('transitionslider_'.$id);
			if($_slider){
				$sliders[$id] = $_slider;
			}else{
				//remove id from array
				$slider_ids = array_diff($slider_ids, array($id));
			}
		}

		if ($slider['status'] == 'draft') {
			array_push($slider_ids,$current_id);
			add_option('transitionslider_'.$current_id, array());
			$sliders[$current_id] = array();
		}

		update_option('transitionslider_ids', $slider_ids);

		$new = array_merge($sliders[$current_id], $slider);
		$sliders[$current_id] = $new;

		$sliders[$current_id]['status'] = 'published';

		update_option('transitionslider_'.$current_id, $sliders[$current_id]);

		// echo json_encode($new);
	    // echo json_encode($sliders[$current_id]);

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	public function duplicate_slider() {

        check_ajax_referer( 'stx_nonce', 'security' );

        $current_id = sanitize_text_field($_POST['currentId']);

        $new_id = 0;
        $highest_id = 0;

        $slider_ids = get_option('transitionslider_ids');

        foreach ($slider_ids as $id) {
            if((int)$id > $highest_id) {
                $highest_id = (int)$id;
            }
        }
        $new_id = $highest_id + 1;

        $current =  get_option('transitionslider_'.(string)$current_id);

        $new = $current;
        $new["id"] = $new_id;
        $new["name"] = $current["name"]." (copy)";
        $new["instanceName"] = $current["instanceName"]." (copy)";

        $new["date"] = current_time( 'mysql' );

        delete_option('transitionslider_'.(string)$new_id);
        add_option('transitionslider_'.(string)$new_id,$new);

        array_push($slider_ids,$new_id);

        delete_option('transitionslider_ids');
        add_option('transitionslider_ids',$slider_ids);

        wp_die();

    }

    public function delete_slider() {

        check_ajax_referer( 'stx_nonce', 'security' );

        $slider_ids = get_option('transitionslider_ids');

        $current_id = sanitize_text_field($_POST['currentId']);

        if($current_id){

            $ids = explode(',', $current_id);

            foreach ($ids as $id) {
              delete_option('transitionslider_'.(string)$id);
            }
            $slider_ids = array_diff($slider_ids, $ids);
            update_option('transitionslider_ids', $slider_ids);

        }else{

            foreach ($slider_ids as $id) {
              delete_option('transitionslider_'.(string)$id);
            }

            delete_option('transitionslider_ids');

        }

        wp_die();

    }

        public function export_sliders() {

        check_ajax_referer( 'stx_nonce', 'security' );

        $slider_ids = get_option('transitionslider_ids');

        $current_id = sanitize_text_field($_POST['currentId']);

        $arr = array();

        if($current_id){

            $ids = explode(',', $current_id);

            foreach ($ids as $id) {

		        $slider = get_option('transitionslider_'.$id);
		        if($slider){
		            $arr[$id] = $slider;
		        }

            }

        }else{

            foreach ($slider_ids as $id) {
            	$slider = get_option('transitionslider_'.$id);
		        if($slider){
		            $arr[$id] = $slider;
		        }

            }

        }

        echo(json_encode($arr));

        wp_die();

    }

    public function import_slider() {

        check_ajax_referer( 'stx_nonce', 'security' );

        $json = stripslashes($_POST['slider']);

        $slider = slider_objectToArray(json_decode($json));

        // generate ID
        $new_id = 0;
        $highest_id = 0;

        $slider_ids = get_option('transitionslider_ids');

        foreach ($slider_ids as $id) {
            if((int)$id > $highest_id) {
                $highest_id = (int)$id;
            }
        }

        $new_id = $highest_id + 1;

        $upload_dir = wp_upload_dir();
		$slidersFolder = $upload_dir['basedir'] . '/transition-slider/';
		$sliderFolder = $slidersFolder . 'slider_' . $new_id . '/';

		$slidersUrl = $upload_dir['baseurl'] . '/transition-slider/';
		$sliderUrl = $slidersUrl. 'slider_' . $new_id . '/';

		if (!file_exists($slidersFolder)) {
			mkdir($slidersFolder, 0777, true);
		}

		if (!file_exists($sliderFolder)) {
			mkdir($sliderFolder, 0777, true);
		}

        foreach ($slider["slides"] as $key => $slide) {
        	$src = $slide['src'];

        	$info = pathinfo($slide['src']);
        	$fileName = $info['basename'];

			$newPath = $sliderFolder . $fileName ;

			if ( copy($src, $newPath) ) {
			    echo "Copy success!";
			}else{
			    echo "Copy failed.";
			}

			$slider['slides'][$key]['src'] = $sliderUrl . $fileName ;

        }

        $slider['id'] = $new_id;
        $slider["date"] = current_time( 'mysql' );
        $sliders[$new_id] = $slider;

		update_option('transitionslider_'.$new_id, $sliders[$new_id]);

		array_push($slider_ids,$new_id);

        delete_option('transitionslider_ids');
        add_option('transitionslider_ids',$slider_ids);

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	public function get_slider() {

        check_ajax_referer( 'stx_nonce', 'security' );

        $current_id = sanitize_text_field($_POST['currentId']);

        $s = get_option('transitionslider_'.$current_id);

        echo(json_encode($s));

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	protected function my_plugin_basename() {
		$basename = plugin_basename(__FILE__);
		if ('/'.$basename == __FILE__) { // Maybe due to symlink
			$basename = basename(dirname(__FILE__)).'/'.basename(__FILE__);
		}
		return $basename;
	}

	protected function my_plugin_url() {
		$basename = plugin_basename(__FILE__);
		if ('/'.$basename == __FILE__) { // Maybe due to symlink
			return plugins_url().'/'.basename(dirname(__FILE__)).'/';
		}
		// Normal case (non symlink)
		return plugin_dir_url( __FILE__ );
	}
}
if(!function_exists("trace_stx")){

	function trace_stx($var){
		echo("<pre style='z-index:999999;background:#fcc;color:#000;font-size:12px;'>");
		print_r($var);
		echo("</pre>");
	}

}

if(!function_exists("slider_objectToArray")){

	function slider_objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}

		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}

}
