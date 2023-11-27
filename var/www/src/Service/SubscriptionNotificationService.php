<?php

namespace App\Service;

use App\Entity\SubscriptionNotificationEvent;
use App\Entity\UserSubscription;
use App\Enum\Database\SubscriptionNotification\Type;
use App\Repository\SubscriptionNotificationEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class SubscriptionNotificationService
{
    public function __construct(
        private SubscriptionNotificationEventRepository $subscriptionNotificationEventRepository,
        private EntityManagerInterface $em,
        private LoggerInterface $logger,
    )
    {
    }
    
    /**
     * @return ArrayCollection|iterable<SubscriptionNotificationEvent>
     */
    public function getUnprocessed(): ArrayCollection
    {
        return $this->subscriptionNotificationEventRepository->fetchUnprocessed();
    }
    
    /**
     * @param ArrayCollection|iterable<SubscriptionNotificationEvent> $events
     *
     * @return int – number of successfully sent emails
     */
    public function sendAllEmails(ArrayCollection $events): int
    {
        $count = 0;
        foreach ($events as $event) {
            try {
                if (!$this->sendEmail($event->getUserSubscription(), $event->getType())) {
                    continue;
                }
                
                $event->setTriggered(true);
                $this->em->persist($event);
                $count++;
                
            } catch (\Throwable $e) {
                $this->logger->error($e);
            }
        }
        
        $this->em->flush();
        
        return $count;
    }
    
    public function sendEmail(UserSubscription $userSubscription, Type $type): bool
    {
        // using an event type, for example to define an email template
        // switch ($type) {
        //     case Type::OneDayLeft:
        //         break;
        //     case Type::ThreeDaysLeft:
        //         break;
        //     default;
        // }
        
        // Is doing send_email('karma8-user@example.domain', $userSubscription->getUser()->getEmail(), $text)
        
        return true;
    }
}
