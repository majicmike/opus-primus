<?php
/**
 * Opus Primus Navigation
 *
 * Controls for the navigation between multi-page posts, site pages, and menu
 * navigation structures.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2016, Opus Primus
 *
 * This file is part of Opus Primus.
 *
 * Opus Primus is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Class Opus Primus Navigation
 *
 * Provides most of the navigation methods for the Opus Primus theme
 *
 * @version     1.2.5
 * @date        June 15, 2014
 * Added new method `pagination` for moving between pages of posts
 *
 * @version     1.4
 * @date        April 5, 2015
 * Change `Opus_Primus_Navigation` to a singleton style class
 */
class Opus_Primus_Navigation {

	/**
	 * Set the instance to null initially
	 *
	 * @var $instance null
	 */
	private static $instance = null;

	/**
	 * Create Instance
	 *
	 * Creates a single instance of the class
	 *
	 * @package OpusPrimus
	 * @since   1.4
	 * @date    April 6, 2015
	 *
	 * @return null|Opus_Primus_Navigation
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}


	/**
	 * Constructor
	 */
	function __construct() {
	}


	/**
	 * Comments Navigation
	 *
	 * Displays a link between pages of comments
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     do_action
	 * @see     next_comments_link
	 * @see     previous_comments_link
	 */
	function comments_navigation() {

		do_action( 'opus_comments_link_before' ); ?>

		<p class="navigation comment-link cf">
			<span class="left"><?php previous_comments_link() ?></span>
			<span class="right"><?php next_comments_link() ?></span>
		</p>

		<?php
		do_action( 'opus_comments_link_after' );

	}


	/**
	 * List Pages
	 *
	 * Callback function for the wp_nav_menu call; accepts wp_nav_menu arguments
	 * passed through the callback function.
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/wp_page_menu
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   string|array $page_menu_args passed arguments for the method.
	 *
	 * @see     wp_list_pages
	 * @see     wp_parse_args
	 */
	function list_pages( $page_menu_args ) {

		$defaults       = array(
			'title_li' => '',
		);
		$page_menu_args = wp_parse_args( (array) $defaults, $page_menu_args );

		echo '<ul class="nav-menu">';

		wp_list_pages( $page_menu_args );

		echo '</ul><!-- .nav-menu -->';

	}


	/**
	 * Image Link Navigation
	 *
	 * Method to move between images when shown via the `image.php` template
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @see        __
	 * @see        apply_filters
	 * @see        do_action
	 * @see        esc_html
	 * @see        next_image_link
	 * @see        previous_image_link
	 *
	 * @version    1.2.5
	 * @date       July 24, 2014
	 * Renamed `Opus_Primus_Navigation::image_nav` to `Opus_Primus_Navigation::image_link_navigation`
	 * Added `opus_image_link_navigation_output` filter hook to provide access to navigation output
	 */
	function image_link_navigation() {

		do_action( 'opus_image_link_navigation_before' );

		/** Add navigation links between pictures in the gallery */
		$output = '<div class="opus-image-link-navigation cf">'
		          . previous_image_link( false, '<span class="left">' . __( 'Previous Photo', 'opus-primus' ) . '</span>' )
		          . next_image_link( false, '<span class="right">' . __( 'Next Photo', 'opus-primus' ) . '</span>' )
		          . '</div><!-- .opus-image-link-navigation -->';

		echo esc_html( apply_filters( 'opus_image_link_navigation_output', $output ) );

		do_action( 'opus_image_link_navigation_after' );

	}


