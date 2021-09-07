<?php 
$key="57ef20f1";
$movielist=fopen("movielist.short","r");
while ($movie=fgets($movielist)){
    $new=str_replace(" ","%20",$movie);
    $url="http://www.omdbapi.com/?i=tt3896198&apikey=".$key."&t=".$new;
    $jsonText=file_get_contents($url);
    $json=json_decode($jsonText, true);
    if ($json["Response"]=="True"){
        if(preg_match("/TV.*/",$json["Rated"])){$validMovie=false;}else{$validMovie=true;}
        if(preg_match("/[0-9]{4}.+/",$json["Year"])){$validYear=false;}else{$validYear=true;}
        if(preg_match("/N\/A/",$json["Genre"])){$validGenre=false;}else{$validGenre=true;}
        if(preg_match("/[0-9] h [0-9]/",$json["Runtime"])){$validRuntime=false;}else{$validRuntime=true;}
    if ($validMovie and $validYear and $validGenre and $validRuntime){
            $mTitle=str_replace("'N/A'","NULL","'".str_replace("'","\'",$json["Title"])."'");
            $mPlot=str_replace("'N/A'","NULL","'".str_replace("'","\'",$json["Plot"])."'");
            $mYear=str_replace("'N/A'","NULL","'".str_replace("'","\'",$json["Year"])."'");
            $mRating=str_replace("'N/A'","NULL","'".str_replace("'","\'",$json["Rated"])."'");
            $mRuntime=str_replace("'N/A'","NULL","'".str_replace(" min","",$json["Runtime"])."'");
            $mGenre=str_replace("'N/A'","NULL","'".str_replace(", ",",",str_replace("'","\'",$json["Genre"]))."'");
            $mLanguage=str_replace("'N/A'","NULL","'".str_replace("'","\'",$json["Language"])."'");
            $mCountry=str_replace("'N/A'","NULL","'".str_replace("'","\'",$json["Country"])."'");
            $mDirector=str_replace("'N/A'","NULL","'".str_replace(", ",",",preg_replace("/\(.*\)/","t",str_replace("'","\'",$json["Director"])))."'");
            $mWriter=str_replace("'N/A'","NULL","'".str_replace(", ",",",preg_replace("/\(.*\)/","t",str_replace("'","\'",$json["Writer"])))."'");
            $mActors=str_replace("'N/A'","NULL","'".str_replace(", ",",",preg_replace("/\(.*\)/","t",str_replace("'","\'",$json["Actors"])))."'");
            $mPrice=str_replace("'N/A0'","'".(2.2*rand(1,4))."0"."'","'".$json["imdbRating"]."0"."'");
            print("INSERT INTO Movies (mName, mDescription, mGenre, mRating, mYear, mRuntime, mLanguage, mCountry, mDirector, mWriter, mActors, mPrice) VALUES ($mTitle, $mPlot, $mGenre, $mRating, $mYear, $mRuntime, $mLanguage, $mCountry, $mDirector, $mWriter, $mActors, $mPrice);");print("<br>");
        }
    }
}
?>
