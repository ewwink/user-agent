<?php
/*
Plugin Name: User Agents
Plugin URI: https://github.com/ewwink/user-agent
Description: Shows User Agents on the Traffic Location page
Version: 1.0
Author: ewwink
Author URI: http://www.cekpr.com
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_action( 'post_yourls_info_location', 'useragents_do_page' );

function useragents_do_page($shorturl) {
        $nonce = yourls_create_nonce('useragents');
        echo '<h2>User Agents</h2>';

        global $ydb;
        $base  = YOURLS_SITE;
        $table_url = YOURLS_DB_TABLE_URL;
        $table_log = YOURLS_DB_TABLE_LOG;
        $outdata         = '';


        $query = $ydb->get_results("SELECT a.user_agent AS user_agent, count(*) AS clicks FROM `$table_log` a WHERE a.shorturl='$shorturl[0]' GROUP BY user_agent ORDER BY count(*) DESC");

        if ($query) {
                foreach( $query as $query_result ) {
                        $outdata .= '<tr><td>' . $query_result->clicks . '</td><td>'
                            . $query_result->user_agent .
                                '</td></tr>';
                }
                echo '<h3><b>Popular User Agents:</b></h3><br/>'
                . '<table><tr><th>Clicks</th><th>User Agent</th></tr>' . $outdata . "</table><br>\n\r";
        }
}
