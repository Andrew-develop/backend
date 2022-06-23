<?php

    class UserStatus {
        const Admin = 1;
        const Student = 2;
        const Company = 3;
        const Deanery = 4;
    }

    function checkPermission($token) {
        global $Link;
        $dbToken = $Link->query("SELECT userID, validUntil FROM tokens WHERE value='$token'")->fetch_assoc();
        if (!is_null($dbToken)) {
            if ($dbToken["validUntil"] > date('Y-m-d H:i:s', time())) {
                return true;
            } else {
                $Link->query("DELETE FROM tokens WHERE value='$token'");
                setHTTPStatus("403");
                return false;
            }
        } else {
            setHTTPStatus("401");
            return false;
        }
    }

    function rolePermission($token, $position) {
        global $Link;
        
        $userID = $Link->query("SELECT userID FROM tokens WHERE value='$token'")->fetch_assoc()["userID"];

        $role = $Link->query("SELECT roleId FROM users WHERE id='$userID'")->fetch_assoc()["roleId"];

        if ($role == $position) {
            return true;
        } else {
            return false;
        }
    }

    function checkForCurrentUser($index, $token) {
        global $Link;

        $dbToken = $Link->query("SELECT userID FROM tokens WHERE value='$token'")->fetch_assoc();

        if ($dbToken["userID"] == $index) {
            return true;
        } else {
            return false;
        }
    }

    function checkForInserting($value) {
        if (!$value) {
            setHTTPStatus("500");
            return false;
        } else {
            return true;
        }
    }

?>
