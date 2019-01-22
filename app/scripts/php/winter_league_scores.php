<?php
    require("connect.php");
    require("Score.php");
    require("TeamScore.php");
    require("WeekScore.php");

    define("WEEKS_COUNTING", 5);
    define("SCORES_COUNTING", 2);
    define("NUMBER_OF_WEEKS", 10);

    $latest_week = 0;
    $teams = array();
    $teamScores = array();

    $week_query = "SELECT MAX(week_number) as last_week FROM winter_league_results";
    $team_query = "SELECT DISTINCT team_name FROM winter_league_teams";

    $week_query_response = @mysqli_query($database, $week_query);
    
    if($week_query_response){
        $row = mysqli_fetch_assoc($week_query_response);
        $latest_week = $row['last_week'];
    } 

    $team_query_response = @mysqli_query($database, $team_query);
    if($team_query_response){
        while($row = mysqli_fetch_array($team_query_response)){
            array_push($teams ,$row['team_name']);
        }
    }

    foreach($teams as $team){
        $weekScores = array();
        $teamPlayers = getTeamPlayers($team, $database);

        for($i = 1; $i <= $latest_week; $i++){
            $min_score = 0;
            $lowest_week_score_query = "SELECT MIN(score) as min_score FROM winter_league_results WHERE week_number = {$i} AND score != 0";
            $lowest_week_score_query_response = @mysqli_query($database, $lowest_week_score_query);
            if($lowest_week_score_query_response){
                $row = mysqli_fetch_array($lowest_week_score_query_response);
                $min_score = $row['min_score']; 
            } 

            $scores = array();
            $week_scores_query = "SELECT * from winter_league_results a INNER JOIN winter_league_teams b ON a.player_name = b.player_name WHERE b.team_name = '{$team}' AND a.week_number = {$i}";
            $week_scores_query_response = @mysqli_query($database, $week_scores_query);
            if($week_scores_query_response){
                while($row = mysqli_fetch_array($week_scores_query_response)){
                    array_push($scores, new Score($row['player_name'], $row['score'], $row['week_number']));
                }
            }
            $weekScore = new WeekScore($i, $scores, SCORES_COUNTING, $min_score);
            array_push($weekScores, $weekScore);
        }
        array_push($teamScores, new TeamScore($team, $weekScores, WEEKS_COUNTING, $teamPlayers));
    }
    $teamScores = sortTeamScores($teamScores);    
    $json = "{\"scores\": [";
    foreach($teamScores as $teamScore){
        $json .= ($teamScore->toJson() . ",");
    }
    $updateTime = getUpdateTime($database);
    $json = substr($json, 0, -1);
    $json .= "], \"metadata\": { \"latestWeek\": \"{$latest_week}\", \"updateTime\": \"{$updateTime}\"}}";
    echo $json;

    function getTeamPlayers($team_name, $database){
        $players = array();
        $players_query = "SELECT * FROM winter_league_teams WHERE team_name = '{$team_name}'";
        $players_query_response = @mysqli_query($database, $players_query);
        if($players_query_response){
            while($row = mysqli_fetch_array($players_query_response)){
                array_push($players, str_replace(" O ", " O'", $row['player_name']));        
            }
        }
        return $players;
    }

    function sortTeamScores($teamScores){
        usort($teamScores, function($a, $b){
            if($a->teamScore() < $b->teamScore()) return 1;
            elseif ($a->teamScore() > $b->teamScore()) return -1;
            else return 0;
        });
        return $teamScores;
    }

    function getUpdateTime($database){
        $query = "SELECT update_time FROM winter_league_results ORDER BY update_time DESC LIMIT 1";
        $response = @mysqli_query($database, $query);
        if ($response) {
            $row = mysqli_fetch_assoc($response);
            $timestamp =  $row['update_time'];
            $unixTime = strtotime($timestamp);
            return date("M-d - H:i", $unixTime);
        }
        return null;
    }
?>