<?php

declare(strict_types=1);

namespace Ksfraser\Teams\Entity;

class TeamMember
{
    public const ROLE_OWNER = 'Owner';
    public const ROLE_MANAGER = 'Manager';
    public const ROLE_MEMBER = 'Member';

    private ?int $id = null;
    private int $teamId = 0;
    private int $userId = 0;
    private string $role = self::ROLE_MEMBER;
    private bool $canRead = true;
    private bool $canWrite = false;
    private bool $canDelete = false;
    private string $joinedAt = '';

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getTeamId(): int { return $this->teamId; }
    public function setTeamId(int $teamId): self { $this->teamId = $teamId; return $this; }
    public function getUserId(): int { return $this->userId; }
    public function setUserId(int $userId): self { $this->userId = $userId; return $this; }
    public function getRole(): string { return $this->role; }
    public function setRole(string $role): self { $this->role = $role; return $this; }
    public function canRead(): bool { return $this->canRead; }
    public function setCanRead(bool $canRead): self { $this->canRead = $canRead; return $this; }
    public function canWrite(): bool { return $this->canWrite; }
    public function setCanWrite(bool $canWrite): self { $this->canWrite = $canWrite; return $this; }
    public function canDelete(): bool { return $this->canDelete; }
    public function setCanDelete(bool $canDelete): self { $this->canDelete = $canDelete; return $this; }
    public function getJoinedAt(): string { return $this->joinedAt; }
    public function setJoinedAt(string $joinedAt): self { $this->joinedAt = $joinedAt; return $this; }
}