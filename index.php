<?php

ini_set('display_errors', 2);

require_once __DIR__.'/vendor/autoload.php';

require_once  __DIR__.'/function.php';
require_once  __DIR__.'/crawler_function.php';




// Récupère les dates des 3 prochains jours
$dates = get_odds_for_the_next_days(3);
// Récupère les URL des paris des dates passées en paramètre
$urls = get_urls_from_dates($dates);


$nodeText = function ($node) {
    return $node->text();
    //return preg_replace('/\s+/', '', $node->text());
    //return $node->attr('class')
};

$nodeHtml = function ($node) {
    return $node->html();
    //return htmlentities($node->html());
};

/*
foreach ($urls as $url){
    $html = get_html_content($url);
    $html = substr($html, 72461);
    $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
    $element = $crawler->filter($cssSelector)->each($maFonction);
    $elements[] = $element;
}
*/


$get_html = false;

while ($get_html != true){

    try {
        $html = get_html_content($urls[0]);
        $html = substr($html, 72461);
        $crawler = new \Symfony\Component\DomCrawler\Crawler();
        $crawler->addHtmlContent($html, 'UTF-8');

        $get_html = true;
    } catch (InvalidArgumentException $ex){
        //echo "Fail";
        //$get_html = true;
    }

}





$day_crawler = getFirstDayContent($crawler);
$content_date = getDateFromDayCrawler($day_crawler);

// tableau contenant chaque horaire
$horaires_html = getHorairesContent($day_crawler, $nodeHtml);

echo "<h2>".$content_date."</h2>";

// Parcourt des horaires
foreach ($horaires_html as $horaire_html){
    // Crawler sur chaque horaire
    $horaire_crawler = new \Symfony\Component\DomCrawler\Crawler();
    $horaire_crawler->addHtmlContent($horaire_html, 'UTF-8');
    $horaire = getHourFromHoraireCrawler($horaire_crawler);
    echo "<br>";
    echo "<h3>".$horaire."</h3>";

    // tableau contenant chaque event
    $events_html = getEventsContent($horaire_crawler, $nodeHtml);

    // Parcourt des events
    foreach ($events_html as $event_html){
        // Crawler sur chaque event
        $event_crawler = new \Symfony\Component\DomCrawler\Crawler();
        $event_crawler->addHtmlContent($event_html, 'UTF-8');

        $event_info = getEventInfoFromEventCrawler($event_crawler);
        $event_sport = explode(", ", $event_info)[0];
        $event_name = explode(", ", $event_info)[1];

        echo "<br>";

        echo "<p style='text-decoration: underline'>".$event_sport." : ".$event_name."</p>";

        $matchs_html = getMatchsContent($event_crawler, $nodeHtml);

        foreach ($matchs_html as $match_html){

            $match_crawler = new \Symfony\Component\DomCrawler\Crawler();
            $match_crawler->addHtmlContent($match_html, 'UTF-8');

            $match_equipes = getEquipesFromMatchCrawler($match_crawler);
            $match_equipe_1 = explode(' - ', $match_equipes)[0];
            $match_equipe_2 = explode(' - ', $match_equipes)[1];

            echo "<p> - ".$match_equipe_1." VS ".$match_equipe_2."</p>";

            /*
            foreach (str_split($match_equipes) as $letter){
                echo htmlspecialchars($letter)." : ".ord($letter);
                echo "<br>";
            }*/


            /*
            echo "&#246;";
            echo "ö";
            */

        }


    }
}

//var_dump($horaires_html);


/*
var_dump($urls[0]);
var_dump($content_date);
var_dump(htmlspecialchars($html_day->html()));
*/











