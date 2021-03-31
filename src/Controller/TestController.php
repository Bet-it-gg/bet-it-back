<?php

namespace App\Controller;

use App\Entity\Area;
use App\Entity\Competition;
use App\Entity\CompetitionDetails;
use App\Entity\Meeting;
use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Role;
use App\Entity\Round;
use App\Entity\Statistic;
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
        set_time_limit(-1);

        $em = $this->getDoctrine()->getManager();
        /*
           //Todo Opti : bouclé sur le tableau, faire une requete par compétition pour les meetings puis clear $em
                   $arrayKeyByCompetition = [
                       "LMS" => "84812f71130f4026af6339cc5c3e0753",
                       "LEC" => "475660721da1471089201ab76f196fe8",
                       "LJL" => "6c00851f9e3047c9aa939fb7a35ac264",
                       "LCK" => "e0388a081809409391d0fbfa34549210",
                       "NA LCS" => "b61b48c05a9d41cb8deeb5b5bd96a552",
                       "World Championship" => "da152a1cd2bb459ba290997a5bdd2b48",
                       "Mid-Season Invitational" => "233320e0171a40c88f0ca859c6aa0444",
                       "Rift Rivals" => "a96b49f385ed4d1ab79f090dee897ff6",
                       "CBLOL" => "de5cf1a1c5e744d7b39747640848632a",
                       "OPL" => "d11eb5f7a7ef4eb0b82d67e3f9c6c818",
                       "TCL" => "f32a7c38e3c64642986103c8b158f309",
                       "LPL" => "4184dd174a2d45af9688bdf48a7d1526",
                       "European Masters" => "84812f71130f4026af6339cc5c3e0753",
                   ];

                   $competitions = $em->getRepository(Competition::class)->findAll();

                   foreach ($competitions as  $competition){

                       $meetings = $competition->getMeetings();

                       foreach ($meetings as $meeting) {


                           //Todo faire des paquets pour flush
                           $req = [
                               "http" => [
                                   "method" => "GET",
                                   "header" => "Ocp-Apim-Subscription-Key: " . $arrayKeyByCompetition[$competition->getName()] . "\r\n"
                               ]
                           ];


                           $context = stream_context_create($req);
                           $json = file_get_contents('https://api.sportsdata.io/v3/lol/stats/json/BoxScore/' . $meeting->getIdMeeting(), false, $context);
                           $data = json_decode($json, true);


                           if (!empty($data[0]["Matches"])) {
                               foreach ($data[0]["Matches"] as $match) {
                                   $newGame = new Game;


                                   $teamA = $em->getRepository(Team::class)->findOneBy(["teamId" => $data[0]["Game"]["TeamAId"]]);
                                   $teamB = $em->getRepository(Team::class)->findOneBy(["teamId" => $data[0]["Game"]["TeamBId"]]);
                                   $newGame->setTeamOne($teamA);
                                   $newGame->setTeamTwo($teamB);

                                   $newGame->setMeeting($meeting);
                                   $newGame->setGameNumber($match["Number"]);

           //                        dd($match["WinningTeamId"], $teamA, $teamB );
                                   $newGame->setWinner($em->getRepository(Team::class)->findOneBy(["teamId" => $match["WinningTeamId"]]));
                                   //$newGame->setWinner($em->getRepository(Team::class)->findOneBy(["teamId" => $match["WinningTeamId"]]));

                                   $em->persist($newGame);

                                   //Statisctic
                                   //Todo "PlayerMatches" make player Table script befor

                                   //Todo "TeamMatches"
                                   foreach ($match["TeamMatches"] as $teamMatch) {
                                       $newGameStatistic = new Statistic;
                                       $newGameStatistic->setGame($newGame);
                                       $newGameStatistic->setTeam($em->getRepository(Team::class)->findOneBy(["teamId" => $teamMatch["TeamId"]]));
                                       $newGameStatistic->setKills($teamMatch["Kills"]);
                                       $newGameStatistic->setAssists($teamMatch["Assists"]);
                                       $newGameStatistic->setDeaths($teamMatch["Deaths"]);
                                       $newGameStatistic->setFirstBlood($teamMatch["FirstBlood"]);
                                       $newGameStatistic->setFirstTower($teamMatch["FirstTower"]);
                                       $newGameStatistic->setFirstInhibitor($teamMatch["FirstInhibitor"]);
                                       $newGameStatistic->setFirstBaron($teamMatch["FirstBaron"]);
                                       $newGameStatistic->setFirstDragon($teamMatch["FirstDragon"]);
                                       $newGameStatistic->setFirstRiftHerald($teamMatch["FirstRiftHerald"]);
                                       $newGameStatistic->setPentaKills($teamMatch["PentaKills"]);
                                       $newGameStatistic->setWardsPlaced($teamMatch["WardsPlaced"] ? $teamMatch["WardsPlaced"] : 0);
                                       $newGameStatistic->setWardsKilled($teamMatch["WardsKilled"]);
                                       $newGameStatistic->setTotalDamageDealtToChampions($teamMatch["TotalDamageDealtToChampions"]);
                                       $newGameStatistic->setFantasyPoints($teamMatch["FantasyPoints"]);

                                       $em->persist($newGameStatistic);
                                       $newGame->addStatistic($newGameStatistic);
                                   }
                                   $em->persist($newGame);
           //                        dd($newGame);
                                   $em->flush();
                                   //$em->clear();
           //

                               }
                           }
           //               else {
           //                    dd("ok");
           //                    $newGame = new Game;
           //                    dd($match);
           //
           //                    $teamA = $em->getRepository(Team::class)->findOneBy(["teamId" => $data[0]["Game"]["TeamAId"]]);
           //                    $teamB = $em->getRepository(Team::class)->findOneBy(["teamId" => $data[0]["Game"]["TeamBId"]]);
           //                    $newGame->setTeamOne($teamA);
           //                    $newGame->setTeamTwo($teamB);
           //
           //                    $newGame->setMeeting($meeting);
           //
           //                    $em->persist($newGame);
           //                }
                       }
                       $em->clear();
                   }
               }

           */

