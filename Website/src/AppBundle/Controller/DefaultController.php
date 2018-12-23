<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Sport;
use AppBundle\Entity\SpMatch;
use AppBundle\Entity\Equipe;
use AppBundle\Entity\Cote;

class DefaultController extends Controller {


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request) {

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $coteRepository = $doctrine->getRepository(Cote::class);

        //$cotes = $coteRepository->findAll();
        $cotes = $coteRepository->findAllRecentCote();
        $sports_without_cote_nul = ['Snooker', 'Basket-ball', 'Volley-ball', 'Football américain', 'Badminton', 'Tennis', 'Tennis de Table', 'Ski de fond', 'Ski Alpin', 'Formule 1', 'Billard Américain', 'Biathlon'];


        return $this->render('AppBundle:Default:index.html.twig', [
            'cotes' => $cotes,
            'sportsNotCoteNul' => $sports_without_cote_nul
        ]);
    }


    /**
     * @param Request $request
     * @param int $matchId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewMatchAction(Request $request, int $matchId){

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $coteRepository = $doctrine->getRepository(Cote::class);
        $cotes = $coteRepository->findBy(['match' => $matchId]);

        $match_date = $cotes[0]->getMatch()->getMatchDate();
        $match_equipe1_nom = $cotes[0]->getMatch()->getEquipe1()->getEquipeNom();
        $match_equipe2_nom = $cotes[0]->getMatch()->getEquipe2()->getEquipeNom();
        $match_sport = $cotes[0]->getMatch()->getSport()->getSportNom();

        $nb_cotes = count($cotes)-1;

        $cote_var_equipe1 = $cotes[$nb_cotes]->getCoteVarEquipe1();
        $cote_var_equipe2 = $cotes[$nb_cotes]->getCoteVarEquipe2();
        $cote_var_nul = $cotes[$nb_cotes]->getCoteVarNul();

        $sports_without_cote_nul = ['Snooker', 'Basket-ball', 'Volley-ball', 'Football américain', 'Badminton', 'Tennis', 'Tennis de Table', 'Ski de fond', 'Ski Alpin', 'Formule 1', 'Billard Américain', 'Biathlon'];


        return $this->render('AppBundle:Default:match.html.twig', [
            'cotes' => $cotes,
            'matchDate' => $match_date,
            'matchEquipe1Nom' => $match_equipe1_nom,
            'matchEquipe2Nom' => $match_equipe2_nom,
            'matchSport' => $match_sport,
            'matchId' => $matchId,
            'coteVarEquipe1' => $cote_var_equipe1,
            'coteVarEquipe2' => $cote_var_equipe2,
            'coteVarNul' => $cote_var_nul,
            'sportsNotCoteNul' => $sports_without_cote_nul
        ]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewSportAction(Request $request){

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $sportRepository = $doctrine->getRepository(Sport::class);
        $sports = $sportRepository->findAll();
        return $this->render('AppBundle:Default:sports.html.twig', [
            'sports' => $sports
        ]);

    }

    /**

     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewEquipeAction(Request $request){

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $equipeRepository = $doctrine->getRepository(Equipe::class);
        $equipes = $equipeRepository->findAll();
        return $this->render('AppBundle:Default:equipes.html.twig', [
            'equipes' => $equipes
        ]);

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mailAction(Request $request){

        $message = new \Swift_Message();
        $message->setSubject('Test SwiftMailer')
                ->setFrom('guillaumehanotel@orange.fr')
                ->setTo('guiguihanotel@orange.fr')
                ->setBody('Hello World Swift Mailer', 'text/html');

        $message->getHeaders()->addIdHeader('Message-ID', "b3eb7202-d2f1-11e4-b9d6-1681e6b88ec1@domain.com");
        $message->getHeaders()->addTextHeader('MIME-Version', '1.0');
        $message->getHeaders()->addTextHeader('X-Mailer', 'PHP v' . phpversion());
        $message->getHeaders()->addParameterizedHeader('Content-type', 'text/html', ['charset' => 'utf-8']);



        $this->get('mailer')->send($message);

        return $this->render('AppBundle:Default:mail.html.twig', [
            'message' => $message
        ]);
    }





}
