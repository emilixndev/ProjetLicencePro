<?php


namespace App\Event\EventSubscriber;

use App\Entity\Reservation;
use App\Service\Emailservice;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class EntitySubscriber implements EventSubscriber
{

    public function __construct(
        private Emailservice $emailservice
    )
    {

    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if($entity instanceof Reservation){
            $this->emailservice->sendConfirmationReservation($entity);
            $this->emailservice->sendNotificationOwner($entity);
        }
    }
}
?>