<?php
    require("../connect.php");
    require("../Score.php");
    require("player.php");

    define("WEEKS_COUNTING", 5);
    define("SCORES_COUNTING", 2);
    define("NUMBER_OF_WEEKS", 10);

    $latest_week = 0;
    $players = array();
    $teamScores = array();

    $week_query = "SELECT MAX(week_number) as last_week FROM winter_league_results";
    $player_query = "SELECT DISTINCT player_name FROM winter_league_teams";

    $week_query_response = @mysqli_query($database, $week_query);
    
    if($week_query_response){
        $row = mysqli_fetch_assoc($week_query_response);
        $latest_week = $row['last_week'];
    } 

    $player_query_response = @mysqli_query($database, $player_query);
    if($player_query_response){
        while($row = mysqli_fetch_array($player_query_response)){
            array_push($players ,$row['player_name']);
        }
    }
    
    $playerScores = array();
    foreach($players as $player){
        // $teamPlayers = getTeamPlayers($team, $database);

        // for($i = 1; $i <= $latest_week; $i++){
            // $min_score = 0;
            // $lowest_week_score_query = "SELECT MIN(score) as min_score FROM winter_league_results WHERE week_number = {$i} AND score != 0";
            // $lowest_week_score_query_response = @mysqli_query($database, $lowest_week_score_query);
            // if($lowest_week_score_query_response){
            //     $row = mysqli_fetch_array($lowest_week_score_query_response);
            //     $min_score = $row['min_score']; 
            // } 

            $scores = array();
            $scores_query = "SELECT * from winter_league_results  WHERE player_name = '{$player}'";
            $scores_query_response = @mysqli_query($database, $scores_query);
            if($scores_query_response){
                while($row = mysqli_fetch_array($scores_query_response)){
                    array_push($scores, new Score($row['player_name'], $row['score'],  $row['week_number']));
                }
            }
            // $weekScore = new WeekScore($i, $scores, SCORES_COUNTING, $min_score);
            array_push($playerScores, new Player($player, $scores, WEEKS_COUNTING));
        // }
        // array_push($teamScores, new TeamScore($team, $weekScores, WEEKS_COUNTING, $teamPlayers));
    }
    $playerScores = sortPlayerScores($playerScores);  
    $json = "[";
    foreach($playerScores as $playerScore){
        $json .= ($playerScore->toJson() . ",");
    }
    $json = substr($json, 0, -1);
    $json .= ']';
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

    function sortPlayerScores($playerScores){
        usort($playerScores, function($a, $b){
            if($a->score() < $b->score()) return 1;
            elseif ($a->score() > $b->score()) return -1;
            else return 0;
        });
        return $playerScores;
    }
?>