<?php
/**
 * Opus Primus default loop template
 * Displays the default loop content
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @link        http://opusprimus.com
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012, Opus Primus
 */

/** Call the Post Layout variable */
global $opus_layout;

/** Display the post */
$opus_layout->opus_post_title();
$opus_layout->opus_post_meta();
$opus_layout->opus_post_content();
$opus_layout->opus_post_author();
$opus_layout->opus_link_pages();