<?php
/**
 * Image Template
 * Displays as the attachment template when an image is attached to the post
 * or gallery.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2013, Opus Primus
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

global $post, $opus_navigation, $opus_structures, $opus_posts, $opus_images;
get_header( 'image' );

/** Add empty hook before content */
do_action( 'opus_before_content' ); ?>

<div class="content-wrapper cf">

    <?php
    /** Add empty hook at top of the content */
    do_action( 'opus_content_top' );

    /** Open the necessary layout CSS classes */
    echo $opus_structures->layout_open();

    /** Add empty action before the_Loop */
    do_action( 'opus_before_the_loop' ); ?>

    <div class="the-loop">

        <?php
        /** Add before loop sidebar */
        if ( is_active_sidebar( 'before-loop' ) ) { dynamic_sidebar( 'before-loop' ); }

        $opus_navigation->post_link();

        /** the_Loop - Start */
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();

                /** Display the post */ ?>
                <div <?php post_class(); ?>>

                    <?php
                    /** Make it clear this is an attachment being displayed */
                    printf( '<h2 id="attachment-notice">'
                        . __( 'You are viewing an image attached to %1$s', 'opusprimus' )
                        . '</h2>',
                        '<a href="' . get_permalink( $post->post_parent ) . '">' . get_the_title( $post->post_parent ) . '</a>'
                    );

                    $opus_posts->post_byline( array( 'show_mod_author' => true, 'anchor' => __( 'Displayed', 'opusprimus' ) ) );
                    $opus_navigation->image_nav();

                    /** Image Title from media library */
                    $opus_images->image_title();

                    /** Image Caption from media library */
                    $opus_posts->post_excerpt();

                    /** Show the image with link to original */
                    $size = 'large';
                    echo '<div class="attached-image"><a href="' . wp_get_attachment_url( $post->ID ) . '">' . wp_get_attachment_image( $post->ID, $size ) . '</a></div>';

                    /** Image Description from media library */
                    $opus_posts->post_content();

                    /** Image meta data */
                    $opus_images->display_exif_table();

                    /** End of Post */
                    $opus_posts->post_coda();

                    /** Start comments section */
                    comments_template(); ?>

                </div><!-- post classes -->

            <?php
            } /** End while - have posts */
        } else {
            $opus_structures->no_search_results();
        } /** End if - have posts */
        /** the_Loop - End */

        /** Add after loop sidebar */
        if ( is_active_sidebar( 'after-loop' ) ) { dynamic_sidebar( 'after-loop' ); } ?>

    </div><!-- #the-loop -->

    <?php
    /** Add empty action after the_Loop */
    do_action( 'opus_after_the_loop' );

    get_sidebar( 'image' );

    echo $opus_structures->layout_close();

    /** Add empty hook at the bottom of the content */
    do_action( 'opus_content_bottom' ); ?>

</div><!-- #content-wrapper -->

<?php
/** Add empty hook after the content */
do_action( 'opus_after_content' );

get_footer( 'image' );