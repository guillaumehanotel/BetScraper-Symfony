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
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $coteRepository = $doctrine->getRepository(Cote::class);

        //$cotes = $coteRepository->findAll();
        $cotes = $coteRepository->findAllRecentCote();

        return $this->render('AppBundle:Default:index.html.twig', [
            'cotes' => $cotes
        ]);
    }


    /**
     * @Route("/sports", name="list_sports")
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
     * @Route("/equipes", name="list_equipes")
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
     * @Route("/matchs", name="list_matchs")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewMatchAction(Request $request){

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $equipeRepository = $doctrine->getRepository(SpMatch::class);
        $matchs = $equipeRepository->findAllFromToday();
        return $this->render('AppBundle:Default:matchs.html.twig', [
            'matchs' => $matchs,
        ]);

    }




}
