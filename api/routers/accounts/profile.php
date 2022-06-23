<?php
    function subroute($method, $urlList, $requestData) {
        global $Link;

        $token = substr(getallheaders()["Authorization"], 7);

        if (!checkPermission($token)) {
            return;
        }

        if (!rolePermission($token, UserStatus::Admin) && !checkForCurrentUser((int)$urlList[2], $token)) {
            setHTTPStatus("403");
            return;
        }
        
        switch ($method) {
            case "GET":
                $index = (int)$urlList[2];
                $user = $Link->query("SELECT * FROM users WHERE id='$index'")->fetch_assoc();

                if (!$user) {
                    setHTTPStatus("404");
                } else {
                    $message = [
                        "id" => $user["id"],
                        "name" => $user["name"],
                        "secondName" => $user["secondName"],
                        "thirdName" => $user["thirdName"],
                        "email" => $user["email"],
                        "birthDate" => $user["birthDate"]
                    ];
                    echo json_encode($message);
                }
                break;
            case "PUT":
                $name = $requestData->body->name;
                $secondName = $requestData->body->secondName;
                $thirdName = $requestData->body->thirdName;
                $birthDate = $requestData->body->birthDate;

                $index = (int)$urlList[2];

                $updateUser = $Link->query("UPDATE users SET birthDate = '$birthDate', name = '$name', secondName = '$secondName', thirdName = '$thirdName' WHERE id = $index");
                if (!$updateUser) {
                    setHTTPStatus("404");
                } else {
                    $message = ["message" => "OK"];
                    echo json_encode($message);
                }
                break;
            default:
            setHTTPStatus("401");
            return;
            break;
        }
    }
?>