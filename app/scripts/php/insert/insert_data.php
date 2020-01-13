<?php
require("../connect.php");

define("WEEK_NUMBER", 0);
define("PLAYER_NAME", 1);
define("SCORE", 2);
define("HANDICAP", 3);

$file = fopen("../../../data/scores/2020/week1/week1-scores.csv","r");

$insert_data = "";
$weekNumber = "";
$scores = array();
while(! feof($file))
{
    $score_data = fgetcsv($file);
    $player_name = $score_data[PLAYER_NAME];
    $player_name = str_replace("'", " ", $player_name);
    $player_name = str_replace(".", "", $player_name);
    $player_score = $score_data[SCORE];
    $weekNumber = $score_data[WEEK_NUMBER];
    $team_check_query = "SELECT * FROM winter_league_teams where player_name = '{$player_name}'";
    $team_check_query_response = @mysqli_query($database, $team_check_query);
    if($team_check_query_response && $team_check_query_response->num_rows > 0){
        /* REMOVED BECAUSE DOMESTIC HANDICAPS AREN'T BEING USED
        $handicap_query = "SELECT * FROM winter_league_handicaps where player_name = '{$player_name}'";
        $handicap_query_response = @mysqli_query($database, $handicap_query);
        $handicap = 0; 
        if($handicap_query_response && $handicap_query_response->num_rows > 0){
            $row = mysqli_fetch_assoc($handicap_query_response);
            $handicap = $row['handicap'];
        }*/

        if (array_key_exists($player_name, $scores)) {
            $score = $scores[$player_name];
            $scores[$player_name] = $score > $player_score ? $score : $player_score;
        } else {
            $scores[$player_name] = $player_score;
        }
        array_push($score_data, 0);
    }
}

foreach ($scores as $playerName => $score) {
    $insert_data .= "('{$playerName}', '{$weekNumber}', '0', '{$score}'),";
}

$insert_data = substr($insert_data, 0, -1);
$insert_data .= ";";

$insert_query = "INSERT INTO winter_league_results (player_name, week_number, week_handicap, score) VALUES " . $insert_data;
echo $insert_query;
echo $insert_data;
$insert_query_result = @mysqli_query($database, $insert_query);
echo $insert_query_result->error;
fclose($file);
?>