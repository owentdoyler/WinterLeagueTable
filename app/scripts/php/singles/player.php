<?php
    class Player{
        public $name;
        public $scores;
        public $weeksCounting;

        public function __construct($name, $scores, $weeksCounting){
            $this->name = $name;
            $this->scores = $scores;
            $this->weeksCounting = $weeksCounting;
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
            if(sizeof($this->scores) > $this->weeksCounting){
                return array_slice($this->scores, 0, $this->weeksCounting);
            }
            else return $this->scores;     
        }

        public function score(){
            $total = 0;
            foreach($this->countingScores() as $countingScore){
                $total += $countingScore->score;
            }
            return $total;
        }
        
        public function toJson(){ 
            $json = "{\"playerName\": \"{$this->name}\", \"score\": ";
            $json .= $this->score();
            $json.= ", \"scores\": [ ";
            
            $individualScores = "";
            foreach($this->scores as $score){
                $individualScores .= $score->toJson();
                $individualScores .= ",";
            }
            $individualScores = substr($individualScores, 0, -1);
            $json .= $individualScores;
            $json .= "]}";
            
            return $json;        }
    }
?>