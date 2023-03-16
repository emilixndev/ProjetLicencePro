<?php

namespace App\Service;

use App\Entity\Material;
use App\Entity\Reservation;
use Mailjet\Client;
use Mailjet\Resources;
use mysql_xdevapi\Exception;

class Emailservice
{

    private Client $mj;
    public function __construct(
    )
    {
        $this->mj = new Client("173cb1ae4ef643e08331cbec9ba5d6c7","f35291eed007d8a967ba539c1b0ecc00",true, ['version' => 'v3.1']);
    }

    public function sendConfirmationReservation(
        Reservation $reservation,
    )
    {
        $owner = $reservation->getMaterial()->getUser();
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "arthur.gullmann@etu.unistra.fr",
                        'Name' => "LabStock"
                    ],
                    'To' => [
                        [
                            'Email' => 'emilien.muck@gmail.com',
                        ]
                    ],
                    'TemplateID' => 4647061,
                    'TemplateLanguage' => true,
                    'Subject' => "Réservation matériel",
                    'Variables' => [
                        'FirstNameOwner' => $owner->getFirstName(),
                        'lastNameOwner' => $owner->getLastName(),
                        'tel' => $owner->getTel(),
                        'email' => $owner->getEmail(),
                    ],
                ],
            ]
        ];
            $reponse = $this->mj->post(Resources::$Email, ['body' => $body]);
            $reponse->success();
    }


    public function sendNotificationOwner(
        Reservation $reservation,
    ){
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "arthur.gullmann@etu.unistra.fr",
                        'Name' => "LabStock"
                    ],
                    'To' => [
                        [
                            'Email' => "emilien.muck@gmail.com",
                        ]
                    ],
                    'TemplateID' => 4646932,
                    'TemplateLanguage' => true,
                    'Subject' => "Réservation matériel",
                    'Variables' => [
                        'invNumber' => $reservation->getMaterial()->getInventoryNumber(),
                        'dateDebut' => $reservation->getStartDate()->format("Y-m-d"),
                        'dateFin' => $reservation->getEndDate()->format("Y-m-d"),
                        'firstName' => $reservation->getFirstName(),
                        'lastName' => $reservation->getLastName(),
                        'email' => $reservation->getEmailBorrower(),
                    ],
                ],
            ]
        ];
        $reponse = $this->mj->post(Resources::$Email, ['body' => $body]);
        $reponse->success();
    }


    public function sendEndOfGuarantyWarn(
        Material $material,
    ){
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "arthur.gullmann@etu.unistra.fr",
                        'Name' => "LabStock"
                    ],
                    'To' => [
                        [
                            'Email' => "emilien.muck@gmail.com",
                        ]
                    ],
                    'TemplateID' => 4657870,
                    'TemplateLanguage' => true,
                    'Subject' => "Problème de garantie",
                    'Variables' => [
                        'invNumber' => $material->getInventoryNumber(),
                    ],
                ],
            ]
        ];
        $reponse = $this->mj->post(Resources::$Email, ['body' => $body]);
        $reponse->success();
    }


}