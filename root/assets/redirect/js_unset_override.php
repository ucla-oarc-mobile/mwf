<?php

/**
 * A Javascript-headered function that can be included in a <script> and unsets
 * the redirection override preference set by /assets/redirect/js.php.
 *
 * @author ebollens
 * @version 20101021
 *
 * @uses /assets/redirect/unset_override.php
 * @link /assets/redirect/js.php
 */

if(!headers_sent())
{
    header('Content-Type: text/javascript');
    header("Cache-Control: max-age=3600");
    include_once('unset_override.php');
}

?>