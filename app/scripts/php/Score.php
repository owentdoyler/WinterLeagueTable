<?php
    class Score{
        public $player;
        public $score;
        public $weekNumber;

        public function __construct($player, $score, $weekNumber){
            $this->player = $player;
            $this->score = $score;
            $this->weekNumber = $weekNumber;
        }    
        
        public function toJson(){ 
            return "{\"playerName\": \"{$this->player}\", \"individualScore\": \"{$this->score}\", \"weekNumber\": \"{$this->weekNumber}\"}";
        }
    }
?>