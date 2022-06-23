<?php
    function route($method, $urlList, $requestData) {
        
        if (count($urlList) < 2 || count($urlList) > 3) {
            setHTTPStatus("404");
            return;
        }

        if(file_exists(realpath(dirname(__FILE__)) . "/accounts/" . $urlList[1] . ".php")) {
            include_once "accounts/" . $urlList[1] . ".php";
            subroute($method, $urlList, $requestData);
        } else {
            setHTTPStatus("404");
        }
    }
?>