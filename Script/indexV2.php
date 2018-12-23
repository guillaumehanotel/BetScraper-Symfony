<?php

require_once __DIR__ . '/load.php';


// Récupère les URL des paris des dates passées en paramètre
$url = 'https://www.betclic.fr/calendrier-0';


$nodeText = function ($node) {
    return $node->text();
};
$nodeHtml = function ($node) {
    return $node->html();
};
$nodeId = function ($node) {
    return $node->attr('id');
};

try {
    $html = get_html_content($url);
    $html = substr($html, 72461);
    $crawler = new \Symfony\Component\DomCrawler\Crawler();
    $crawler->addHtmlContent($html, 'UTF-8');

    $get_html = true;
} catch (InvalidArgumentException $ex) {
    echo "\n \033[31m Fail\033[0m \n";
    //$get_html = true;
}




$date_today = getDateToday();

try {
    $day_crawler = getFirstDayContent($crawler);
    //$content_date = getDateFromDayCrawler($day_crawler);
} catch(InvalidArgumentException $ex){
    echo "Fail";
}

echo 'yo';
echo $day_crawler;
echo 'yo';

/*

$date_array = getDateArray($content_date);
$date_formatted = $date_array['annee'] . '-' . $date_array['mois'] . '-' . $date_array['jour'];


// tableau contenant chaque horaire
$horaires_html = getHorairesContent($day_crawler, $nodeHtml);

//echo "<h2>" . $content_date . "</h2>";
echo "\033[33m".$content_date . "\033[0m \n";

// Parcourt des horaires
foreach ($horaires_html as $horaire_html) {
    // Crawler sur chaque horaire
    $horaire_crawler = new \Symfony\Component\DomCrawler\Crawler();
    $horaire_crawler->addHtmlContent($horaire_html, 'UTF-8');

    $horaire = getHourFromHoraireCrawler($horaire_crawler);
    $heure_formatted = $horaire . ":00";


    ///echo "<br>";
    ///echo "<h3>" . $horaire . "</h3>";

    echo "\033[32m".$horaire . "\033[0m \n";


    // tableau contenant chaque event
    $events_html = getEventsContent($horaire_crawler, $nodeHtml);

    // Parcourt des events
    foreach ($events_html as $event_html) {
        // Crawler sur chaque event
        $event_crawler = new \Symfony\Component\DomCrawler\Crawler();
        $event_crawler->addHtmlContent($event_html, 'UTF-8');

        $event_info = getEventInfoFromEventCrawler($event_crawler);

        // sport du match
        $event_sport = explode(", ", $event_info)[0];
        $event_name = explode(", ", $event_info)[1];

        // INSERT SPORT
        $sport_id = insertSport($bdd, $event_sport);


        ///echo "<br>";
        ///echo "<p style='text-decoration: underline'>" . $event_sport . " : " . $event_name . "</p>";

        echo "\033[31m".$event_sport . "\033[0m \n";

        $match_ids = getIdFromEventCrawler($event_crawler, $nodeId);
        $matchs_html = getMatchsContent($event_crawler, $nodeHtml);

        $nb_match = 0;

        foreach ($matchs_html as $match_html) {

            $match_crawler = new \Symfony\Component\DomCrawler\Crawler();
            $match_crawler->addHtmlContent($match_html, 'UTF-8');

            $match_equipes = getEquipesFromMatchCrawler($match_crawler);
            $match_cotes = getCotesFromMatchCrawler($match_crawler, $nodeHtml);

            // si jamais ce n'est pas un match : pas de tiret présent dans les noms des équipes
            if (strpos($match_equipes, ' - ') !== false) {

                // l'ID du match
                $match_id = explode('_', $match_ids[$nb_match])[1];
                // l'equipe 1 du match
                $match_equipe_1 = trim(explode(' - ', $match_equipes)[0]);
                // l'equipe 2 du match
                $match_equipe_2 = trim(explode(' - ', $match_equipes)[1]);
                // la date du match
                $match_date = $date_formatted . " " . $heure_formatted;

                if (!empty($match_equipe_1) && !empty($match_equipe_2)) {

                    $equipe1_id = insertEquipe($bdd, $match_equipe_1);
                    $equipe2_id = insertEquipe($bdd, $match_equipe_2);

                    insertMatch($bdd, $match_id, $match_date, $sport_id, $equipe1_id, $equipe2_id);

                    if (count($match_cotes) == 2) {
                        // Pas de cote nul
                        // Tennis, BasketBall, Volley-ball, Formule 1, Football américain, Baseball
                        $match_cote_equipe_1 = $match_cotes[0];
                        $match_cote_nul = "";
                        $match_cote_equipe_2 = $match_cotes[1];
                        insertCote($bdd, $match_id, $match_cote_equipe_1, $match_cote_equipe_2, $match_cote_nul, $date_today);

                    } elseif (count($match_cotes) == 3) {
                        // Cote nul
                        // Football, Rugby, Handball, Hockey sur glace, Boxe, Ski Alpin, Ski de fond
                        $match_cote_equipe_1 = $match_cotes[0];
                        $match_cote_nul = $match_cotes[1];
                        $match_cote_equipe_2 = $match_cotes[2];
                        insertCote($bdd, $match_id, $match_cote_equipe_1, $match_cote_equipe_2, $match_cote_nul, $date_today);

                        // "Pariez !"
                    } else {
                        $match_cote_equipe_1 = null;
                        $match_cote_nul = null;
                        $match_cote_equipe_2 = null;
                        // si on rencontre un match sans cote, supprimer toutes les cotes de ce match
                        cleanCotesFromMatch($bdd, $match_id, $date_today);
                    }


                }
            }


            //$td_match_cote_equipe_1 = ($match_cote_equipe_1 >= 10) ? "<td style='color: red; font-weight: bold'>" . $match_cote_equipe_1 . "</td>" : "<td>" . $match_cote_equipe_1 . "</td>";
            //$td_match_cote_equipe_2 = ($match_cote_equipe_2 >= 10) ? "<td style='color: red; font-weight: bold'>" . $match_cote_equipe_2 . "</td>" : "<td>" . $match_cote_equipe_2 . "</td>";
            //$td_match_cote_nul = ($match_cote_nul >= 10) ? "<td style='color: red; font-weight: bold'>" . $match_cote_nul . "</td>" : "<td>" . $match_cote_nul . "</td>";


            if(isset($match_id) && isset($match_equipe_1) && isset($match_equipe_2)){
                echo "ID : " . $match_id;
                echo " - " . $match_equipe_1 . " VS " . $match_equipe_2 . "\n";
            }

            //echo "<p> - " . $match_equipe_1 . " VS " . $match_equipe_2 . "</p>";

            //echo "<table style='border: black solid 1px'>";
            //echo "<tr><th>Cote Equipe 1</th><th>Cote Nul</th><th>Cote Equipe 2</th></tr>";
            //echo "<tr>" . $td_match_cote_equipe_1 . $td_match_cote_nul . $td_match_cote_equipe_2 . "</tr>";
            //echo "</table>";

            $nb_match++;

        }


    }
}

*/

/*echo "<style>
table , th, td{
    border-width:1px;
    border-style:solid;
    border-color:black;
 }
</style>";

*/




