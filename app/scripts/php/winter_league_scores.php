<?php
    require("connect.php");
    require("Score.php");
    require("TeamScore.php");
    require("WeekScore.php");

    define("WEEKS_COUNTING", 2);
    define("SCORES_COUNTING", 2);

    $latest_week = 0;
    $teams = array();
    $teamScores = array();

    $week_query = "SELECT MAX(week_number) as last_week FROM winter_league_results";
    $team_query = "SELECT DISTINCT team_name FROM teams";

    $week_query_response = @mysqli_query($database, $week_query);
    
    if($week_query_response){
        $row = mysqli_fetch_assoc($week_query_response);
        $latest_week = $row['last_week'];
    } 

    $team_query_response = @mysqli_query($database, $team_query);

    if($team_query_response){
        while($row = mysqli_fetch_array($team_query_response)){
            $teams[] = $row['team_name'];
        }
    }


    foreach($teams as $team){
        $weekScores = array();
        for($i = 1; $i <= $latest_week; $i++){
            $scores = array();
            $week_scores_query = "SELECT * from winter_league_results a INNER JOIN teams b ON a.player_name = b.player_name WHERE b.team_name = '{$team}' AND a.week_number = {$i}";
            $week_scores_query_response = @mysqli_query($database, $week_scores_query);
            if($week_scores_query_response){
                while($row = mysqli_fetch_array($week_scores_query_response)){
                    array_push($scores, new Score($row['player_name'], $row['score']));
                }
            }
            array_push($weekScores, new WeekScore($i, $scores, SCORES_COUNTING));
        }
        array_push($teamScores, new TeamScore($team, $weekScores, WEEKS_COUNTING));
    }

    $json = "[";
    foreach($teamScores as $teamScore){
        $json .= ($teamScore->toJson() . ",");
    }
    $json = substr($json, 0, -1);
    $json .= ']';
    echo $json;


    // if($players_query_response){
	// 	while($row = mysqli_fetch_array($players_query_response)){
    //         $query = "INSERT INTO WINTER_LEAGUE_RESULTS VALUES ";
    //         $i = 1;
    //         $values = "";
    //         foreach($weeks as $week){
    //             if($row[$week] && $row[$week] != ""){
    //                 $values .= "(DEFAULT,\"" . $row['PLAYER_NAME'] . "\", {$i}," . $row[$week] . "),";
    //             }
    //             $i++;
    //         }
    //         $values = substr($values, 0, -1);
    //         $values .= ";";
    //         $query .= $values;
    //         echo $query . "<br><br>";
    //         @mysqli_query($database, $query);
    //         echo mysqli_error($database);
	// 	}
    // } 
?>