<?php
/**
 * Opus Primus THA Support
 * Support for the Theme Hook Alliance system of action hooks
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2013, Opus Primus
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

class OpusPrimusTHASupport {

    /** Constructor */
    function __construct() {

        /** Pull in the main THA Theme Hooks file */
        require_once( OPUS_STANZAS_URI . 'tha-support/tha-theme-hooks.php' );

    }


    /**
     * THA in Opus Primus
     * Match up hooks in THA to existing hooks in Opus Primus then use
     * function to hook into ???
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     *
     * @internal Directly related to THA v1.0
     */
    function tha_in_opusprimus() {

        /** Add all hooks */


    }

}
