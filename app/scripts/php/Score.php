<?php
    class Score{
        public $player;
        public $score;
        public $weekHandicap;
        public $nettScore;
        public $domesticReductionUsed;
        public $weekNumber;

        public function __construct($player, $score, $weekHandicap, $weekNumber){
            $this->player = $player;
            $this->score = $score;
            $this->weekHandicap = $weekHandicap;
            $this->nettScore = $this->calculateNettScore();
            $this->weekNumber = $weekNumber;
        }

        private function calculateNettScore(){
            $this->domesticReductionUsed = ($this->weekHandicap > 0)? "*": "";    
            return $this->score - $this->weekHandicap;
        }
        
        public function toJson(){ 
            return "{\"playerName\": \"{$this->player}\", \"weekHandicap\": \"{$this->weekHandicap}\", \"individualScore\": \"{$this->nettScore}{$this->domesticReductionUsed}\", \"weekNumber\": \"{$this->weekNumber}\"}";
        }
    }
?>