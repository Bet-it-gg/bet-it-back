<?php

namespace App\DataFixtures;

use App\Entity\Area;
use App\Entity\Competition;
use App\Entity\CompetitionDetails;
use App\Entity\Meeting;
use App\Entity\Round;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    // COMMAND: php bin/console doctrine:fixtures:load

    public function load(ObjectManager $em)
    {
        // -----------------------------Area------------------------------------------------------
        $req = [
            "http" => [
                "method" => "GET",
                "header" => "Ocp-Apim-Subscription-Key: edb599ba46e3455f8139cee8cb4434f2\r\n"
            ]
        ];

        // Recupération du contenu de la requête
        $context = stream_context_create($req);
        $json = file_get_contents('https://api.sportsdata.io/v3/lol/scores/json/Areas', false, $context);
        $data = json_decode($json,true);

        foreach ($data as $area){
            $newArea = new Area();
            $newArea->setName($area["Name"]);
            $newArea->setCode($area["CountryCode"]);
            $newArea->setAreaId($area["AreaId"]);
            $em->persist($newArea);
        }

        $em->flush();

        // -----------------------------Competition & Competition Details & Rounds ------------------------------------------------------

        $req = [
            "http" => [
                "method" => "GET",
                "header" => "Ocp-Apim-Subscription-Key: edb599ba46e3455f8139cee8cb4434f2\r\n"
            ]
        ];

        $context = stream_context_create($req);
        $json = file_get_contents('https://api.sportsdata.io/v3/lol/scores/json/Competitions', false, $context);
        $data = json_decode($json,true);

        foreach ($data as $competition){
            $newCompetition = new Competition();
            $newCompetition->setName($competition["Name"]);
            $newCompetition->setCompetitionId($competition["CompetitionId"]);
            $newCompetition->setFormat($competition["Format"]);
            $newCompetition->setArea($em->getRepository(Area::class)->findOneBy(["areaId" => $competition["AreaId"]]));

            $em->persist($newCompetition);

            foreach ($competition["Seasons"] as $competitionDetails){
                $newCompetitionDetails = new CompetitionDetails();
                $newCompetitionDetails->setName($competitionDetails["Name"]);
                $newCompetitionDetails->setCompetitionDetailsId($competitionDetails["SeasonId"]);
                $newCompetitionDetails->setStartDate(new \DateTime($competitionDetails["StartDate"]));
                $newCompetitionDetails->setEndDate(new \DateTime($competitionDetails["EndDate"]));

                $newCompetition->addCompetitionsDetail($newCompetitionDetails);
                $em->persist($newCompetitionDetails);
                $em->persist($newCompetition);

                foreach ($competitionDetails["Rounds"] as $round){
                    $newRound = new Round();
                    $newRound->setName($round["Name"]);
                    $newRound->setType($round["Type"]);
                    $newRound->setStartDate(new \DateTime($round["StartDate"]));
                    $newRound->setEndDate(new \DateTime($round["EndDate"]));
                    $newRound->setRoundId($round["RoundId"]);

                    $newCompetitionDetails->addRound($newRound);

                    $em->persist($newRound);
                    $em->persist($newCompetitionDetails);
                }
            }
            $em->flush();
        }


        // -----------------------------Team------------------------------------------------------
        $req = [
            "http" => [
                "method" => "GET",
                "header" => "Ocp-Apim-Subscription-Key: edb599ba46e3455f8139cee8cb4434f2\r\n"
            ]
        ];

        $context = stream_context_create($req);
        $json = file_get_contents('https://api.sportsdata.io/v3/lol/scores/json/teams', false, $context);
        $data = json_decode($json,true);

//        $em = $this->getDoctrine()->getManager();

        foreach ($data as $team){
            $newTeam = new Team();
            $newTeam->setName($team["Name"]);
            $newTeam->setTeamId($team["TeamId"]);
            $newTeam->setArea($em->getRepository(Area::class)->findOneBy(["areaId" => $team["AreaId"]]));
            $newTeam->setWebsite($team["Website"] ? $team["Website"] : '' );
            $newTeam->setShortName($team["Key"]);
            $newTeam->setIsActive($team["Active"]);

            $em->persist($newTeam);
        }

        $em->flush();



        // -----------------------------Meeting------------------------------------------------------

        set_time_limit(200000000000000);

        $em = $this->getDoctrine()->getManager();

        $req = [
            "http" => [
                "method" => "GET",
                "header" => "Ocp-Apim-Subscription-Key: edb599ba46e3455f8139cee8cb4434f2\r\n"
            ]
        ];

        $competitions = $em->getRepository(Competition::class)->findAll();

        foreach ($competitions as $competition){

            $context = stream_context_create($req);
            $json = file_get_contents('https://api.sportsdata.io/v3/lol/scores/json/CompetitionDetails/'.$competition->getCompetitionId(), false, $context);
            $data = json_decode($json,true);


            foreach ($data["Games"] as $games){

                $newMeeting = new Meeting();
                $newMeeting->setIdMeeting($games["GameId"]);
                $newMeeting->setType($games["BestOf"]);
                $newMeeting->setWeek($games["Week"] ? $games["Week"] : '' );
                $newMeeting->setMeetingDate(new \DateTime($games["Day"]));
                $newMeeting->setGroupName($games["Group"] ? $games["Group"] : '' );
                $newMeeting->setRounds($em->getRepository(Round::class)->findOneBy(["RoundId" => $games["RoundId"]]));

                $em->persist($newMeeting);

            }

            $em->flush();
        }

    }
}
