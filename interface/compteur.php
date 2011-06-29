<?php
    if ( $d = opendir( session_save_path()  )  ) {
        $count = 0;
        $session_timeout = 3 * 60;
        while ( false !== ( $file = readdir( $d )  )  ) {
            if ( $file != '.' && $file != '..' ) {
                if ( time()- fileatime(session_save_path() . '/' . $file) < $session_timeout ) {
                      $count++;
                }
            }
        }
    }
    echo $count;
?>