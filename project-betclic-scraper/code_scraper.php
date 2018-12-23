<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\DomCrawler\Crawler;


class DefaultController extends Controller {


    private function get_html_content($url) {
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $html = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $html;
    }


    private function get_odds_for_the_next_days($nb_day){
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


    private function get_urls_from_dates(array $dates){
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
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {


        $dates = $this->get_odds_for_the_next_days(3);

        $url = 'https://www.betclic.fr/calendrier-0';
        $url2 = 'http://quotes.toscrape.com/';
        $url3 = 'https://www.betclic.fr/calendrier-0?From=17%2F10%2F2017&SyncFrom=10%2F17%2F2017&SortBy=Date&Live=false&MultipleBoost=false&CashOut=false&Streaming=false&StartIndex=0&Search=';


        $urls = $this->get_urls_from_dates($dates);


        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $html = curl_exec($curl_handle);
        curl_close($curl_handle);



        //$html = substr($html, 1820);
        //$html = substr($html, 61189);
        $html = substr($html, 72461);
        $crawler = new Crawler($html);
        $cssSelector = '#cal-wrapper-prelive .cal-day-entry .cal-day > span';


        $maFonction = function ($node) {
            return $node->text();
        };

        $elements = 3;
        $elements = $crawler->filter($cssSelector)->each($maFonction);

        return $this->render('default/index.html.twig', [
            'html' => $html,
            'dates' => $dates,
            'elements' => $elements,
            'urls' => $urls
        ]);

    }



}
