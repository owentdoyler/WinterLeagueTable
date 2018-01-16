<?php
    class WeekScore{
        public $weekNumber;
        public $scores;
        public $amountCounting;
        public $min_score;
        // public $flag; /// flag if number of scores didn't reach the minimum
        // public $overrideScore; // this will be populated with the mimimum score in the given week if the team hasnt fielded enough players

        public function __construct($weekNumber, $scores, $amountCounting, $min_score){
            $this->weekNumber = $weekNumber;
            $this->scores = $scores;
            $this->amountCounting = $amountCounting;
            $this->min_score = $min_score;
            // $this->flag = false;
            // $this->overrideScore = 0;
            $this->fillSupplementScores();
            $this->sortScores();
        }

        private function fillSupplementScores(){
            $scores_amount = sizeof($this->scores);
            if($scores_amount < $this->amountCounting){
                while($scores_amount < $this->amountCounting){
                    array_push($this->scores, new Score("Supplementary", $this->min_score, 0));
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

            // if($this->overrideScore > 0){
            //     return $this->overrideScore;
            // }
            // else{
                $total = 0;
                foreach($this->countingScores() as $countingScore){
                    $total += $countingScore->nettScore;
                }
                return $total;
            // }
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