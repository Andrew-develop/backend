<?php

function route($method, $urlList, $requestData) {

    global $Link;

    if ($method == "GET") {
        $users = $Link->query("SELECT * FROM users");
        if (!$users) {
            setHTTPStatus("500");
            return;
        } else {
            $message = [];
            while ($row = $users->fetch_assoc()) {
                $message[] = [
                    "id" => $row["id"],
                    "name" => $row["name"],
                    "secondName" => $row["secondName"],
                    "thirdName" => $row["thirdName"],
                    "email" => $row["email"],
                    "birthDate" => $row["birthDate"]
                ];
            }
            echo json_encode($message);
        }
    }
}

?>