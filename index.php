<?php

require_once  __DIR__ . '/load.php';


// Récupère les dates des 3 prochains jours
$dates = get_odds_for_the_next_days(3);
// Récupère les URL des paris des dates passées en paramètre
$urls = get_urls_from_dates($dates);


$nodeText = function ($node) {
    return $node->text();
};
$nodeHtml = function ($node) {
    return $node->html();
};
$nodeId = function ($node) {
    return $node->attr('id');
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

        $match_ids = getIdFromEventCrawler($event_crawler, $nodeId);
        $matchs_html = getMatchsContent($event_crawler, $nodeHtml);

        $nb_match = 0;

        foreach ($matchs_html as $match_html){

            $match_crawler = new \Symfony\Component\DomCrawler\Crawler();
            $match_crawler->addHtmlContent($match_html, 'UTF-8');

            $match_equipes = getEquipesFromMatchCrawler($match_crawler);
            $match_cotes = getCotesFromMatchCrawler($match_crawler, $nodeHtml);
            $match_id = explode('_', $match_ids[$nb_match])[1];


            $match_equipe_1 = explode(' - ', $match_equipes)[0];
            $match_equipe_2 = explode(' - ', $match_equipes)[1];

            if(count($match_cotes) == 2){
                $match_cote_equipe_1 = $match_cotes[0];
                $match_cote_nul = "";
                $match_cote_equipe_2 = $match_cotes[1];
            } elseif (count($match_cotes) == 3) {
                $match_cote_equipe_1 = $match_cotes[0];
                $match_cote_nul = $match_cotes[1];
                $match_cote_equipe_2 = $match_cotes[2];
            } else {
                $match_cote_equipe_1 = "";
                $match_cote_nul = "Pariez !";
                $match_cote_equipe_2 = "";
            }



            echo "ID : ".$match_id;
            echo "<p> - ".$match_equipe_1." VS ".$match_equipe_2."</p>";

            echo "<table style='border: black solid 1px'>";
            echo "<tr>";
            echo "<th>Cote Equipe 1</th>";
            echo "<th>Cote Nul</th>";
            echo "<th>Cote Equipe 2</th>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>".$match_cote_equipe_1."</td>";
            echo "<td>".$match_cote_nul."</td>";
            echo "<td>".$match_cote_equipe_2."</td>";
            echo "</tr>";
            echo "</table>";

            //echo "<p>".$match_cote_equipe_1." ".$match_cote_nul." ".$match_cote_equipe_2."</p>";

            $nb_match++;

        }


    }
}



echo "<style>
table , th, td{
    border-width:1px; 
    border-style:solid; 
    border-color:black;
 }
</style>";






