<?php

declare(strict_types=1);

namespace Ksfraser\Teams\Entity;

class Team
{
    private ?int $id = null;
    private string $name = '';
    private string $description = '';
    private bool $active = true;
    private ?int $managerId = null;
    private array $members = [];

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function isActive(): bool { return $this->active; }
    public function setActive(bool $active): self { $this->active = $active; return $this; }
    public function getManagerId(): ?int { return $this->managerId; }
    public function setManagerId(?int $managerId): self { $this->managerId = $managerId; return $this; }
    public function getMembers(): array { return $this->members; }
    public function addMember(TeamMember $member): self { $this->members[] = $member; return $this; }
    public function removeMember(TeamMember $member): self { 
        $this->members = array_filter($this->members, fn($m) => $m !== $member); 
        return $this; 
    }
}

class TeamMember
{
    public const ROLE_MEMBER = 'Member';
    public const ROLE_LEAD = 'Lead';
    public const ROLE_ADMIN = 'Admin';

    private ?int $id = null;
    private int $teamId = 0;
    private int $employeeId = 0;
    private string $role = self::ROLE_MEMBER;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getTeamId(): int { return $this->teamId; }
    public function setTeamId(int $teamId): self { $this->teamId = $teamId; return $this; }
    public function getEmployeeId(): int { return $this->employeeId; }
    public function setEmployeeId(int $employeeId): self { $this->employeeId = $employeeId; return $this; }
    public function getRole(): string { return $this->role; }
    public function setRole(string $role): self { $this->role = $role; return $this; }

    public function isLead(): bool { return $this->role === self::ROLE_LEAD; }
    public function isAdmin(): bool { return $this->role === self::ROLE_ADMIN; }
}