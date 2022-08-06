<?php

//Brute Force, get same words

include 'preprocess.php';

$course_topics = $courseT;
$certification_topics = $certT;
$course_outcomes = $courseLO;
$certification_objectives = $certLO;

class StringPattern{
        public function brute_force($pattern, $text){
        $t = strlen($text);
        $p = strlen($pattern);

        for($i=0; $i<=$t-$p; $i++){
            $j=0;
            while($j < $p && $text[$i+$j] == $pattern[$j]){
                $j++;
            }
            if($j == $p){
                return $i;
            }
        }
        return -1;
    }
}

$s = new StringPattern();

$topics = array($certification_topics, $course_topics);
$LO = array($certification_objectives, $course_outcomes);

//tokenize course content and set as pattern
$patternT = explode(" ", $topics[1]);
$patternLO = explode(" ", $LO[1]);

//set certification content as text
$textT = $topics[0];
$textLO = $LO[0];

foreach($patternT as $topic){
    
    //check for common words
    $bf = $s->brute_force($topic, $textT);

    //if words are commmon, transfer to array
    if($bf != -1){
        $commonT[] = $topic;
    }
}

foreach($patternLO as $LO){
    
    //check for common words
    $bf = $s->brute_force($LO, $textLO);

    //if words are commmon, transfer to array
    if($bf != -1){
        $commonLO[] = $LO;
    }
}

//common topics between certification and course
//remove duplicates
$commonLO = array_unique($commonLO);

$commonT = array_unique($commonT);

$same = array_merge($commonLO, $commonT); //merge topics and outcomes
$word = array_unique($same); //remove duplicates
$w = array_values($word); //re number array              

$targetBF = $word; //for test class
?>
