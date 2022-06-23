<?php
    function subroute($method, $urlList, $requestData) {
        global $Link;
        $token = substr(getallheaders()["Authorization"], 7);

        if (!checkPermission($token)) {
            return;
        }

        if (!rolePermission($token, UserStatus::Company)) {
            return;
        }

        if ($method == "GET") {
            if (count($urlList) == 3) {
                $userID = requestUserID($token);

                if (is_null($userID)) {
                    return;
                }

                $vacancyID = $urlList[2];
                $bids = requestBidsByVacancy($vacancyID);

                if (is_null($bids)) {
                    return;
                }

                $message = [];

                while ($row = $bids->fetch_assoc()) {

                    $user = requestUser($row["userID"]);

                    $submessage = [
                        "userID" => $user["id"],
                        "name" => $user["name"],
                        "secondName" => $user["secondName"]
                    ];

                    array_push($message, $submessage);
                }
                echo json_encode($message);
            } else {
                setHTTPStatus("404");
            }
        } else {
            setHTTPStatus("404");
        }
    }
?>