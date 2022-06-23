<?php

    function route($method, $urlList, $requestData) {
        global $Link;
        switch ($method) {
            case "GET":
                if (count($urlList) == 1) {

                    $vacancies = requestVacancies();
                    if (is_null($vacancies)) {
                        return;
                    }

                    $message = [];

                    while ($row = $vacancies->fetch_assoc()) {

                        $position = requestPosition($row["positionID"]);
                        $company = requestCompany($row["companyID"]);

                        $message[] = [
                            "id" => $row["id"],
                            "position" => $position["name"],
                            "company" => $company["name"]
                        ];
                    }
                    echo json_encode($message);

                } else if (count($urlList) == 2) {
                    $index = (int)$urlList[1];
                    $vacancy = requestVacancy($index);
                    if (is_null($vacancy)) {
                        return;
                    }
                    
                    $message = [];

                    $applicants = outputApplicants($index);

                    $message[] = [
                        "id" => $vacancy["id"],
                        "positionID" => $vacancy["positionID"],
                        "companyID" => $vacancy["companyID"],
                        "applicants" => $applicants
                    ];

                    echo json_encode($message);

                } else {
                    setHTTPStatus("400");
                    return;
                }
                break;
            case "POST":
                $token = substr(getallheaders()["Authorization"], 7);
                if (!checkPermission($token)) {
                    return;
                }

                if (!rolePermission($token, UserStatus::Company)) {
                    return;
                }

                $userID = requestUserID($token)["userID"];

                $positionID = $requestData->body->positionID;
                $companyID = requestCompanyID($userID)["companyID"];

                $vacancy = $Link->query("INSERT INTO vacancies (`positionID`, `companyID`) VALUES('$positionID', '$companyID')");

                if (!checkForInserting($vacancy)) {
                    return;
                }

                echo json_encode(["message" => "OK"]);
                
                break;
            case "DELETE":
                $token = substr(getallheaders()["Authorization"], 7);

                if (!checkPermission($token)) {
                    return;
                }

                if (!rolePermission($token, UserStatus::Company)) {
                    setHTTPStatus("403");
                    return;
                }

                $index = (int)$urlList[1];

                $result = $Link->query("DELETE FROM vacancies WHERE id='$index'");
                if (!$result) {
                    setHTTPStatus("500");
                } else {
                    echo json_encode(["message" => "OK"]);
                }

                break;
            default:
                setHTTPStatus("404");
                return;
                break;
        }
    }

?>
