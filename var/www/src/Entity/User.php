<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[ORM\Index(columns: ['valid_email'], name: 'valid_email_idx')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;
    
    #[ORM\Column(type: Types::STRING, length: AbstractMySQLPlatform::LENGTH_LIMIT_TINYTEXT)]
    private string $username;
    
    #[ORM\Column(type: Types::STRING, length: AbstractMySQLPlatform::LENGTH_LIMIT_TINYTEXT)]
    private string $email;
    
    #[ORM\Column(type: Types::BOOLEAN, options:['default' => false])]
    private bool $confirmed_email;

    #[ORM\Column(type: Types::BOOLEAN, options:['default' => false])]
    private bool $checked_email;
    
    #[ORM\Column(type: Types::BOOLEAN, options:['default' => false])]
    private bool $valid_email;
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }
    
    public function getUsername(): string
    {
        return $this->username;
    }
    
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }
    
    public function isConfirmedEmail(): bool
    {
        return $this->confirmed_email;
    }
    
    public function setConfirmedEmail(bool $confirmed_email): User
    {
        $this->confirmed_email = $confirmed_email;
        return $this;
    }
    
    public function isCheckedEmail(): bool
    {
        return $this->checked_email;
    }
    
    public function setCheckedEmail(bool $checked_email): User
    {
        $this->checked_email = $checked_email;
        return $this;
    }
    
    public function isValidEmail(): bool
    {
        return $this->valid_email;
    }
    
    public function setValidEmail(bool $valid_email): User
    {
        $this->valid_email = $valid_email;
        return $this;
    }
}
