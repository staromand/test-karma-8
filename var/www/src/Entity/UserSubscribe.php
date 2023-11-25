<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserSubscribeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSubscribeRepository::class)]
#[ORM\Table(name: 'user_subscription')]
class UserSubscribe
{
    #[ORM\Id()]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue()]
    private int $id;
    
    #[ORM\ManyToOne(targetEntity: User::class, fetch:'EAGER')]
    #[ORM\JoinColumn(name:'user_id', onDelete: 'CASCADE')]
    private User $user;
    
    #[ORM\Column(type:Types::STRING, length:255)]
    private string $someDataOfSubscription;
    
    #[ORM\Column(type:Types::INTEGER, length:11)]
    private int $validts;
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): UserSubscribe
    {
        $this->id = $id;
        return $this;
    }
    
    public function getUser(): User
    {
        return $this->user;
    }
    
    public function setUser(User $user): UserSubscribe
    {
        $this->user = $user;
        return $this;
    }
    
    public function getSomeDataOfSubscription(): string
    {
        return $this->someDataOfSubscription;
    }
    
    public function setSomeDataOfSubscription(string $someDataOfSubscription): UserSubscribe
    {
        $this->someDataOfSubscription = $someDataOfSubscription;
        return $this;
    }
    
    public function getValidts(): int
    {
        return $this->validts;
    }
    
    public function setValidts(int $validts): UserSubscribe
    {
        $this->validts = $validts;
        return $this;
    }
}
