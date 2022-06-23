<?php
    function subroute($method, $urlList, $requestData) {
        if ($method == "POST") {
            global $Link;
            $token = substr(getallheaders()["Authorization"], 7);
    
            if (!checkPermission($token)) {
                return;
            }
            
            $logoutResult = $Link->query("DELETE FROM tokens WHERE value='$token'");
        
            if (is_null($logoutResult)) {
                setHTTPStatus("500");
            }
        } else {
            setHTTPStatus("400");
        }
    }
?>