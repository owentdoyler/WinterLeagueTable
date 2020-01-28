<?php
    class TeamScore{
        public $teamName;
        public $weeks = array();
        public $amountCounting;
        public $players;
        
        public function __construct($teamName, $weeks, $amountCounting, $players){
            $this->teamName = $teamName;
            $this->weeks = $weeks;
            $this->amountCounting = $amountCounting;
            $this->players = $players;
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
            $json = "{\"rowData\": {\"name\": \"{$this->teamName}\", \"score\": ";
            $json .= $this->teamScore();
            $json .= "}, \"subRows\":[ ";
            
            $weekScores = "";
            foreach($this->weeks as $week){
                $weekScores .= $week->toJson();
                $weekScores .= ",";
            }
            $weekScores = substr($weekScores, 0, -1);
            $json .= $weekScores;
            $json .= "]";
            $json .= ", \"players\": [";
            foreach($this->players as $player){
                $json .= "\"{$player}\",";
            }
            $json = substr($json, 0, -1);
            return $json .= "]}";
        }
    }
?>