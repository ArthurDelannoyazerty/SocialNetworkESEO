<?php
    function sendQuery($id, $mysqli){
        if($id>0){
            $sql = "SELECT account_data.* FROM account_data WHERE primaire = '$id'";
            $result = sendQuery($sql, $mysqli);
        }
        return $result;
    }
?>