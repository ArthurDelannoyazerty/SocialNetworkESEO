<?php
    
    function sendQuery($sql, $mysqli){
        $result = $mysqli->query($sql);
        if (!$result) {
            exit($mysqli->error);
        }
    }

    function againstSQLInjection($post, $mysqli){
        return $mysqli->real_escape_string(trim($post));
    }
   

?>