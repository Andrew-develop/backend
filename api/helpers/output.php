<?php
    function outputApplicants($index) {
        global $Link;                
        $vacancyUsers = $Link->query("SELECT userID FROM vacanciesusers WHERE vacancyID=$index");

        $applicants = [];

        while ($vacancyUserRow = $vacancyUsers->fetch_assoc()) {
            $userID = $vacancyUserRow["userID"];
            $userInfo = $Link->query("SELECT * FROM users WHERE id=$userID");

            while ($userRow = $userInfo->fetch_assoc()) {
                $applicant["id"] = $userRow["id"];
                $applicant["name"] = $userRow["name"];
                $applicant["secondName"] = $userRow["secondName"];
                $applicant["email"] = $userRow["email"];
            }
            array_push($applicants, $applicant);
        }
        return $applicants;
    }

    function outputReviews($index) {
        global $Link;                
        $reviews = $Link->query("SELECT * FROM review WHERE movieID=$index");

        $genres = [];

        while ($reviewGenreRow = $reviews->fetch_assoc()) {
            $genre["userID"] = $reviewGenreRow["userID"];
            $genre["rating"] = $reviewGenreRow["rating"];

            array_push($genres, $genre);
        }
        return $genres;
    }
?>