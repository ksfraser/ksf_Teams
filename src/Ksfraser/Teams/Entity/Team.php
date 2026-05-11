<?php

declare(strict_types=1);

namespace Ksfraser\Teams\Entity;

class Team
{
    private ?int $id = null;
    private string $name = '';
    private string $description = '';
    private ?int $managerId = null;
    private string $type = 'Department';
    private bool $active = true;
    private string $createdAt = '';
    private string $updatedAt = '';

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function getManagerId(): ?int { return $this->managerId; }
    public function setManagerId(?int $managerId): self { $this->managerId = $managerId; return $this; }
    public function getType(): string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function isActive(): bool { return $this->active; }
    public function setActive(bool $active): self { $this->active = $active; return $this; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function setCreatedAt(string $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function getUpdatedAt(): string { return $this->updatedAt; }
    public function setUpdatedAt(string $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }
}