<?php
    function subroute($method, $urlList, $requestData) {
        global $Link;
        $token = substr(getallheaders()["Authorization"], 7);

        if (!checkPermission($token)) {
            return;
        }

        switch ($method) {
            case "POST":
                $userID = requestUserID($token)["userID"];
                $vacancyID = $requestData->body->vacancyID;

                $bid = $Link->query("INSERT INTO vacanciesusers (`userID`, `vacancyID`) VALUES('$userID', '$vacancyID')");

                if (!checkForInserting($bid)) {
                    return;
                }

                echo json_encode(["message" => "OK"]);
                break;
            case "GET":
                $users = $Link->query("SELECT * FROM vacanciesusers");
                if (!$users) {
                    setHTTPStatus("500");
                    return;
                } else {
                    $message = [];
                    while ($row = $users->fetch_assoc()) {
                        $message[] = [
                            "userID" => $row["userID"],
                            "vacancyID" => $row["vacancyID"]
                        ];
                    }
                    echo json_encode($message);
                }
                break;
            case "DELETE":
                $index = (int)$urlList[2];

                $userID = requestUserID($token)["userID"];

                $result = $Link->query("DELETE FROM vacanciesusers WHERE userID='$userID' AND vacancyID='$index'");
                if (!$result) {
                    setHTTPStatus("500");
                } else {
                    echo json_encode(["message" => "OK"]);
                }
                break;
            default:
            setHTTPStatus("404");
            break;
        }
    }
?>