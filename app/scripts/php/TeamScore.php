<?php
    class TeamScore{
        public $teamName;
        public $weeks = array();
        public $amountCounting;
        
        public function __construct($teamName, $weeks, $amountCounting){
            $this->teamName = $teamName;
            $this->weeks = $weeks;
            $this->amountCounting = $amountCounting;
            $this->sortScores();
        }

        private function sortScores(){
            usort($this->weeks, function($a, $b){
                if($a->weekScore() < $b->weekScore()) return 1;
                elseif ($a->weekScore() > $b->weekScore()) return -1;
                else return 0;
            });
        }

        private function countingWeeks(){
            return array_slice($this->weeks, 0, $this->amountCounting);
        }

        public function teamScore(){
            $total = 0;
            foreach($this->countingWeeks() as $week){
                $total += $week->weekScore();
            }
            return $total;
        }

        public function toJson(){
            $json = "{\"name\": \"{$this->teamName}\", \"score\": ";
            $json .= $this->teamScore();
            $json .= ", \"weeks\":[ ";
            
            $weekScores = "";
            foreach($this->weeks as $week){
                $weekScores .= $week->toJson();
                $weekScores .= ",";
            }
            $weekScores = substr($weekScores, 0, -1);
            $json .= $weekScores;
            $json .= "]} ";
            return $json;
        }
    }
?>