<?php
    require("connect.php");
    require("Score.php");
    require("TeamScore.php");
    require("WeekScore.php");

    define("WEEKS_COUNTING", 2);
    define("SCORES_COUNTING", 2);
    define("NUMBER_OF_WEEKS", 10);

    $latest_week = 0;
    $teams = array();
    $teamScores = array();
    $lowestWeekScores = array();

    for($i = 0; $i < NUMBER_OF_WEEKS; $i++){
        array_push($lowestWeekScores, 0);
    } 

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
                    array_push($scores, new Score($row['player_name'], $row['score'], $row['week_handicap']));
                }
            }
            $weekScore = new WeekScore($i, $scores, SCORES_COUNTING);
            if(sizeof($scores) < SCORES_COUNTING){
                $weekScore->flag = true;
            }
            checkIfLowest($weekScore->weekScore(), $i);
            array_push($weekScores, $weekScore);
        }
        array_push($teamScores, new TeamScore($team, $weekScores, WEEKS_COUNTING));
    }

    // go back through all the scores and add any supplementary scores for the weeks 
    foreach($teamScores as $teamScore){
        foreach($teamScore->weeks as $weeks){
            $weekNumber = $week->weekNumber;
            if($week->flag == true){ // check if the week is flagged for not having the minimum ammount of players
                if($week->weekScore() < $lowestWeekScores[$weekNumber - 1]){ // check if the current score for the week is less than the minimum score
                    $week->overrideScore = $lowestWeekScores[$weekNumber - 1];
                }
            }
        }
    }

    $json = "[";
    foreach($teamScores as $teamScore){
        $json .= ($teamScore->toJson() . ",");
    }
    $json = substr($json, 0, -1);
    $json .= ']';
    echo $json;

    function checkIfLowest($weekScore, $weekNumber){
        if($weekScore != 0 && $weekScore < $lowestWeekScores[$weekNumber - 1]){
            $lowestWeekScores[$weekNumber - 1] = $weekScore;
        }
    }

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