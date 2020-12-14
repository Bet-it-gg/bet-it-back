<?php

namespace App\Controller;

use App\Entity\Area;
use App\Entity\Competition;
use App\Entity\CompetitionDetails;
use App\Entity\Meeting;
use App\Entity\Player;
use App\Entity\Round;
use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        //set_time_limit(-1);

        $em = $this->getDoctrine()->getManager();

        $req = [
            "http" => [
                "method" => "GET",
                "header" => "Ocp-Apim-Subscription-Key: edb599ba46e3455f8139cee8cb4434f2\r\n"
            ]
        ];

        $meetings = $em->getRepository(Meeting::class)->findAll();

        foreach ($meetings as $meeting){

            $context = stream_context_create($req);
            $json = file_get_contents('https://api.sportsdata.io/v3/lol/stats/json/BoxScore/100004150', false, $context);
            //$meeting->getIdMeeting();

            $data = json_decode($json,true);


            foreach ($data["Matches"] as $match){

                $newGame = new Game;
                $newGame->setMeeting($meeting);
                $newGame->setGameNumber($match["Number"]);
                $newGame->setWinner($em->getRepository(Team::class)->findOneBy(["teamId" => $match["WinningTeamId"]]));
                $newGame->setTeamOne($em->getRepository(Team::class)->findOneBy(["teamId" => $match["TeamAId"]]));
                $newGame->setTeamTwo($em->getRepository(Team::class)->findOneBy(["teamId" => $match["TeamBId"]]));

                //Statisctic
                //Todo "PlayerMatches"
                //Todo "TeamMatches"



            }



//            $req = [
//                "http" => [
//                    "method" => "GET",
//                    "header" => "Ocp-Apim-Subscription-Key: edb599ba46e3455f8139cee8cb4434f2\r\n"
//                ]
//            ];
//
//            $competitionsDetails = $em->getRepository(CompetitionDetails::class)->findAll();
//
//            foreach ($competitionsDetails as $competitionsDetail){
//
//                $context = stream_context_create($req);
//                $json = file_get_contents('https://api.sportsdata.io/v3/lol/scores/json/CompetitionDetails/'.$competitionsDetail->getCompetitionDetailsId(), false, $context);
//                $data = json_decode($json,true);
            //$dateOfGame


//            foreach ($data["Teams"] as $team){
//
//
//                $teamObject = $em->getRepository(Team::class)->findOneBy(["teamId" => $team["TeamId"]]);
//                foreach ($team["Players"] as $player) {
////                    $existPlayer = find by idPlayer
////
////                    if($existPlayer) {
//
//                    $newPlayer = new Player();
//                    $newPlayer->setPlayerId($player["PlayerId"]);
//                    $newPlayer->setPlayerName($player["MatchName"]);
//                    $newPlayer->setRole($player["Position"]);
//
//                    $teamObject->addPlayer($newPlayer);
//                    $em->persist($newPlayer);
//                    $em->persist($teamObject);
//
//                //}
//                }
//
//                dd($teamObject);

                $em->flush();
            }



        dd("ok");

    }
}
