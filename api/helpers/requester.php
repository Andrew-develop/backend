<?php

    function requestVacancies() {
        global $Link;
        $vacancies = $Link->query("SELECT * FROM vacancies");
        if (!$vacancies) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $vacancies;
        }
    }

    function requestVacancy($index) {
        global $Link;
        $vacancy = $Link->query("SELECT * FROM vacancies WHERE id='$index'")->fetch_assoc();
        if (is_null($vacancy)) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $vacancy;
        }
    }

    function requestBidsByUser($userID) {
        global $Link;
        $bids = $Link->query("SELECT * FROM vacanciesusers WHERE userID='$userID'");
        if (!$bids) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $bids;
        }
    }

    function requestBidsByVacancy($vacancyID) {
        global $Link;
        $bids = $Link->query("SELECT * FROM vacanciesusers WHERE vacancyID='$vacancyID'");
        if (!$bids) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $bids;
        }
    }

    function requestUser($index) {
        global $Link;
        $user = $Link->query("SELECT * FROM users WHERE id='$index'")->fetch_assoc();
        if (is_null($user)) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $user;
        }
    }

    function requestUserID($token) {
        global $Link;

        $userID = $Link->query("SELECT userID FROM tokens WHERE value='$token'")->fetch_assoc();
        if (is_null($userID)) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $userID;
        }
    }

    function requestMovieByName($name) {
        global $Link;
        $movie = $Link->query("SELECT id FROM movies WHERE name='$name'")->fetch_assoc();
        if (is_null($movie)) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $movie;
        }
    }

    function requestCompany($index) {
        global $Link;
        $company = $Link->query("SELECT * FROM companies WHERE id='$index'")->fetch_assoc();
        if (is_null($company)) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $company;
        }
    }

    function requestCompanyID($index) {
        global $Link;
        $company = $Link->query("SELECT companyID FROM users WHERE id='$index'")->fetch_assoc();
        if (is_null($company)) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $company;
        }
    }

    function requestPosition($index) {
        global $Link;
        $position = $Link->query("SELECT name FROM position WHERE id='$index'")->fetch_assoc();
        if (is_null($position)) {
            setHTTPStatus("500", "Не найдено");
        } else {
            return $position;
        }
    }
?>