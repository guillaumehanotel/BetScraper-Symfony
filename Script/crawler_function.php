<?php

require_once __DIR__ . '/config.php';


/**
 * Prend en paramètre le crawler de tout le contenu
 * Retourne le crawler du contenu du jour de la page
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @return \Symfony\Component\DomCrawler\Crawler
 */
function getFirstDayContent(\Symfony\Component\DomCrawler\Crawler $crawler){
    $cssFirstDayContent = $GLOBALS['config']['cssMatch_Non_En_Cours'].' '.$GLOBALS['config']['cssCalendrier_1_Jour'];
    return $crawler->filter($cssFirstDayContent)->first();
}

/**
 * Prend en paramètre le crawler du contenu du jour
 * Retourne la date
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @return string
 */
function getDateFromDayCrawler(\Symfony\Component\DomCrawler\Crawler $crawler){
    $cssSelectorDate = '.cal-day > span';
    return $crawler->filter($cssSelectorDate)->text();
}

/**
 * Prend en paramètre le crawler du jour et une closure retournant le html
 * de chaque élément
 * Retourne un tableau de string contenant le html de chaque horaire
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @param $nodeHtml
 * @return array
 */
function getHorairesContent(\Symfony\Component\DomCrawler\Crawler $crawler, $nodeHtml){
    $cssHoraire = $GLOBALS['config']['cssCalendrier_1_Heure'];
    return $crawler->filter($cssHoraire)->each($nodeHtml);
}

/**
 * Prend en paramètre le crawler d'un horaire
 * Retourne l'horaire de l'élément
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @return string
 */
function getHourFromHoraireCrawler(\Symfony\Component\DomCrawler\Crawler $crawler){
    $cssSelectorHour = '.cal-hour';
    return $crawler->filter($cssSelectorHour)->text();
}

/**
 * Prend en paramètre le crawler d'un horaire et une closure retournant le html
 * de chaque élément
 * Retourne un tableau de string contenant le html de chaque event
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @param $nodeHtml
 * @return array
 */
function getEventsContent(\Symfony\Component\DomCrawler\Crawler $crawler, $nodeHtml){
    $cssEvent = $GLOBALS['config']['cssCalendrier_1_Event'];
    return $crawler->filter($cssEvent)->each($nodeHtml);
}


/**
 * Prend en paramètre le crawler d'un event
 * Retourne les infos d'un event -> sport + nom de l'evenement
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @return string
 */
function getEventInfoFromEventCrawler(\Symfony\Component\DomCrawler\Crawler $crawler){
    $cssSelectorSport = 'p.event-name a';
    return $crawler->filter($cssSelectorSport)->text();
}

/**
 * Prend en paramètre le crawler d'un event et une closure retournant le html
 * de chaque élément
 * Retourne un tableau de string contenant le html de chaque match
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @param $nodeHtml
 * @return array
 */
function getMatchsContent(\Symfony\Component\DomCrawler\Crawler $crawler, $nodeHtml){
    $cssMatch = $GLOBALS['config']['css1Match'];
    return $crawler->filter($cssMatch)->each($nodeHtml);
}

/**
 * Prend en paramètre le crawler d'un match
 * Retourne les equipes du match
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @return string
 */
function getEquipesFromMatchCrawler(\Symfony\Component\DomCrawler\Crawler $crawler){
    $cssSelectorEquipes = 'div.match-name a';
    return $crawler->filter($cssSelectorEquipes)->text();
}

/**
 * Prend en paramètre le crawler d'un match et une closure retournant le html de chaque html de chaque élément
 * Retourne un tableau de string contenant le html des cotes du match
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @param $nodeHtml
 * @return array
 */
function getCotesFromMatchCrawler(\Symfony\Component\DomCrawler\Crawler $crawler, $nodeHtml){
    $cssSelectorCotes = '.match-odds .match-odd span';
    return $crawler->filter($cssSelectorCotes)->each($nodeHtml);
}

/**
 * Prend en paramètre le crawler d'un event
 * Retourne un tableau de string contenant l'id de tous des matchs de cet event
 * @param \Symfony\Component\DomCrawler\Crawler $crawler
 * @param $nodeId
 * @return array
 */
function getIdFromEventCrawler(\Symfony\Component\DomCrawler\Crawler $crawler, $nodeId){
    $cssMatch = $GLOBALS['config']['css1Match'];
    return $crawler->filter($cssMatch)->each($nodeId);
}

