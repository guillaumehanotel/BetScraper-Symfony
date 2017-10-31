<?php

/**
 * Fonction prenant en paramètre un nombre de jour,
 * Retourne une liste d'objets DateTime concernant les dates
 * des X prochains jours
 * @param $nb_day
 * @return array $dates
 */
function get_odds_for_the_next_days($nb_day){
    $dates = [];

    $i = 1;
    while ($i <= $nb_day){
        if($i == 1){
            $dates[] = new \DateTime('now');
        } elseif ($i == 2){
            $dates[] = new \DateTime('tomorrow');
        } else {
            $dates[] = new \DateTime('tomorrow + '. ($i-2) .'day');
        }
        $i++;
    }
    return $dates;
}

/**
 * Prend en paramètre un tableau d'objets DateTime, et retourne
 * un tableau de string contenant les URL de betclic
 * correspondant aux Dates passées en paramètre
 * @param array $dates
 * @return array
 */
function get_urls_from_dates(array $dates){
    $urls = [];
    $url_part_1 = "https://www.betclic.fr/calendrier-0?";
    $url_part_3 = "&SortBy=Date&Live=false&MultipleBoost=false&CashOut=false&Streaming=false&StartIndex=0&Search=";

    //$url_part_2 = "From= 27 %2F 10 %2F 2017 &SyncFrom= 10 %2F 27 %2F 2017";
    $url_part_2_1 = "From=";
    $url_part_2_3 = "&SyncFrom=";

    foreach ($dates as $date){
        $url_part_2_2 = urlencode($date->format("d/m/Y"));
        $url_part_2_4 = urlencode($date->format("m/d/Y"));
        $url_part_2 = $url_part_2_1 . $url_part_2_2 . $url_part_2_3 . $url_part_2_4;
        $url = $url_part_1 . $url_part_2 . $url_part_3;
        $urls[] = $url;
    }
    return $urls;
}

/**
 * Prend en paramètre une URL, et retourne le contenu
 * HTML de la page
 * @param $url
 * @return mixed
 */
function get_html_content($url) {
    $curl_handle=curl_init();
    curl_setopt($curl_handle, CURLOPT_URL,$url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
    $html = curl_exec($curl_handle);
    curl_close($curl_handle);
    return $html;
}


