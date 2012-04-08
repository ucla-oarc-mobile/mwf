<?php

/**
 * 
 * @author trott
 * @date 20120210
 * 
 * minify_js.php 
 * 
 * Usage: minify_js.php [-i INPUT_FILE] [-o OUTPUT_FILE] [-m MINIFIER]
 *     Default input file is STDIN.
 *     Default output file is STDOUT.
 *     Valid values for the minifier are "jsmin" (the default) and "yui".
 * 
 * Reads source JS perhaps with mingled PHP, removes PHP, minifies JS, and 
 * restores the PHP.
 * 
 * The token substitution algorithm will work with vars.src.php but is not
 * generalized. Re-using it for other files is not recommended.
 */
// PHP doesn't have enumerations, so fake it.
abstract class Minifier {
    const JSMIN = 0;
    const YUI = 1;
}

$opts = getopt('i:o:m:');

if (isset($opts['i'])) {
    if (!$code = file_get_contents($opts['i']))
        die('Could not read input file ' . $opts['i']);
} else {
    // No input file specified on command-line so read from stdin.
    $code = '';
    $stdin = fopen('php://stdin', 'r');
    while ($input = fgets($stdin))
        $code .= $input;
}

$minify_command = Minifier::JSMIN;
if (isset($opts['m'])) {
    switch ($opts['m']) {
        case 'yui':
            $minify_command = Minifier::YUI;
            break;
        case 'jsmin':
            $minify_command = Minifier::JSMIN;
            break;
        default:
            die("Unknown minifier specified: " . $opts['m']);
    }
}

$tokens = token_get_all($code);

// replace each block of PHP code with a string hash
$minifiable = '';

reset($tokens);
$hash_array = array();
$code_chunk_array = array();
while (list(, $token) = each($tokens)) {
    if (is_array($token)) {
        list($index, $code, $line) = $token;
        if ($index == T_OPEN_TAG) {
            $php_code_chunk = $code;
            while (list(, $token) = each($tokens)) {
                if (is_array($token)) {
                    list($index, $code, $code) = $token;
                    $php_code_chunk .= $code;
                    if ($index == T_CLOSE_TAG)
                        break;
                } else {
                    $php_code_chunk .= $token;
                }
            }
            $hash = md5($php_code_chunk);
            // Exclamation point tells compressor to preserve comment.
            $cipher = "/*!" . $hash . "*/function(){}";
            $code_chunk_array[] = $php_code_chunk;
            $hash_array[] = "/*" . $hash . "*/function(){}";
            $minifiable .= $cipher;
        } else {
            $minifiable .= $code;
        }
    } else {
        $minifiable .= $token;
    }
}

// Now that all the PHP chunks have been replaced with MD5 strings, we can 
//    minify the JS code.

switch ($minify_command) {
    case (Minifier::JSMIN):
        require_once('../root/assets/lib/jsmin.class.php');
        $minified = JSMin::minify($minifiable);
        break;
    case (Minifier::YUI):
        $minifiable_file = tempnam(sys_get_temp_dir(), "MWFMIN_");
        file_put_contents($minifiable_file, $minifiable);
        $yui_command = 'java -jar ' . dirname(__FILE__) . '/yuicompressor-2.4.7.jar --type js '. $minifiable_file;
        exec($yui_command, $yui_output);
        unlink($minifiable_file);
        $minified = implode("", $yui_output);
        break;
}

// remove newlines placed around comments
$minified = preg_replace('/\n?\/\*\!?/', "/*", $minified);
$minified = preg_replace("/\*\/\n/", "*/", $minified);


$minified = str_replace($hash_array, $code_chunk_array, $minified);

// Now put the minified code where it belongs
if (isset($opts['o'])) {
    if (!file_put_contents($opts['o'], $minified))
        die('Could not write output file ' . $opts['o']);
} else {
    // No output file specified on command-line so write to stdout
    echo $minified;
}


