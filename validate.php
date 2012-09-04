<?php

class Validate extends Base {

	/**
	 * clean up path (remove double //, fix relatives like ./../)
	 *
	 * @access public
	 * @param  string  $path
	 * @return string
	 *
	 **/
	public static function path($path){
        $path  = defined('BASEDIR')
			   ? preg_replace('~^\.(\\\.)?/~', BASEDIR.'/'          , $path )
			   : preg_replace('~^\.(\\\.)?/~', dirname(__FILE__).'/', $path );
		$path  = preg_replace( '~/$~'        , ''                   , $path );
		$path  = str_replace ( '\\'   		 , DIRECTORY_SEPARATOR  , $path );
		$path  = preg_replace('~/\./~'		 , DIRECTORY_SEPARATOR  , $path );
		$parts = array();
		foreach ( explode(DIRECTORY_SEPARATOR, preg_replace('~/+~', DIRECTORY_SEPARATOR, $path)) as $part ) {
		    if ($part === ".." ) { // || $part == ''
		        array_pop($parts);
		    }
		    elseif ($part!="") {
		        $parts[] = $part;
		    }
            else {
                // not handled
            }
		}
		$new_path = implode(DIRECTORY_SEPARATOR, $parts);
		// windows
		if ( ! preg_match( '/^[a-z]\:/i', $new_path ) ) {
			$new_path = DIRECTORY_SEPARATOR . $new_path;
		}
		return $new_path;
	}   // end function path()

	/**
	 * clean up URL (remove double //, fix relatives like ./../)
	 *
	 * @access public
	 * @param  string $href - URL to sanitize
	 * @return string
	 **/
	public static function url($href) {
        $rel_parsed = parse_url($href);
        $path       = $rel_parsed['path'];
        $path       = preg_replace('~/\./~', '/', $path); // bla/./bloo ==> bla/bloo
        $path       = preg_replace('~/$~', '', $path );   // remove trailing
        $parts      = array();                            // resolve /../
        foreach ( explode('/', preg_replace('~/+~', '/', $path)) as $part ) {
            if ($part === ".." || $part == '') {
                array_pop($parts);
            }
            elseif ($part!="") {
                $parts[] = $part;
            }
        }
        return
        (
              array_key_exists( 'scheme', $rel_parsed )
            ? $rel_parsed['scheme'] . '://' . $rel_parsed['host'] . ( isset($rel_parsed['port']) ? ':'.$rel_parsed['port'] : NULL )
            : ""
        ) . "/" . implode("/", $parts);
	}   // end function url()

}   // end class Validate