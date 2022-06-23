<?php

    function setHTTPStatus($status = "200") {
        switch ($status) {
            case "200":
                $status = "HTTP/1.0 200 OK";
                break;
            case "400":
                $status = "HTTP/1.0 400";
                break;
            case "401":
                $status = "HTTP/1.0 401";
                break;
            case "403":
                $status = "HTTP/1.0 403";
                break;
            case "404":
                $status = "HTTP/1.0 404 NOT FOUND";
                break;
            case "409":
                $status = "HTTP/1.0 409";
                break;
            case "500":
                $status = "HTTP/1.0 500 Internal Server Error";
                break;
        }
        header($status);
        if ($status != "200") {
            echo json_encode(["message" => "Oops... Something went wrong."]);
        }
    }
    
?>
