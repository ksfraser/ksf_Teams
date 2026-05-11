<?php

declare(strict_types=1);

namespace Ksfraser\Teams\Service;

use Ksfraser\Teams\Entity\Team;
use Ksfraser\Teams\Entity\TeamMember;

class TeamService
{
    private array $teams = [];
    private array $memberships = [];

    public function createTeam(array $data): Team
    {
        $team = new Team();
        if (isset($data['id'])) {
            $team->setId($data['id']);
        }
        $team->setName($data['name'] ?? '');
        $team->setDescription($data['description'] ?? '');
        $team->setManagerId($data['manager_id'] ?? null);
        $team->setType($data['type'] ?? 'Department');
        $team->setActive(true);
        $team->setCreatedAt(date('Y-m-d H:i:s'));
        $team->setUpdatedAt(date('Y-m-d H:i:s'));
        
        $this->teams[$team->getId() ?? count($this->teams) + 1] = $team;
        return $team;
    }

    public function addMember(int $teamId, int $userId, string $role = TeamMember::ROLE_MEMBER): TeamMember
    {
        $member = new TeamMember();
        $member->setTeamId($teamId);
        $member->setUserId($userId);
        $member->setRole($role);
        $member->setCanRead(true);
        $member->setCanWrite(in_array($role, [TeamMember::ROLE_OWNER, TeamMember::ROLE_MANAGER]));
        $member->setCanDelete($role === TeamMember::ROLE_OWNER);
        $member->setJoinedAt(date('Y-m-d H:i:s'));
        
        $this->memberships[$teamId][] = $member;
        return $member;
    }

    public function getTeam(int $teamId): ?Team
    {
        return $this->teams[$teamId] ?? null;
    }

    public function getMembers(int $teamId): array
    {
        return $this->memberships[$teamId] ?? [];
    }

    public function canUserAccess(int $teamId, int $userId, string $permission): bool
    {
        $members = $this->getMembers($teamId);
        foreach ($members as $member) {
            if ($member->getUserId() === $userId) {
                switch ($permission) {
                    case 'read': return $member->canRead();
                    case 'write': return $member->canWrite();
                    case 'delete': return $member->canDelete();
                }
            }
        }
        return false;
    }

    public function getUserTeams(int $userId): array
    {
        $userTeams = [];
        foreach ($this->memberships as $teamId => $members) {
            foreach ($members as $member) {
                if ($member->getUserId() === $userId) {
                    $userTeams[] = $this->teams[$teamId] ?? null;
                }
            }
        }
        return array_values(array_filter($userTeams, fn($t) => $t !== null));
    }
}