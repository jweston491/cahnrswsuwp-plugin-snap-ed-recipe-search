<?php

namespace WSUWP\CAHNRSWSUWP_Plugins\SNAP_ED;

class CAHNRSWSUWP_Plugin_SNAP_ED_Recipe_Search {

	public function __construct() {
		$this->add_actions();
		$this->add_filters();
		$this->add_shortcodes();
	}

	private function add_actions() {

		add_action( 'plugins_loaded', array( $this, 'check_for_recipe' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
	}

	private function add_filters() {
		add_filter( 'category_template', array( $this, 'filter_category_template' ), 99 );
	}

	private function add_shortcodes() {
		add_shortcode( 'recipe_search', array( $this, 'recipe_search' ) );
	}

	public function register_scripts() {
		$css = plugin_dir_url( __FILE__ ) . 'css/style.min.css';
		wp_register_style( 'recipe-search', $css, false, false );
	}

	public function check_for_recipe() {
		// Leave if recipe category doesn't exist
		$current_theme = wp_get_theme();
		if ( ! term_exists( 'recipe', 'category' ) || 'CAHNRS WSUWP Ignite | WSUWP Spine Child Theme' !== $current_theme->name || 'CAHNRS WSUWP Ignite | WSUWP Spine Child Theme' !== $current_theme->parent_theme ) {
			return;
		}
	}

	public function filter_category_template( $template ) {
		// if ( is_category( 'recipe' ) ) {
		// 	$new_template = plugin_dir_path( __FILE__ ) . 'views/category-recipe.php';
		// 	if ( file_exists( $new_template ) ) {
		// 		return $new_template;
		// 	}
		// }
		return $template;
	}

	public function recipe_search() {

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$query_args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'category_name'  => 'recipe',
			'posts_per_page' => 12,
			'paged'          => $paged,
		);

		if ( isset( $_GET['search'] ) ) {
			$query_args['s'] = $_GET['search'];
		}

		if ( $query_args['category_name'] ) {

			wp_enqueue_style( 'recipe-search' );

			ob_start();

			include_once plugin_dir_path( __FILE__ ) . 'views/recipe-search.php';

			return ob_get_clean();
		}
	}
}

$cahnrswsuwp_plugin_snap_ed_recipe_search = new CAHNRSWSUWP_Plugin_SNAP_ED_Recipe_Search();
