<?php
    function subroute($method, $urlList, $requestData) {
        if ($method == "POST") {
            global $Link;
        
            $email = $requestData->body->email;
            $password = hash("sha1", $requestData->body->password);
            
            $user = $Link->query("SELECT id FROM users WHERE email='$email' AND password='$password'")->fetch_assoc();

            if (!is_null($user)) {
                $token = bin2hex(random_bytes(16));
                $userID = $user["id"];
                $validTime = time() + (10 * 60);
                $validUntil = date('Y-m-d H:i:s', $validTime);
    
                $userInsertResult = $Link->query("INSERT INTO tokens(value, userID, validUntil) VALUES('$token', '$userID', '$validUntil')");
                
                if (!$userInsertResult) {
                    setHTTPStatus("500");
                } else {
                    echo json_encode(["token" => $token]);
                }
            } else {
                setHTTPStatus("409");
            }

        } else {
            setHTTPStatus("400");
        }
    }
?>