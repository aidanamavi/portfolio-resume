<?php
/**
  * @package WordPress
  * @subpackage AidanAmavi
  * @version 0.3
  *
  * @author Aidan Amavi <mail@aidanamavi.com>
  * @link http://www.aidanamavi.com Author's Web Site
  * @copyright 2012 - 2015, Aidan Amavi
  * @license http://creativecommons.org/licenses/by-sa/4.0/ Attribution-ShareAlike 4.0 International
  */

/**
  * @todo Add separate MySQL databse users.
  * @todo Add Geolocation databases for Org/ISP.
  * http://www.maxmind.com/en/isp
  */

// Get IP Address
$getIp = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');
function get_ip_address(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
}

// Create a random string to use for the UserID for this page view.
function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}
$sampleid = random_string('16');


// Set token_auth to set custom entries.
$varTokenAuth = 'dff591767dcddc5d09fecb225761dd1f';
// Set referer.
$varUrlReferer = $_SERVER['HTTP_REFERER'];
// Set User Agent.
$varUserAgent = $_SERVER['HTTP_USER_AGENT'];
// Set Browser Language.
$varBrowserLaguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
// Set Local Time.
$varLocalTime = date('G:i:s');
// Set generation. Display two decimal places in milliseconds, and then multiply by 1000 to get microseconds.
$varGenerationTime = timer_stop(0,3)*1000;
// Set IP
$varIp = $getIp;
// Set Current URL.
$varUrl = 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// Set title.
// $varTitle = get_bloginfo('name').wp_title('&raquo;', false, 'left');
$varTitle = $trackLocation;
//echo '<!-- '.$trackLocation.' -->';

// -- Piwik Tracking API init --
// Upload the PiwikTracker.php file to your web site FTP, and list it's location here.
define('__ROOT__', realpath(dirname(__FILE__)));
require_once(__ROOT__.'/PiwikTracker.php');
//echo 'cwd: '.realpath(dirname(__FILE__));
//echo 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].'/piwik/';
//echo __ROOT__;
// Location of the primary Piwik tracking database.
PiwikTracker::$URL = 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].'/piwik/';
$t = new PiwikTracker( $idSite = 1 );

// You can manually set the visitor details (resolution, time, plugins, etc.)
// See all other ->set* functions available in the PiwikTracker.php file
$t->setTokenAuth( $varTokenAuth );
$t->setUrlReferer( $varUrlReferer );
$t->setUserAgent( $varUserAgent );
$t->setBrowserLanguage( $varBrowserLaguage );
$t->setLocalTime( $varLocalTime );
$t->setGenerationTime( $varGenerationTime );
//$t->setResolution();
//$t->setBrowserHasCookies();
//$t->setPlugins();
//$t->setVisitorId();
$t->setIp( $varIp );
$t->setUrl( $varUrl );

// Sends Tracker request via http
$t->doTrackPageView( $varTitle );
//echo '<!-- '.$varGenerationTime1.' and '.$varGenerationTime.' -->';
?>
