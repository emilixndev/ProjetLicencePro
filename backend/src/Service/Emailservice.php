<?php

namespace App\Service;

use App\Entity\Material;
use App\Entity\Reservation;
use Mailjet\Client;
use Mailjet\Resources;

class Emailservice
{

    private Client $mj;
    public function __construct(
    )
    {
        $this->mj = new Client($_ENV['MAILJET_KEY'],$_ENV['MAILJET_SECRET'],true, ['version' => 'v3.1']);
    }

    public function sendConfirmationReservation(
        Reservation $reservation,
    )
    {

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "emilien.muckensturm@etu.unistra.fr",
                        'Name' => "LabStock"
                    ],
                    'To' => [
                        [
                            'Email' => $reservation->getEmailBorrower(),
                        ]
                    ],
                    'TemplateID' => 4645698,
                    'Subject' => "Réservation matériel",
//                    'Variables' => [
//                        'title' => $title,
//                        'content' => $content
//                    ],
                ],
            ]
        ];
            $this->mj->post(Resources::$Email, ['body' => $body]);

    }






}