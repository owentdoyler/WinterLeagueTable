<?php
    class WeekScore{
        public $weekNumber;
        public $scores;
        public $amountCounting;

        public function __construct($weekNumber, $scores, $amountCounting){
            $this->weekNumber = $weekNumber;
            $this->scores = $scores;
            $this->amountCounting = $amountCounting;
            $this->sortScores();
        }

        private function sortScores(){
            usort($this->scores, function($a, $b){
                if($a->score < $b->score) return 1;
                elseif ($a->score > $b->score) return -1;
                else return 0;
            });
        }

        public function countingScores(){
            return array_slice($this->scores, 0, $this->amountCounting);
        }

        public function weekScore(){
             $total = 0;
            // for($i = 0; $i < $this->amountCounting; $i++){
            //     $total += $this->scores[$i]->score;
            // }
            // return $total;
            foreach($this->countingScores() as $countingScore){
                $total += $countingScore->nettScore;
            }
            return $total;
        }

        public function toJson(){
            $json = "{\"weekNumber\": \"{$this->weekNumber}\", \"score\": ";
            $json .= $this->weekScore();
            $json.= ", \"individualScores\": [ ";
            
            $individualScores = "";
            foreach($this->scores as $score){
                $individualScores .= $score->toJson();
                $individualScores .= ",";
            }
            $individualScores = substr($individualScores, 0, -1);
            $json .= $individualScores;
            $json .= "]} ";
            
            return $json;
        }
    }
?>