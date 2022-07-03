<?php 
//Preprocessing Text: course outcomes, course topics
//                    certification objectives, certification topics
include 'connect-db.php';   

class Preprocess
{
    public function removeStopwords($text){
        $Stopwords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards',
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

        $text = preg_replace('/\b('.implode('|',$Stopwords).')\b/','',$text);
        $text = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $text)));
        return $text;
    }

    
    public function courseTQuery(){ //COURSE TOPICS
        include 'connect-db.php';
        $id = $_GET["id"]; //course id

        $query = "SELECT topic 
                FROM course_topics 
                WHERE course_id =  $id";
        $result = mysqli_query($db, $query);

        $array = $result->fetch_all(MYSQLI_ASSOC);
        $output = $this->convertToString($array);
        $output = implode(" ",$output);
        $text = strtolower($output);
        $output = $this->removeStopwords($text);

        return $output;
    }

    
    public function certTQuery(){ //CERTIFICATION TOPICS
        include 'connect-db.php';
        $id = $_GET['id']; //course id
        
        $query = "SELECT topic
        FROM certification_topics
        WHERE certification_topics.course_id = $id";
        $result = mysqli_query($db, $query);

        $array = $result->fetch_all(MYSQLI_ASSOC);
        $output = $this->convertToString($array);
        $output = implode(" ",$output);
        $text = strtolower($output);
        $output = $this->removeStopwords($text);

        return $output;
    }

    
    public function courseLOQuery(){ //COURSE OUTCOMES
        include 'connect-db.php';
        $id = $_GET["id"]; //course id
        $query = "SELECT outcome 
                FROM course_outcomes 
                WHERE course_id =  $id";

        $result = mysqli_query($db, $query);
        $array = $result->fetch_all(MYSQLI_ASSOC);
        $output = $this->convertToString($array);
        $output = implode(" ",$output);     
        $text = strtolower($output);
        $output = $this->removeStopwords($text);

        return $output;
    }

    
    public function certLOQuery(){ //CERTIFICATION OBJECTIVES
        include 'connect-db.php';
        $id = $_GET['id']; //course id
        $query = "SELECT objective
        FROM certification_objectives
        WHERE certification_objectives.course_id = $id";

        $result = mysqli_query($db, $query);
        $array = $result->fetch_all(MYSQLI_ASSOC);
        $output = $this->convertToString($array);
        $output = implode(" ",$output);
        $text = strtolower($output);
        $output = $this->removeStopwords($text);
        
        return $output;
    }

    public function certContentQuery(){ //for word2vec
        include 'connect-db.php';
        $query2 = "SELECT id FROM certification";

        $query = "SELECT name FROM certification";
        $array = mysqli_query($db, $query);
        $result = $array->fetch_all(MYSQLI_ASSOC);
        
        if ($result=mysqli_query($db, $query2)) {
            $rowcount=mysqli_num_rows($result);
            $c = $rowcount; 
        } // get amount of certifications

        for($i=1; $i<$c+1; $i++){
            $query = "SELECT topic FROM certification_topics
            WHERE certification_id = $i
            UNION
            SELECT objective FROM certification_objectives
            WHERE certification_id = $i";

            $array = mysqli_query($db, $query);
            $output = $this->convertToString($array);   
            $output2 = implode(" ", $output);
            $text = strtolower($output2); //lowercase certification content
            $output2 = $this->removeStopwords($text); //remove stopwords
            $cert = explode(" ", $output2); //revert back to array
            $certifications[] = array_unique($cert); //2D array for word2vec
            
        }
        return $certifications;
    }

    public function test(){
        include 'connect-db.php';
        $query = "SELECT id, name FROM certification";
        $array = mysqli_query($db, $query);
        
        $result = $array->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    function convertToString ($array) { //convert array to string
        $out = array();
        foreach ($array as $b) {
            foreach ($b as $c) {
                if (isset($c)) {
                    $out[] = $c;
                }
            }
        }
        return $out;
    }
}

$preprocess = new Preprocess();

////////////////////Course Topics
$courseT = $preprocess->courseTQuery();
//echo "COURSE TOPICS <br>";
echo "<pre>";
//print_r($courseT);
echo "<pre>";

//echo "<br><br>";

////////////////////Certification Topics
//echo "CERTIFICATION TOPICS <br>";
$certT = $preprocess->certTQuery();
echo "<pre>";
//print_r($certT);
echo "<pre>";

//echo "<br><br>";

////////////////////Course Outcomes
$preprocess = new Preprocess();
//echo "COURSE OUTCOMES <br>";
$courseLO = $preprocess->courseLOQuery();
echo "<pre>";
//print_r($courseLO);
echo "<pre>";

//echo "<br><br>";

////////////////////Certification Objectives
//echo "CERTIFICATION OBJECTIVES <br>";
$certLO = $preprocess->certLOQuery();
echo "<pre>";
//print_r($certLO);
echo "<pre>";

//echo "<br><br>";

////////////////////Certification Content for Word2Vec
$certification = $preprocess->certContentQuery();
//print_r($certification);
echo "<pre>";
//print_r($certification);
echo "<pre>";

$test = $preprocess->test(); //array of certification names and id only
//echo "<pre>";
//print_r($test);
//echo "<pre>";

foreach($certification as $c){ //array of certification content
    $sample[] = implode(" ", $c); 
}
//echo "<pre>";
//print_r($sample);
//echo "<pre>";

//echo "<br> <br>";

//certification input
for($i=0; $i<count($test); $i++){
        $y[]["certification"] = $test[$i]['name'];
        $y[$i]["tags"] = $sample[$i]; //need to add tags to certification array
        $y[$i]["tags"] = explode(" ", $y[$i]["tags"]);
}

//echo "<br><br>";

echo "<pre>";
//print_r($y);
echo "<pre>";

//For BruteForce.php
$bf1 = $courseT;
$bf2 = $certT;
$bf3 = $courseLO;
$bf4 = $certLO;
$bf5 = $y;
?>