	/**
	 * Multiple Pages Link
	 *
	 * Outputs the navigation structure to move between multiple pages from the
	 * same post. All parameters used by `wp_link_pages` can be passed through
	 * the function.
	 *
	 * @link       http://codex.wordpress.org/Function_Reference/wp_link_pages
	 * @example    multiple_pages_link( array( 'before' => '<p class="navigation link-pages cf">', 'after' => '</p>' ) );
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @param   string|array $link_pages_args arguments passed to method.
	 * @param   string       $preface         - leading word or phrase before display of post page index - MUST set $link_pages_args for this to display.
	 *
	 * @see        do_action
	 * @see        wp_link_pages
	 * @see        wp_parse_args
	 *
	 * @version    1.2.4
	 * @date       February 23, 2014
	 * Corrected typo in `'opus_links_pages_after'` hook
	 *
	 * @version    1.3.1
	 * @date       March 1, 2015
	 * Improved look of navigation links mimicking the site page navigation
	 */
	function multiple_pages_link( $link_pages_args = '', $preface = '' ) {

		$defaults        = array(
			'before'      => '<div class="navigation-pagination opus-link-pages"><span class="opus-link-pages-preface">' . $preface . '</span><ul class="page-numbers">',
			'after'       => '</ul></div>',
			'link_before' => '<li>',
			'link_after'  => '</li>',
		);
		$link_pages_args = wp_parse_args( (array) $defaults, $link_pages_args );

		/** Add empty hook before linking pages navigation of a multi-page post */
		do_action( 'opus_links_pages_before' );

		/** Linking pages navigation */
		wp_link_pages( $link_pages_args );

		do_action( 'opus_links_pages_after' );

	}


	/**
	 * Post Link
	 *
	 * Outputs the navigation structure to move between posts
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     do_action
	 * @see     next_posts_link
	 * @see     previous_posts_link
	 */
	function post_link() {

		do_action( 'opus_post_link_before' );

		/** Post link navigation */
		?>
		<hr class="pre-post-link-navigation" />
		<p class="navigation post-link cf">
			<span class="right"><?php next_post_link(); ?></span>
			<span class="left"><?php previous_post_link(); ?></span>
		</p>

		<?php
		do_action( 'opus_post_link_after' );

	}


	/**
	 * Posts Link
	 *
	 * Outputs the navigation structure to move between archive pages
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @see        do_action
	 * @see        next_posts_link
	 * @see        previous_posts_link
	 *
	 * @version    1.2.5
	 * @date       June 22, 2014
	 * Changed method to be explicitly public and static to address E-STRICT error if called by Child-Theme
	 */
	public static function posts_link() {

		do_action( 'opus_posts_link_before' );

		/** Posts link navigation */
		?>
		<p class="navigation posts-link cf">
			<span class="right"><?php next_posts_link(); ?></span>
			<span class="left"><?php previous_posts_link(); ?></span>
		</p>

		<?php
		do_action( 'opus_posts_link_after' );

	}


	/**
	 * Pagination
	 *
	 * Creates a pagination structure to navigate between site pages.
	 *
	 * @package     Opus_Primus
	 * @sub-package Navigation
	 * @since       1.2.5
	 *
	 * @see         (GLOBAL) $wp_query
	 * @see         get_option
	 * @see         get_pagenum_link
	 * @see         get_query_var
	 * @see         get_the_posts_pagination
	 *
	 * @return mixed|void
	 *
	 * @version     1.3.1
	 * @date        January 18, 2015
	 * Changed to use `get_the_posts_pagination`
	 *
	 * @version     1.4
	 * @date        March 31, 2015
	 * Ensure `$pagination` has been initialized
	 */
	function pagination() {

		$pagination = null;

		/** Get the current query object */
		global $wp_query;

		/** Get the total number of pages */
		$total = $wp_query->max_num_pages;

		/** Sanity check: is there more than one page? */
		if ( $total > 1 ) {

			/** Get the current page */
			if ( ! $current_page = get_query_var( 'paged' ) ) {
				$current_page = 1;
			}

			/** 'format' structure depends on Permalinks structure */
			if ( get_option( 'permalink_structure' ) ) {
				$format = 'page/%#%/';
			} else {
				$format = '?paged=%#%';
			}

			/** Results variable */
			$pagination = get_the_posts_pagination(
				array(
					'base'     => get_pagenum_link( 1 ) . '%_%',
					'format'   => $format,
					'current'  => $current_page,
					'total'    => $total,
					'mid_size' => 1,
					'type'     => 'list',
				)
			);

			$pagination = '<div class="navigation-pagination">' . $pagination . '</div>';

		}

		return apply_filters( 'opus_navigation_pagination', $pagination );

	}


