<?php


/**
 * Fonction prenant en paramètre un nombre de jour,
 * Retourne une liste d'objets DateTime concernant les dates
 * des X prochains jours
 * @param $nb_day
 * @return array $dates
 */
function get_odds_for_the_next_days($nb_day) {
    $dates = [];

    $i = 1;
    while ($i <= $nb_day) {
        if ($i == 1) {
            $dates[] = new \DateTime('now');
        } elseif ($i == 2) {
            $dates[] = new \DateTime('tomorrow');
        } else {
            $dates[] = new \DateTime('tomorrow + ' . ($i - 2) . 'day');
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
function get_urls_from_dates(array $dates) {
    $urls = [];
    $url_part_1 = "https://www.betclic.fr/calendrier-0?";
    $url_part_3 = "&SortBy=Date&Live=false&MultipleBoost=false&CashOut=false&Streaming=false&StartIndex=0&Search=";

    //$url_part_2 = "From= 27 %2F 10 %2F 2017 &SyncFrom= 10 %2F 27 %2F 2017";
    $url_part_2_1 = "From=";
    $url_part_2_3 = "&SyncFrom=";

    foreach ($dates as $date) {
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
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
    $html = curl_exec($curl_handle);
    curl_close($curl_handle);
    return $html;
}

/**
 * Prend en paramètre un mois en string
 * Retourne le nb de ce mois
 * @param $mois_str
 * @return int
 */
function getMoisNum($mois_str) {
    switch ($mois_str) {
        case "Janvier" :
            return 1;
        case "Février" :
            return 2;
        case "Mars" :
            return 3;
        case "Avril" :
            return 4;
        case "Mai" :
            return 5;
        case "Juin" :
            return 6;
        case "Juiller" :
            return 7;
        case "Août" :
            return 8;
        case "Septembre" :
            return 9;
        case "Octobre" :
            return 10;
        case "Novembre" :
            return 11;
        case "Décembre" :
            return 12;
    }
}

/**
 * Prend en paramètre une date en string
 * Retourne cette date sous forme de tableau
 * @param $date_txt
 * @return array
 */
function getDateArray($date_txt) {
    $explode_date = explode(" ", $date_txt);
    $jour = $explode_date[1];
    $mois_str = $explode_date[2];
    $mois = getMoisNum($mois_str);
    $annee = $explode_date[3];
    $array_date = [
        'jour' => $jour,
        'mois' => $mois,
        'annee' => $annee
    ];
    return $array_date;
}

/**
 * Retourne une chaine de caractère avec la date du jour sous la forme : 18_09_2017_15_14_46
 * @return string
 */
function getDateToday() {
    $today = getdate();
    return $today['year'] . '-' . $today['mon'] . '-' . $today['mday'] . ' ' . $today['hours'] . ':' . $today['minutes'] . ':' . $today['seconds'];
}

/**************************************************************************/

function printErrorInfo(PDO $bdd, $requete, $bdd_error) {
    echo "<br><strong style='text-align: center'>PDO::errorInfo():</strong>";
    echo "<table border='1' style='border:1px solid; margin-left: auto ; margin-right : auto ; width: 60%'>"
    , "<thead>"
    , "<tr>"
    , "<th>SQL STATE</th>"
    , "<th>DRIVER ERROR CODE</th>"
    , "<th>MESSAGE</th>"
    , "<th>REQUETE</th>"
    , "</tr>"
    , "</thead>"
    , "<tbody>"
    , "<tr>";
    $erreurs = $bdd_error ? $bdd->errorInfo() : $requete->errorInfo();
    foreach ($erreurs as $key => $element) {
        $str = "";
        switch ($key) {
            case 0 :
                $str .= $element;
                break;
            case 1 :
                $str .= $element;
                break;
            case 2 :
                $str .= $element;
                break;
            default :
                $str .= "Undefined";
                break;
        }
        echo "<td><a target='_blank' href='http://www.google.com/search?q=" . urlencode($str) . "'>$str</a></td>";
    }
    echo "<td>" . $erreurs = $bdd_error ? $requete : $requete->queryString . "</td>";
    echo "</tr>"
    , "</tbody>"
    , "</table>";
}

/**
 * Prend en paramètre une requete préparée et ses paramètre
 * Execute cette requete et retourne ses résultats
 * @param PDO $bdd
 * @param PDOStatement $requete
 * @param array $param
 * @return array
 */
function getResultatsRequete(PDO $bdd, PDOStatement $requete, array $param) {
    $reponse_requete = $requete->execute($param);
    if ($reponse_requete) {
        $resultat_requete = [];
        while ($row = $requete->fetch()) {
            $resultat_requete[] = $row;
        }
        return $resultat_requete;
    } else {
        printErrorInfo($bdd, $requete, true);
        return array();
    }
}

/**
 * INSERT / UPDATE / DELETE
 * @param PDO $bdd
 * @param PDOStatement $requete
 * @param $param
 */
function executeRequest(PDO $bdd, PDOStatement $requete, $param) {
    $reponse_requete = $requete->execute($param);
    if (!$reponse_requete) {
        printErrorInfo($bdd, $requete, false);
    }
}


/**
 * Requete sur le nom du sport passé en paramètre
 * @param PDO $bdd
 * @param $sport_name
 * @return array|mixed|null
 */
function getSportByName(PDO $bdd, $sport_name) {
    $requete = $bdd->prepare("SELECT * 
                FROM sport 
                WHERE sport_nom = :sport_name");
    $param = [
        'sport_name' => $sport_name
    ];
    $sport = getResultatsRequete($bdd, $requete, $param);
    return !empty($sport) ? $sport : null;
}

/**
 * Insert un sport en BDD si il n'existe pas déjà
 * Retourne l'ID du sport
 * @param PDO $bdd
 * @param $sport_name
 * @return string
 */
function insertSport(PDO $bdd, $sport_name) {
    $sport = getSportByName($bdd, $sport_name);
    // si aucun sport avec ce nom n'est trouvé, on insert
    if (is_null($sport)) {
        $requete = $bdd->prepare("INSERT INTO sport (sport_nom) VALUES (:sport_name)");
        $param = [
            'sport_name' => $sport_name
        ];
        executeRequest($bdd, $requete, $param);
        $sport_id = $bdd->lastInsertId();
    } else {
        $sport_id = $sport[0]['sport_id'];
    }
    return $sport_id;
}

/**
 * Requete sur le nom de l'équipe passé en paramètre
 * @param PDO $bdd
 * @param $equipe_name
 * @return array|mixed|null
 */
function getEquipeByName(PDO $bdd, $equipe_name) {
    $requete = $bdd->prepare("SELECT * 
                FROM equipe
                WHERE equipe_nom = :equipe_name");
    $param = [
        'equipe_name' => (strpos($equipe_name, 'É')) ? str_replace('É', 'E', $equipe_name) : $equipe_name
    ];
    $equipe = getResultatsRequete($bdd, $requete, $param);
    return !empty($equipe) ? $equipe : null;
}

/**
 * Insert une équipe en BDD si elle n'existe pas déjà
 * Retourne l'ID de l'équipe
 * @param PDO $bdd
 * @param $equipe_name
 * @return string
 */
function insertEquipe(PDO $bdd, string $equipe_name) {
    // si aucune équipe avec ce nom n'est trouvé, on insert
    $equipe = getEquipeByName($bdd, $equipe_name);

    if (is_null($equipe)) {
        $requete = $bdd->prepare("INSERT INTO equipe (equipe_nom) VALUES (:equipe_name)");
        $param = [
            'equipe_name' => $equipe_name
        ];
        executeRequest($bdd, $requete, $param);
        $equipe_id = $bdd->lastInsertId();
    } else {
        $equipe_id = $equipe[0]['equipe_id'];
    }
    return $equipe_id;
}

/**
 * Requete sur l'id du match passé en paramètre
 * @param PDO $bdd
 * @param $match_id
 * @return array|null
 */
function getMatchById(PDO $bdd, $match_id) {
    $requete = $bdd->prepare("SELECT * FROM sp_match WHERE `match_id` = :match_id");
    $param = [
        'match_id' => $match_id
    ];
    $match = getResultatsRequete($bdd, $requete, $param);
    return !empty($match) ? $match : null;
}

/**
 * Insert un match en BDD si il n'exsiste pas déjà
 * @param PDO $bdd
 * @param $match_id
 * @param $match_date
 * @param $sport_id
 * @param $equipe1_id
 * @param $equipe2_id
 */
function insertMatch(PDO $bdd, $match_id, $match_date, $sport_id, $equipe1_id, $equipe2_id) {
    $match = getMatchById($bdd, $match_id);
    if (is_null($match)) {
        $requete = $bdd->prepare("INSERT INTO sp_match (match_id, match_date, sport_id, equipe_1_id, equipe_2_id) 
                                            VALUES (:match_id, :match_date, :sport_id, :equipe_1_id, :equipe_2_id)");
        $param = [
            'match_id' => $match_id,
            'match_date' => $match_date,
            'sport_id' => $sport_id,
            'equipe_1_id' => $equipe1_id,
            'equipe_2_id' => $equipe2_id,
        ];
        executeRequest($bdd, $requete, $param);
    }
}

/**
 * Recupère la cote d'un match en fonction de l'id et de la date du match passée en paramètre
 * @param PDO $bdd
 * @param $match_id
 * @param $date_today
 * @return array|null
 */
function getCoteByMatchIdAndDate(PDO $bdd, $match_id, $date_today) {
    $requete = $bdd->prepare("SELECT * FROM cote WHERE match_id = :match_id AND cote_date = :date_today");
    $param = [
        'match_id' => $match_id,
        'date_today' => $date_today
    ];
    $cote = getResultatsRequete($bdd, $requete, $param);
    return !empty($cote) ? $cote : null;
}


/**
 * Récupère les plus vieilles cotes d'un match donné
 * @param PDO $bdd
 * @param $match_id
 * @return mixed|null
 */
function getOldCotes(PDO $bdd, $match_id) {
    $requete = $bdd->prepare("SELECT cote_equipe1, cote_equipe2, cote_nul 
                                       FROM cote 
                                       WHERE match_id = :match_id 
                                       HAVING MIN(cote_date)");
    $param = [
        'match_id' => $match_id
    ];
    $cotes = getResultatsRequete($bdd, $requete, $param);
    return !empty($cotes[0]) ? $cotes[0] : null;
}

/**
 * Calcul de la variation entre l'ancienne cote et la nouvelle
 * @param $old_cote
 * @param $cote
 * @return float|int
 */
function calculVar($old_cote, $cote) {
    $cote = str_replace(',', '.', $cote);
    $old_cote = str_replace(',', '.', $old_cote);
    $calcul_var = ($old_cote != 0) ? ((($cote - $old_cote) / $old_cote) * 100) : 0;
    return $calcul_var;
}


function insertVarCote(PDO $bdd, $cote_id, $var_cote_equipe1, $var_cote_equipe2, $var_cote_nul) {
    $requete = $bdd->prepare("UPDATE cote SET 
                                    cote_var_equipe1 = :var_cote_equipe1, 
                                    cote_var_equipe2 = :var_cote_equipe2,
                                    cote_var_nul = :var_cote_nul
                                    WHERE cote_id = :cote_id");
    $param = [
        'cote_id' => $cote_id,
        'var_cote_equipe1' => $var_cote_equipe1,
        'var_cote_equipe2' => $var_cote_equipe2,
        'var_cote_nul' => $var_cote_nul
    ];
    executeRequest($bdd, $requete, $param);
}


/**
 * Insert la cote d'un match en BDD si elle n'existe pas déjà
 * @param PDO $bdd
 * @param $match_id
 * @param $match_cote_equipe_1
 * @param $match_cote_equipe_2
 * @param $match_cote_nul
 * @param $date_today
 */
function insertCote(PDO $bdd, $match_id, $match_cote_equipe_1, $match_cote_equipe_2, $match_cote_nul, $date_today) {


    $cote = getCoteByMatchIdAndDate($bdd, $match_id, $date_today);
    $cote_id = $cote[0]['cote_id'];

    if (is_null($cote)) {

        // Récupération des vieilles cotes si elles existent
        $old_cotes = getOldCotes($bdd, $match_id);

        if (!is_null($old_cotes)) {
            // Récupération des 3 cotes
            $old_cote_equipe1 = str_replace(',', '.', $old_cotes['cote_equipe1']);
            $old_cote_equipe2 = str_replace(',', '.', $old_cotes['cote_equipe2']);
            $old_cote_nul = str_replace(',', '.', $old_cotes['cote_nul']);

            // calcul de la variation
            $var_cote_equipe1 = calculVar($old_cote_equipe1, $match_cote_equipe_1);
            $var_cote_equipe2 = calculVar($old_cote_equipe2, $match_cote_equipe_2);
            $var_cote_nul = calculVar($old_cote_nul, $match_cote_nul);
        }

        $requete = $bdd->prepare("INSERT INTO cote (cote_date, cote_equipe1, cote_equipe2, cote_nul, match_id) 
                                                    VALUES (:cote_date, :cote_equipe1, :cote_equipe2, :cote_nul, :match_id)");

        $param = [
            'cote_date' => $date_today,
            'cote_equipe1' => str_replace(',', '.', $match_cote_equipe_1),
            'cote_equipe2' => str_replace(',', '.', $match_cote_equipe_2),
            'cote_nul' => str_replace(',', '.', $match_cote_nul),
            'match_id' => $match_id
        ];
        executeRequest($bdd, $requete, $param);
        $cote_id = $bdd->lastInsertId();


    }

    // si il existe bien des anciennes cotes, on insert les variations avec l'id de la cote
    // que l'on vient d'insérer
    if (!is_null($old_cotes)) {
        insertVarCote($bdd, $cote_id, $var_cote_equipe1, $var_cote_equipe2, $var_cote_nul);
    }

}


function cleanCotesFromMatch($bdd, $match_id, $date_today){
    $requete = $bdd->prepare("DELETE FROM cote WHERE match_id = :match_id");
    $param = [
        'match_id' => $match_id
    ];
    executeRequest($bdd, $requete, $param);

    $requete = $bdd->prepare("INSERT INTO cote (cote_date, cote_equipe1, cote_equipe2, cote_nul, match_id) 
                                                    VALUES (:cote_date, 0, 0, 0, :match_id)");
    $param = [
        'cote_date' => $date_today,
        'match_id' => $match_id
    ];
    executeRequest($bdd, $requete, $param);
}



