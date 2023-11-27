<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SubscriptionNotificationEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;


class SubscriptionNotificationEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriptionNotificationEvent::class);
    }
    
    /**
     * @return ArrayCollection|iterable<SubscriptionNotificationEvent>
     */
    public function fetchUnprocessed(): ArrayCollection
    {
        $qb = $this->createQueryBuilder('ev');
    
        $query = $qb
            ->leftJoin('ev.userSubscription', 'uss')
            ->leftJoin('uss.user', 'u')
            ->where('ev.triggered = false')
            ->andWhere('u.validEmail = true');
        
        return new ArrayCollection($query->getQuery()->getResult());
    }
}