//---------------------------------------------------------------------------------------------------Players DATA apres table Game
//        $req = [
//            "http" => [
//                "method" => "GET",
//                "header" => "Ocp-Apim-Subscription-Key: 2c3cc58e059e4e20a53ddcac1df0a300\r\n"
//            ]
//        ];
//
//
//        $context = stream_context_create($req);
//        $json = file_get_contents('https://api.sportsdata.io/v3/lol/scores/json/ActiveMemberships', false, $context);
//        $dataActiveMemberShip = json_decode($json, true);
//
//        $reqPlayer = [
//            "http" => [
//                "method" => "GET",
//                "header" => "Ocp-Apim-Subscription-Key: 2c3cc58e059e4e20a53ddcac1df0a300\r\n"
//            ]
//        ];
//        $contextPlayers = stream_context_create($reqPlayer);
//        $jsonPlayers = file_get_contents('https://api.sportsdata.io/v3/lol/scores/json/Players', false, $contextPlayers);
//        $dataPlayers = json_decode($jsonPlayers, true);
//
//        //dd($data);
//
//        foreach ($dataActiveMemberShip as $player) {
//
//            $teamObject = $em->getRepository(Team::class)->findOneBy(["teamId" => $player["TeamId"]]);
//
//            $newPlayer = new Player();
//            $newPlayer->setPlayerId($player["PlayerId"]);
//            $newPlayer->setTeam($teamObject);
//
//            $arrPlayer = array_search($player["PlayerId"], $dataPlayers);
//
//            dd($dataPlayers, $arrPlayer);
//            $newPlayer->setPlayerName($dataPlayers["MatchName"]);
//            $newPlayer->setRole($dataPlayers["Position"]);
//
//
//            $em->persist($newPlayer);
//            $em->persist($teamObject);
//
//            $newPlayer->setPlayerName($dataPlayers["MatchName"]);
//
//                $newPlayer->setRole($dataPlayer["Position"] ? strval($dataPlayer["Position"]) : null);
//                $teamObject->addPlayer($newPlayer);
//                $em->persist($newPlayer);
//                $em->persist($teamObject);
//
//
//                $em->flush();
//
//        }
//        dd("ok");



        dd("ok");
    }
}
