<?php
    class WeekScore{
        public $weekNumber;
        public $scores;
        public $amountCounting;
        public $min_score;

        public function __construct($weekNumber, $scores, $amountCounting, $min_score){
            $this->weekNumber = $weekNumber;
            $this->scores = $scores;
            $this->amountCounting = $amountCounting;
            $this->min_score = $min_score;
            $this->fillSupplementScores();
            $this->sortScores();
        }

        private function fillSupplementScores(){
            $scores_amount = sizeof($this->scores);
            if($scores_amount < $this->amountCounting){
                while($scores_amount < $this->amountCounting){
                    array_push($this->scores, new Score("Supplementary", $this->min_score, 0, $this->weekNumber));
                    $scores_amount++;
                }
            }
        }

        private function sortScores(){
            usort($this->scores, function($a, $b){
                if($a->score < $b->score) return 1;
                elseif ($a->score > $b->score) return -1;
                else return 0;
            });
        }

        public function countingScores(){
            if(sizeof($this->scores) > $this->amountCounting){
                return array_slice($this->scores, 0, $this->amountCounting);
            }
            else return $this->scores;     
        }

        public function weekScore(){

                $total = 0;
                foreach($this->countingScores() as $countingScore){
                    $total += $countingScore->score;
                }
                return $total;
        }

        public function toJson(){
            $json = "{\"rowData\": {\"weekNumber\": \"Week {$this->weekNumber}\", \"score\": ";
            $json .= $this->weekScore();
            $json .= "}, \"subRows\": [{\"rowData\": { \"columnData\": [ ";
            
            // $individualScores = "";
            $individualPlayers = array();
            $individualPlayerScores = array();
            foreach($this->scores as $score){
                array_push($individualPlayers, $score->player);
                array_push($individualPlayerScores, $score->score);
                // $individualScores .= $score->toJson();
                // $individualScores .= ",";
            }

            foreach ($individualPlayers as $player) {
                $json .= "\"{$player}\",";
            }
            $json = substr($json, 0, -1);
            $json .= "]}}, {\"rowData\": { \"columnData\": [ ";

            foreach ($individualPlayerScores as $playerScore) {
                $json .= "\"{$playerScore}\",";
            }
            $json = substr($json, 0, -1);
            $json .= "]}}]}";

            // $individualScores = substr($individualScores, 0, -1);
            // $json .= $individualScores;
            // $json .= "}}]";
            
            return $json;
        }
    }
?>