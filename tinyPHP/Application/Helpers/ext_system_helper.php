<?php if ( ! defined('BASE_PATH')) exit('No direct script access allowed');
/**
 *
 * Core System Helper
 *  
 * PHP 5
 *
 * tinyPHP(tm) : Simple & Lightweight MVC Framework (http://tinyphp.us/)
 * Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 * @link http://tinyphp.us/ tinyPHP(tm) Project
 * @since tinyPHP(tm) v 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

use \tinyPHP\Classes\Core\DB;
use \tinyPHP\Classes\Libraries\Hooks;
use \tinyPHP\Classes\Libraries\Cookies;
    
    /**
     * Hide menu links by functions and/or by 
     * permissions.
     * 
     * @since 1.0.0
     */
    function hl($f,$p=NULL) {
        if(function_exists($f)) {
            return ' style="display:none"';
        }
        if($p !== NULL) {
            return ae($p);
        }
    }
    
    /**
     * Renders any unwarranted special characters to HTML entities.
     * 
     * @since 1.0.0
     * @param string $str
     * @return mixed
     */
    function _h($str) {
        return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
    }
    
    /**
     * Date dropdown
     */
    function date_dropdown($limit = 0,$name = '',$table = '',$column = '',$id = '',$field = '',$bool = '') {
        
        if($id != '') {
            $bind = [ ":id" => $id ];
            $array = [];
            $q = DB::inst()->select($table,"$column = :id","","*",$bind);
            foreach($q as $r) {
                $array[] = $r;
            }
            $date = explode("-",$r[$field]);
        }
        
        /*years*/
        $html_output = '           <select name="'.$name.'Year"'.$bool.' class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true">'."\n";
        $html_output .= '               <option value="">&nbsp;</option>'."\n";
            for ($year = 2000; $year <= (date("Y") - $limit); $year++) {
                $html_output .= '               <option value="' . sprintf("%04s", $year) . '"'.selected(sprintf("%04s", $year),$date[0],false).'>' . sprintf("%04s", $year) . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";
        
        /*months*/
        $html_output .= '           <select name="'.$name.'Month"'.$bool.' class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true">'."\n";
        $html_output .= '               <option value="">&nbsp;</option>'."\n";
        $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            for ($month = 1; $month <= 12; $month++) {
                $html_output .= '               <option value="' . sprintf("%02s", $month) . '"'.selected(sprintf("%02s", $month),$date[1],false).'>' . $months[$month] . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";
        
        /*days*/
        $html_output .= '           <select name="'.$name.'Day"'.$bool.' class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true">'."\n";
        $html_output .= '               <option value="">&nbsp;</option>'."\n";
            for ($day = 1; $day <= 31; $day++) {
                $html_output .= '               <option value="' . sprintf("%02s", $day) . '"'.selected(sprintf("%02s", $day),$date[2],false).'>' . sprintf("%02s", $day) . '</option>'."\n";
            }
        $html_output .= '           </select>'."\n";
        
        return $html_output;
    }
    
     /**
     * @since 1.0.0
     */
    function convert_day($date) {
        $weekday = date('N',strtotime($date));
        return $weekday;
    }
    
    function rolePerm($id) {
        $array = [];
        $bind = [ ":id" => $id ];
        $q = DB::inst()->query( "SELECT permission from role WHERE ID = :id", $bind );
        foreach($q as $v) {
            $array[] = $v;
        }
        $sql = DB::inst()->query("SELECT * FROM permission");
        foreach($sql as $r) {
            $perm = Hooks::maybe_unserialize($v['permission']);
            echo '
                <tr>
                    <td>'.$r['permName'].'</td>
                    <td class="text-center">
                <input type="checkbox" name="permission[]" value="'.$r['permKey'].'" ';
                if(in_array($r['permKey'],$perm)) { echo 'checked="checked"'; };
                echo '/>
                    </td>
                </tr>';
        }
    }
    
    function userPerm($id) {
        $array = [];
        $bind = [ ":id" => $id ];
        $q = DB::inst()->query( "SELECT permission FROM user_perms WHERE userID = :id", $bind );
        foreach($q as $r) {
            $array[] = $r;
        }
        $personPerm = Hooks::maybe_unserialize($r['permission']);
        /** 
         * Select the role(s) of the person who's 
         * personID = $id
         */ 
        $array1 = [];
        $bind1 = [ ":id" => $id ];
        $q1 = DB::inst()->query( "SELECT roleID from user_roles WHERE userID = :id",$bind1 );
        foreach($q1 as $r1) {
            $array1[] = $r1;
        }
        /**
         * Select all the permissions from the role(s)
         * that are connected to the selected person.
         */
        $array2 = [];
        $bind2 = [ ":id" => _h($r1['roleID']) ];
        $q2 = DB::inst()->query("SELECT permission from role WHERE ID = :id", $bind2);
        foreach($q2 as $r2) {
            $array2[] = $r2;
        }
        $perm = Hooks::maybe_unserialize($r2['permission']);
        $sql = DB::inst()->query("SELECT * FROM permission");
        foreach($sql as $r) {
            echo '
                <tr>
                    <td>'.$r['permName'].'</td>
                    <td class="text-center">
                <input type="checkbox" name="permission[]" value="'.$r['permKey'].'" ';
                if(in_array($r['permKey'],$perm)) { echo 'checked="checked" disabled="disabled"'; } elseif($personPerm != '' && in_array($r['permKey'],$personPerm)) { echo 'checked="checked"';};
                echo '/>
                    </td>
                </tr>';
        }
    }
    
    function get_name($ID) {
    	$array = [];
        $bind = [ ":id" => $ID ];
        $q = DB::inst()->select( "user","userID = :id","","lname,fname",$bind );
        foreach($q as $r) {
            $array[] = $r;
        }
        return _h($r['lname']).', '._h($r['fname']);
    }
    
    /**
     * @since 1.0.0
     */
    function get_initials($ID,$initials=2) {
    	$array = [];
        $bind = array( ":id" => $ID );
        $q = DB::inst()->select( "user","userID = :id","","lname,fname",$bind );
        foreach($q as $r) {
            $array[] = $r;
        }
        if($initials == 2) {
            return substr(_h($r['fname']),0,1).'. '.substr(_h($r['lname']),0,1).'.';
        } else {
            return _h($r['lname']).', '.substr(_h($r['fname']),0,1).'.';
        }
    }
    
    /**
     * Function to help with SQL injection when using SQL terminal 
     * and the saved query screens.
     */
    function strstra($haystack, $needles=array(), $before_needle=false) {
        $chr = array();
        foreach($needles as $needle) {
                $res = strstr($haystack, $needle, $before_needle);
                if ($res !== false) $chr[$needle] = $res;
        }
        if(empty($chr)) return false;
        return min($chr);
    }
    
    function print_gzipped_page() {
    
        global $HTTP_ACCEPT_ENCODING;
        if( headers_sent() ){
            $encoding = false;
        }elseif( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ){
            $encoding = 'x-gzip';
        }elseif( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ){
            $encoding = 'gzip';
        }else{
            $encoding = false;
        }
    
        if( $encoding ){
            $contents = ob_get_contents();
            ob_end_clean();
            header('Content-Encoding: '.$encoding);
            print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
            $size = strlen($contents);
            $contents = gzcompress($contents, 9);
            $contents = substr($contents, 0, $size);
            print($contents);
            exit();
        } else {
            ob_end_flush();
            exit();
        }
    }
    
    function percent($num_amount, $num_total) {
        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);
        return $count;
    }
    
    /**
     * Merge user defined arguments into defaults array.
     *
     * This function is used throughout tinyPHP to allow for both string or array
     * to be merged into another array.
     *
     * @since 4.2.0
     * @param string|array $args     Value to merge with $defaults
     * @param array        $defaults Optional. Array that serves as the defaults. Default empty.
     * @return array Merged user defined values with defaults.
     */
    function tp_parse_args( $args, $defaults = '' ) {
        if ( is_object( $args ) )
            $r = get_object_vars( $args );
        elseif ( is_array( $args ) )
            $r =& $args;
        else
            tp_parse_str( $args, $r );
    
        if ( is_array( $defaults ) )
            return array_merge( $defaults, $r );
        return $r;
    }
    
    function timeAgo($original) {
        // array of time period chunks
        $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'hour'),
        array(60 , 'min'),
        array(1 , 'sec'),
        );
     
        $today = time(); /* Current unix time  */
        $since = $today - $original;
     
        // $j saves performing the count function each time around the loop
        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
     
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
     
        // finding the biggest chunk (if the chunk fits, break)
            if (($count = floor($since / $seconds)) != 0) {
                break;
            }
        }
     
        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
     
        if ($i + 1 < $j) {
        // now getting the second item
        $seconds2 = $chunks[$i + 1][0];
        $name2 = $chunks[$i + 1][1];
     
        // add second item if its greater than 0
            if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
                $print .= ($count2 == 1) ? ', 1 '.$name2 : " $count2 {$name2}s";
            }
        }
        return $print;
    }
    
    function upgradeSQL($file, $delimiter = ';')
    {
        set_time_limit(0);
    
        if (is_file($file) === true)
        {
            $file = fopen($file, 'r');
    
            if (is_resource($file) === true)
            {
                $query = array();
    
                while (feof($file) === false)
                {
                    $query[] = fgets($file);
    
                    if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1)
                    {
                        $query = trim(implode('', $query));
    
                        if (DB::inst()->query($query) === false)
                        {
                            echo '<p><font color="red">ERROR:</font> ' . $query . '</p>' . "\n";
                        }
    
                        else
                        {
                            echo '<p><font color="green">SUCCESS:</font> ' . $query . '</p>' . "\n";
                        }
    
                        while (ob_get_level() > 0)
                        {
                            ob_end_flush();
                        }
    
                        flush();
                    }
    
                    if (is_string($query) === true)
                    {
                        $query = array();
                    }
                }
    
                fclose($file);
            }
        }
    }
    
    function remoteFileExists($url) {
        $curl = curl_init($url);
    
        //don't fetch the actual page, you only want to check the connection is ok
        curl_setopt($curl, CURLOPT_NOBODY, true);
    
        //do request
        $result = curl_exec($curl);
    
        $ret = false;
    
        //if request did not fail
        if ($result !== false) {
            //if request was ok, check response code
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
    
            if ($statusCode == 200) {
                $ret = true;   
            }
        }
    
        curl_close($curl);

    return $ret;
    
    }
    
    function head_version_meta() {
        echo "<meta name='generator' content='tinyPHP ERP " . CURRENT_VERSION . "'>\n";
    }
    
    function foot_version() {
        echo "v". CURRENT_VERSION;
    }
    
    function tp_hash_password($password) {
        // By default, use the portable hash from phpass
        $hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, FALSE);
    
            return $hasher->HashPassword($password);
    }
     
    function tp_check_password($password, $hash, $user_id = '') {
        // If the hash is still md5...
        if ( strlen($hash) <= 32 ) {
            $check = ( $hash == md5($password) );
            if ( $check && $user_id ) {
                // Rehash using new hash.
                tp_set_password($password, $user_id);
                $hash = tp_hash_password($password);
            }
            return Hooks::apply_filter('check_password', $check, $password, $hash, $user_id);
        }
        
        // If the stored hash is longer than an MD5, presume the
        // new style phpass portable hash.
        $hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, FALSE);
        
        $check = $hasher->CheckPassword($password, $hash);
        
            return Hooks::apply_filter('check_password', $check, $password, $hash, $user_id);
    }
     
    function tp_set_password( $password, $user_id ) {
        $update = [ "password" => tp_hash_password($password) ];
        $bind = [ ":id" => $user_id ];
        $q = DB::inst()->update('user',$update,'userID=:id',$bind);
    }
    
    function tp_hash_cookie($cookie) {
        // By default, use the portable hash from phpass
        $hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, TRUE);

            return $hasher->HashPassword($cookie);
    }
     
    function tp_authenticate_cookie($cookie, $cookiehash, $user_id = '') {

        $hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, TRUE);

        $check = $hasher->CheckPassword($cookie, $cookiehash);

            return Hooks::apply_filter('authenticate_cookie', $check, $cookie, $cookiehash, $user_id);
    }