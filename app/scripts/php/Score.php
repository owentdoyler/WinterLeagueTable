<?php
    class Score{
        public $player;
        public $score;
        public $weekHandicap;
        public $nettScore;
        
        public function __construct($player, $score, $weekHandicap = 0){
            $this->player = $player;
            $this->score = $score;
            $this->weekHandicap = $weekHandicap;
            $this->nettScore = $this->calculateNettScore();
        }

        private function calculateNettScore(){
            return $this->score - $this->weekHandicap;
        }
        
        public function toJson(){ 
            return "{\"playerName\": \"{$this->player}\", \"weekHandicap\": \"{$this->weekHandicap}\", \"individualScore\": \"{$this->nettScore}\"}";
        }
    }
?>