	/**
	 * Pagination Wrapped
	 *
	 * Wraps the pagination method in action hooks
	 *
	 * @package        Opus_Primus
	 * @sub-package    Navigation
	 * @since          1.2.5
	 *
	 * @see            Opus_Primus_Navigation::pagination
	 * @see            do_action
	 * @see            esc_html
	 */
	function pagination_wrapped() {

		do_action( 'opus_navigation_pagination_before' );

		echo esc_html( $this->pagination() );

		do_action( 'opus_navigation_pagination_after' );

	}


	/**
	 * Primary Menu
	 *
	 * Primary navigation menu
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   string|array $primary_menu_args arguments passed to method.
	 *
	 * @see     do_action
	 * @see     wp_nav_menu
	 * @see     wp_parse_args
	 */
	function primary_menu( $primary_menu_args = '' ) {

		do_action( 'opus_primary_menu_before' );

		/** Primary Menu */
		$defaults          = array(
			'theme_location' => 'primary',
			'menu_class'     => 'nav-menu primary',
			'fallback_cb'    => array( $this, 'list_pages' ),
		);
		$primary_menu_args = wp_parse_args( (array) $defaults, $primary_menu_args );

		wp_nav_menu( $primary_menu_args );

		do_action( 'opus_primary_menu_after' );

	}


	/**
	 * Search Menu
	 *
	 * Search results navigation menu
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   string|array $search_menu_args arguments passed to method.
	 *
	 * @see     do_action
	 * @see     esc_html
	 * @see     search_page_menu
	 * @see     wp_nav_menu
	 * @see     wp_parse_args
	 */
	function search_menu( $search_menu_args = '' ) {

		do_action( 'opus_search_menu_before' );

		/** Search Menu */
		$defaults         = array(
			'theme_location' => 'search',
			'container'      => 'li',
			'menu_class'     => 'nav search',
			'fallback_cb'    => array( $this, 'search_page_menu' ),
		);
		$search_menu_args = wp_parse_args( (array) $defaults, $search_menu_args );

		echo esc_html( sprintf( '<ul class="featured search pages"><li><span class="title">%1$s</span>', __( 'Featured Pages:', 'opus-primus' ) ) );

		wp_nav_menu( $search_menu_args );

		echo '</li></ul><!-- .featured-search-pages -->';

		do_action( 'opus_search_menu_after' );

	}


	/**
	 * Search Page Menu
	 *
	 * Callback function for the menu
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   string|array $list_args arguments passed to method.
	 *
	 * @see     wp_page_menu
	 * @see     wp_parse_args
	 */
	function search_page_menu( $list_args = '' ) {

		$defaults  = array(
			'depth'     => 1,
			'show_home' => true,
		);
		$list_args = wp_parse_args( (array) $defaults, $list_args ); ?>

		<ul class="nav search">
			<?php wp_page_menu( $list_args ); ?>
		</ul><!-- .nav.search -->

	<?php }


	/** --- Future Usage ---------------------------------------------------- */


	/**
	 * Secondary Menu
	 *
	 * Secondary navigation menu pre-configured and available for use in
	 * Child-Themes or as part of other customizations and/or modifications.
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @param   string|array $secondary_menu_args arguments passed to method.
	 *
	 * @see      do_action
	 * @see      wp_nav_menu
	 * @see      wp_parse_args
	 */
	function secondary_menu( $secondary_menu_args = '' ) {

		do_action( 'opus_secondary_menu_before' );

		/** Secondary Menu */
		$defaults            = array(
			'theme_location' => 'secondary',
			'menu_class'     => 'nav-menu secondary',
			'fallback_cb'    => array( $this, 'list_pages' ),
		);
		$secondary_menu_args = wp_parse_args( (array) $defaults, $secondary_menu_args );

		wp_nav_menu( $secondary_menu_args );

		do_action( 'opus_secondary_menu_after' );
	}
}
