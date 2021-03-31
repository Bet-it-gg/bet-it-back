<?php

namespace App\DataFixtures;

use App\Entity\Area;
use App\Entity\Competition;
use App\Entity\CompetitionDetails;
use App\Entity\Meeting;
use App\Entity\Player;
use App\Entity\Role;
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
                "header" => "Ocp-Apim-Subscription-Key: d4fb09535ff74d4bae5bf536e7ab2363\r\n"
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
        $em->clear();

        // -----------------------------Competition & Competition Details & Rounds ------------------------------------------------------

        $req = [
            "http" => [
                "method" => "GET",
                "header" => "Ocp-Apim-Subscription-Key: d4fb09535ff74d4bae5bf536e7ab2363\r\n"
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
            $em->clear();
        }


        // -----------------------------Team------------------------------------------------------
        $req = [
            "http" => [
                "method" => "GET",
            ]
        ];

        $context = stream_context_create($req);
        $json = file_get_contents('https://lol.gamepedia.com/Special:CargoExport?tables=Teams&&fields=Name+%2C+OverviewPage+%2C+Short+%2C+Location+%2C+TeamLocation+%2C+Region+%2C+Image+%2C+Teams.IsDisbanded%2C+Teams.IsLowercase%2C+Teams.RenamedTo%2C&where=Teams.IsDisbanded+%3D+0&order+by=%60Name%60%2C%60OverviewPage%60%2C%60Short%60%2C%60Location%60%2C%60TeamLocation%60&limit=10000000000000000000000000000000000000000000&format=json');
        $data = json_decode($json, true);

        foreach ($data as $team){
            $newTeam = new Team();
            $newTeam->setName($team["Name"]);
            //$newTeam->setTeamId($team["TeamId"]);
            $teamNameReplaced = str_replace(" ", "_", $team["Name"]);
            $newTeam->setImgUrl($team["Name"] ? "https://lol.gamepedia.com/File:" . $teamNameReplaced . "logo_square.png" : "");
            // $newTeam->setArea($em->getRepository(Area::class)->findOneBy(["areaId" => $team["AreaId"]]));
            $newTeam->setShortName($team["Short"]);
            $newTeam->setIsActive(1);

            $em->persist($newTeam);
        }

        $em->flush();
        $em->clear();

        // -----------------------------Players And Roles------------------------------------------------------
        //get all roles from lol
        $req = [
            "http" => [
                "method" => "GET",
            ]
        ];
        $context = stream_context_create($req);
        $json = file_get_contents('https://lol.fandom.com/Special:CargoExport?tables=Players&&fields=count%28id%29%2C+Players.Role%2C&where=IsRetired+%3D+0&group+by=Players.Role&order+by=count%28id%29%2C%60cargo__Players%60.%60Role%60&limit=100&format=json');
        $roles = json_decode($json, true);

        foreach ($roles as $role){
            $req = [
                "http" => [
                    "method" => "GET",
                ]
            ];
            $context = stream_context_create($req);
            $json = file_get_contents('https://lol.gamepedia.com/Special:CargoExport?tables=Players&&fields=Players.ID%2C+Players.Role%2C+Players.Team&where=IsRetired+%3D+0+and+Role+%3D+%22'. $role["Role"] .'%22&order+by=%60cargo__Players%60.%60ID%60%2C%60cargo__Players%60.%60Role%60%2C%60cargo__Players%60.%60Team%60&limit=5000&format=json');
            $playersByRole = json_decode($json, true);

            $newRole = new Role();
            $newRole->setTitle($role["Role"]);
            $em->persist($newRole);

            //get players by role
            foreach ($playersByRole as $player){

                $newPlayer = new Player();
                $newPlayer->setPlayerId($player["ID"]);
                $newPlayer->addRole($newRole);
                $newPlayer->setTeam($player["Team"]?$em->getRepository(Team::class)->findOneBy(["name" => $player["Team"]]): null);

                $em->persist($newPlayer);
            }
            $em->flush();
            $em->clear();
        }
        // -----------------------------Meeting------------------------------------------------------

        set_time_limit(-1);

        //$em = $this->getDoctrine()->getManager();

        $req = [
            "http" => [
                "method" => "GET",
                "header" => "Ocp-Apim-Subscription-Key: d4fb09535ff74d4bae5bf536e7ab2363\r\n"
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
                $newMeeting->setCompetition($competition );
                $newMeeting->setRounds($em->getRepository(Round::class)->findOneBy(["RoundId" => $games["RoundId"]]));

                $em->persist($newMeeting);

            }

            $em->flush();
            $em->clear();
        }

    }
}
