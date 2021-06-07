<?php 

    session_start();
    session_unset();
    unset($_COOKIE);
    echo '<script> window.location = "index.php"</script>';

?>