<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserSubscriptionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSubscriptionRepository::class)]
#[ORM\Table(name: 'user_subscription')]
#[ORM\Index(columns: ['valid_ts'], name: 'valid_ts_idx')]
class UserSubscription
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;
    
    #[ORM\Column(type:Types::INTEGER)]
    private int $userId;
    
    #[ORM\ManyToOne(targetEntity: User::class, fetch:'EAGER')]
    #[ORM\JoinColumn(name:'user_id', onDelete: 'CASCADE')]
    private User $user;
    
    #[ORM\Column(type:Types::STRING, length: AbstractMySQLPlatform::LENGTH_LIMIT_TINYTEXT)]
    private string $someDataOfSubscription;
    
    #[ORM\Column(type:Types::INTEGER, length:11)]
    private int $validTs;
    
    #[ORM\OneToMany(mappedBy: 'userSubscription', targetEntity: SubscriptionNotificationEvent::class)]
    private Collection $subscriptionNotificationEvents;
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): UserSubscription
    {
        $this->id = $id;
        return $this;
    }
    
    public function getUser(): User
    {
        return $this->user;
    }
    
    public function setUser(User $user): UserSubscription
    {
        $this->user = $user;
        return $this;
    }
    
    public function getSomeDataOfSubscription(): string
    {
        return $this->someDataOfSubscription;
    }
    
    public function setSomeDataOfSubscription(string $someDataOfSubscription): UserSubscription
    {
        $this->someDataOfSubscription = $someDataOfSubscription;
        return $this;
    }
    
    public function getValidTs(): int
    {
        return $this->validTs;
    }
    
    public function setValidTs(int $validTs): UserSubscription
    {
        $this->validTs = $validTs;
        return $this;
    }
    
    public function getSubscriptionNotificationEvents(): Collection
    {
        return $this->subscriptionNotificationEvents;
    }
    
    public function setSubscriptionNotificationEvents(Collection $subscriptionNotificationEvents): UserSubscription
    {
        $this->subscriptionNotificationEvents = $subscriptionNotificationEvents;
        return $this;
    }
}
