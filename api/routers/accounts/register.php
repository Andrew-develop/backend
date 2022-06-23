<?php
    function subroute($method, $urlList, $requestData) {
        if ($method == "POST") {
            global $Link;
            $email = $requestData->body->email;
            $user = $Link->query("SELECT id FROM users WHERE email='$email'")->fetch_assoc();
            
            if (is_null($user)) {
                $password = hash("sha1", $requestData->body->password);
                $name = $requestData->body->name;
                $secondName = $requestData->body->secondName;
                $thirdName = $requestData->body->thirdName;
                $email = $requestData->body->email;
                $birthDate = $requestData->body->birthDate;
    
                $userInsertResult = $Link->query("INSERT INTO users(name, secondName, thirdName, email, password, birthDate, roleId) VALUES('$name', '$secondName', '$thirdName', '$email', '$password', '$birthDate', 2)");
    
                if (!$userInsertResult) {
                    setHTTPStatus("500");
                } else {
                    $user = $Link->query("SELECT id FROM users WHERE email='$email' AND password='$password'")->fetch_assoc();
                    $token = bin2hex(random_bytes(16));
                    $userID = $user["id"];
                    $validTime = time() + (10 * 60);
                    $validUntil = date('Y-m-d H:i:s', $validTime);
    
                    $userInsertResult = $Link->query("INSERT INTO tokens(value, userID, validUntil) VALUES('$token', '$userID', '$validUntil')");
                    
                    if (!$userInsertResult) {
                        echo json_encode($Link->error);
                    } else {
                        echo json_encode(["token" => $token]);
                    }
                }
            } else {
                setHTTPStatus("400");
            }
        } else {
            setHTTPStatus("400");
        }
    }
?>