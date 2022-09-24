<?php

//Brute Force2, get same words

include 'preprocess2.php';

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

$topics = array($course_topics, $certification_topics);
$LO = array($course_outcomes, $certification_objectives);

print_r($topics);
echo "<br><br>";
print_r($LO);

//tokenize CERTIFICATION content and set as pattern
$patternT = explode(" ", $topics[1]);
$patternLO = explode(" ", $LO[1]);

//set COURSE content as text
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

echo "<br><br>";
print_r($commonLO);
echo "<br><br>";
print_r($commonT);

$same = array_merge($commonLO, $commonT); //merge topics and outcomes
$word = array_unique($same); //remove duplicates
$w = array_values($word); //re number array              

$targetBF = $word; //for test2 class
