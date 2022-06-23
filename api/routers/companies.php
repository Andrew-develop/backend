<?php

function route($method, $urlList, $requestData) {

    if (count($urlList) > 2) {
        setHTTPStatus("404");
        return;
    }

    global $Link;

    if ($method == "GET") {

        if (count($urlList) == 1) {
            $companies = $Link->query("SELECT * FROM companies");
            if (!$companies) {
                setHTTPStatus("500");
                return;
            } else {
                $message = [];
                while ($row = $companies->fetch_assoc()) {
                    $message[] = [
                        "id" => $row["id"],
                        "name" => $row["name"]
                    ];
                }
                echo json_encode($message);
            }
        }
        else if (count($urlList) == 2) {
            $index = (int)$urlList[1];
            $company = requestCompany($index);
            if (is_null($company)) {
                setHTTPStatus("500");
                return;
            }

            $message = [
                "id" => $company["id"],
                "name" => $company["name"]
            ];

            echo json_encode($message);
        }
    } else if ($method == "POST") {
        $name = $requestData->body->name;
        $company = $Link->query("SELECT id FROM companies WHERE name='$name'")->fetch_assoc();
            
        if (is_null($company)) {
            $companyInsertResult = $Link->query("INSERT INTO companies(name) VALUES('$name')");

            if (!$companyInsertResult) {
                setHTTPStatus("500");
            }
        } else {
            setHTTPStatus("500");
        }
    } else {
        setHTTPStatus("500");
        return;
    }
}

?>
