<?php


namespace App\Event\EventSubscriber;

use App\Entity\ImgMaterial;
use App\Entity\Reservation;
use App\Form\MaterialImgType;
use App\Service\Emailservice;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class EntitySubscriber implements EventSubscriber
{

    public function __construct(
        private Emailservice $emailservice,
        private EntityManagerInterface $entityManager,
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
            if(!$entity->getEndDate()){
                $entity->getMaterial()->setIsAvailable(false);
                $this->entityManager->persist($entity);
                $this->entityManager->flush();
            }
//            $this->emailservice->sendConfirmationReservation($entity);
//            $this->emailservice->sendNotificationOwner($entity);
        }


    }
}
?>