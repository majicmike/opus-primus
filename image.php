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
 * @copyright   Copyright (c) 2012, Opus Primus
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

global $post, $opus_nav, $opus_structure, $opus_gallery;
get_header( 'image' ); ?>

<div class="content-wrapper">

    <?php echo $opus_structure->layout_open(); ?>

    <div class="the-loop">

        <?php
        $opus_nav->opus_post_link();
        if ( have_posts() ):
            while ( have_posts() ):
                the_post();

                /** Display the post */ ?>
                <div <?php post_class(); ?>>

                    <?php
                    // get_template_part( 'loops/opus-primus', get_post_format() );

                    /** Provide a link back to the gallery post with text and gallery post title */
                    // echo '<a href="' . get_permalink( $post->post_parent ) . '">' . '&laquo; ' . __( 'Go back to the gallery post:', 'opusprimus' ) . '</a>';
                    // echo '<h1>' . get_the_title( $post->post_parent ) . '</h1>';

                    /** Make it clear this is an attachment being displayed */
                    printf( '<h2 id="attachment-notice">'
                        . __( 'You are viewing an image attached to %1$s', 'opusprimus' )
                        . '</h2>',
                        '<a href="' . get_permalink( $post->post_parent ) . '">' . get_the_title( $post->post_parent ) . '</a>'
                    );

                    $opus_structure->post_byline( array( 'show_mod_author' => true ) );
                    $opus_nav->image_nav();

                    /** Show the image with link to original */
                    $size = 'large';
                    echo '<div class="attached-image"><a href="' . wp_get_attachment_url( $post->ID ) . '">' . wp_get_attachment_image( $post->ID, $size ) . '</a></div>';

                    $opus_gallery->image_exif();

                    $opus_structure->post_coda();

                    comments_template(); ?>

                </div><!-- .post -->

            <?php
            endwhile;
        else:
            $opus_structure->search_results();
        endif; ?>

    </div><!-- #the-loop -->

    <?php
    get_sidebar( 'image' );

    echo $opus_structure->layout_close(); ?>

</div><!-- #content-wrapper -->

<?php
get_footer( 'image' );