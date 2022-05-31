<?php
    
    function sendQuery($sql, $mysqli){
        $result = mysqli_query($mysqli, $sql);

        if (!$result) {
            exit($mysqli->error);
        }
        else{
            return $result;
        }
    }

    function againstSQLInjection($post, $mysqli){
        return $mysqli->real_escape_string(trim($post));
    }
   

?>