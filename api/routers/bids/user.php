<?php
    function subroute($method, $urlList, $requestData) {
        global $Link;
        $token = substr(getallheaders()["Authorization"], 7);

        if (!checkPermission($token)) {
            return;
        }

        if ($method == "GET") {
            if (count($urlList) == 3) {

                if(!checkPermission($token)) {
                    return;
                }

                $userID = $urlList[2];
                $bids = requestBidsByUser($userID);

                if (is_null($bids)) {
                    return;
                }

                $message = [];

                while ($row = $bids->fetch_assoc()) {
                    $index = $row["vacancyID"];
                    $vacancy = requestVacancy($index);
                    if (is_null($vacancy)) {
                        return;
                    }

                    $position = requestPosition($vacancy["positionID"]);
                    $company = requestCompany($vacancy["companyID"]);

                    $submessage = [
                        "vacancyID" => $vacancy["id"],
                        "positionID" => $position["name"],
                        "companyID" => $company["name"]
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