<?php

// Score
function toJson(){ 
	return "{playerName: \"{$playerName}\", individualScore: \"{$score}\"}";
}

//WeekScore
function toJson(){
	$json = "{weekNumber \"{$number}\", score: ";
	$json .= weekScore();
	$json.= ", individualScores:[ ";
	
	$individualScores = "";
	foreach($scores as $score){
		$individualScores .= $score->toJson();
		$individualScores .= ",";
	}
	$individualScores = substr($individualScores, 0, -1);
	$json .= $individualScores;
	$json .= "]} ";
	
	return $json;
}

//TeamScore
function toJson(){
	$json = "{name=\"{$teamName}\", score: ";
	$json .= teamScore();
	$json= .= ", weeks:[ ";
	
	$weekScores = "";
	foreach($weekScores as $weeekScore){
		$weeekScores .= $weeekScore->toJson();
		$weeekScores .= ",";
	}
	$weeekScores = substr($weeekScores, 0, -1);
	$json .= $weeekScores;
	$json .= "]} "
}

?>