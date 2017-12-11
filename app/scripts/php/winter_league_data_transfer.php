<?php
    require("connect.php");

    //=========================== Transfer data from old format to new format ==============================================

    // $players_query = "SELECT * FROM winter_league_scores";
    // $players_query_response = @mysqli_query($database, $players_query);
    
    // $weeks = array("WEEK_1", "WEEK_2", "WEEK_3", "WEEK_4", "WEEK_5", "WEEK_6");

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

    //=========================== Transfer data from old format to teams table ==============================================    

    // $player_team_query = "SELECT DISTINCT a.player_name, b.TEAM_NAME  FROM WINTER_LEAGUE_RESULTS a INNER JOIN winter_league_scores b on a.player_name = b.PLAYER_NAME";
    // $players_query_response = @mysqli_query($database, $player_team_query);
    // if ($players_query_response) echo "yes"; else echo "no"; 
    // while($row = mysqli_fetch_array($players_query_response)){
    //     echo "{$row['player_name']}" . "   " . "{$row['TEAM_NAME']}<br><br>"; 
    // }
    
    // $team_insert_query = "INSERT INTO teams {$player_team_query}";
    // $players_query_response = @mysqli_query($database, $team_insert_query); 
?>