<?php
require("../connect.php");

define("WEEK_NUMBER", 0);
define("PLAYER_NAME", 1);
define("SCORE", 2);
define("HANDICAP", 3);

$file = fopen("../../../data/test/presidents__prize_edited.csv","r");

$insert_data = "";
while(! feof($file))
{
    
    $score_data = fgetcsv($file);
    $player_name = $score_data[PLAYER_NAME];
    $team_check_query = "SELECT * FROM teams where player_name = '{$player_name}'";
    $team_check_query_response = @mysqli_query($database, $team_check_query);
    
    if($team_check_query_response && $team_check_query_response->num_rows > 0){
        $handicap_query = "SELECT * FROM winter_handicaps where player_name = '{$player_name}'";
        $handicap_query_response = @mysqli_query($database, $handicap_query);
        $handicap = 0; 
        if($handicap_query_response && $handicap_query_response->num_rows > 0){
            $row = mysqli_fetch_assoc($handicap_query_response);
            $handicap = $row['handicap'];
        }
        array_push($score_data, $handicap);
        $insert_data .= "('{$score_data[PLAYER_NAME]}', '{$score_data[WEEK_NUMBER]}', '{$score_data[HANDICAP]}', '{$score_data[SCORE]}'),";
    }
}

$insert_data = substr($insert_data, 0, -1);
$insert_data .= ";";

$insert_query = "INSERT INTO winter_league_results (player_name, week_number, week_handicap, score) VALUES " . $insert_data;
echo $insert_data;
$insert_query_result = @mysqli_query($database, $insert_query);
echo $insert_query_result->error;
fclose($file);
?>