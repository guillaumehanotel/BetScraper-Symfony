<?php

namespace AppBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;


class CoteExtension extends \Twig_Extension {

    protected $container;


    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }


    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('calculVar', array($this, 'calculVar')),
            new \Twig_SimpleFunction('formatCote', array($this, 'formatCote')),
        ];
    }

    public function calculVar($cote, $previous_cote){
        return ($cote != 0) ? ((($previous_cote - $cote) / $cote ) *100) : 0;
    }


    public function formatCote($cote){
        if($cote == 0){
            $cote = "-";
        } else {
            if($cote > 0){
                $cote = number_format($cote, 2, ',', '')."%";
                $cote = '+'.$cote;
            } else {
                $cote = number_format($cote, 2, ',', '')."%";
            }
        }
        return $cote;
    }

}