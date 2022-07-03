<?php

//still testing
//create class for brute force, preprocess, and word2vec
//implement with database
include __DIR__ . '/vendor/autoload.php';

use PHPW2V\Word2Vec;
use PHPW2V\SoftmaxApproximators\NegativeSampling;

session_start();

class StringPattern{

    function brute_force ($pattern, $text){
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

    function remove_stopwords($input){
        $commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards',
        'again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although',
        'always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways',
        'anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at',
        'available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before',
        'beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by',
        'c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.',
        'com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could',
        'couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly',
        'does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either',
        'elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone',
        'everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five',
        'followed','following','follows','forever','former','formerly','forth','forward','found','four','from','further','furthermore',
        'g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens',
        'hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby',
        'herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however',
        'hundred','i','i\'d','ie','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated',
        'indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve',
        'j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest',
        'let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make',
        'makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more',
        'moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary',
        'need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non',
        'none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of',
        'off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise',
        'ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per',
        'perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd',
        're','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s',
        'said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves',
        'sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t',
        'since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon',
        'sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than',
        'thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence',
        'there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve',
        'these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly',
        'those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries',
        'truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely',
        'until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via',
        'viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve',
        'what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein',
        'where\'s','whereupon','wherever','whether','which','whichever','whilst','whither','who','who\'d','whoever','whole',
        'who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would',
        'wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');

        $input = preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);
        $input = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $input)));
        return $input;
    }

    function word2vec($trainData, $targetWords){
        $dimensions     = 150; //vector dimension size
            $sampling       = new NegativeSampling; //Softmax Approximator
            $minWordCount   = 2; //minimum word count
            $alpha          = .05; //the learning rate
            $window         = 5; //window for skip-gram
            $epochs         = 500; //how many epochs to run
            $subsample      = 0.05; //the subsampling rate
    
            $word2vec = new Word2Vec($dimensions, $sampling, $window, $subsample,  $alpha, $epochs, $minWordCount);
            $word2vec->train($trainData);
            $word2vec->save('my_word2vec_model');
    
            $word2vec = new Word2Vec();
            $word2vec = $word2vec->load('my_word2vec_model');
        
            
                foreach($targetWords as $word){
                    echo $word;
                    echo "<br>";
                    
                    try{
                        $mostSimilar = $word2vec->mostSimilar([$word]); 
                    }catch(InvalidArgumentException $e){
                        if ($mostSimilar == null){
                            echo $word;
                        }
                    }
                    
                    print_r($mostSimilar);
                    echo "<br>";
                    
                    $similarLO[] = $mostSimilar;
                }
    
        return $similarLO;
        
    }
}

$certificationLO = "Introduced to object-oriented programming concepts, terminology, and syntax
The steps to required to create basic Java programs using hands-on, engaging activities
Learn the concepts of Java programming, design object-oriented applications with Java and create Java programs using hands-on, engaging activities "; //certification

$courseLO = "How Java works and its place in the world of programming languages
To work with and manipulate strings
To perform math operations
To work with Java operators and loops 
To gain a deeper understaning of Object Oriented Programming Concepts
To make best use of the Java collections framework
Best practices for dealing with exceptions
To package Java code
Work with external data storage systems"; //course

// store all topics in one array
$topics = array($certificationLO, $courseLO);

//initialize object
$s = new StringPattern();

//remove Stopwords
foreach($topics as $input){
    $input = strtolower($input);
    $removeStopwords = $s->remove_stopwords($input);
    $LONoStopwords[] = $removeStopwords;
}

//print_r($LONoStopwords);
//Array [0]: certification
// Array[1]: course
echo "<br>";
echo "<br>";

//tokenize words and set words pattern
$pattern = explode(" ", $LONoStopwords[1]);

//print_r($pattern);
echo "<br>";
echo "<br>";

//set text
$text = $LONoStopwords[0];
//print_r($text);
//echo "<br>";

foreach($pattern as $LO){
    //echo $topic . " - ";
    //echo $text;
    //echo "<br>";
    
    //check for common words
    $bf = $s->brute_force($LO, $text);

    //if words are commmon, transfer to array
    if($bf != -1){
        $commonLO[] = $LO;
    }
}

//common topics between certification and course

echo "IDENTICAL WORDS IN COURSE AND CERTIFICATION LO";
echo "<br>";
$commonLO = array_unique($commonLO);
print_r($commonLO);

echo "<br>";
echo "<br>";

$trainData = $LONoStopwords;
$targetWords = $commonLO;

echo "<br>";
echo "SCORES FOR EACH IDENTICAL WORD";
echo "<br>";
$w2v = $s->word2vec($trainData, $targetWords);

echo "<br>";
//print_r($w2v);


/*
for($x=0; $x<count($w2v); $x++)
{
   foreach($w2v[$x] as $row){ //lowercase
    echo $row . "<br>";
   }
   echo "<br>";
}
echo "<br>";*/

for($x=0; $x<count($w2v); $x++)
{
   foreach($w2v[$x] as $row){ //lowercase
    if($row > 0){
        $matched[] = $row;
    }
   }
   echo "<br>";
}
//words with positive scores
echo "WORDS THAT ARE RELEVANT BETWEEN COURSE AND CERTIFICATION";
echo "<br>";
print_r($matched);

echo "<br>";
echo "<br>";
//print_r ($LONoStopwords[0]);

/*foreach($LONoStopwords[0] as $word){ //lowercase
    $words = implode(',',array_unique(explode(',', $word)));
}*/

$words = implode(',',array_unique(explode(' ', $LONoStopwords[0])));
echo "<br>";
echo "<br>";
print_r ($words);
?>
