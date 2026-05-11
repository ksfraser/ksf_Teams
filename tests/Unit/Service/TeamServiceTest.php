<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\Teams\Service;

use Ksfraser\Teams\Entity\Team;
use Ksfraser\Teams\Entity\TeamMember;
use Ksfraser\Teams\Service\TeamService;
use PHPUnit\Framework\TestCase;

class TeamServiceTest extends TestCase
{
    private TeamService $service;

    protected function setUp(): void
    {
        $this->service = new TeamService();
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::createTeam
     */
    public function testCreateTeamSuccess(): void
    {
        $data = [
            'name' => 'Engineering',
            'description' => 'Core engineering',
            'manager_id' => 10,
        ];

        $team = $this->service->createTeam($data);

        $this->assertInstanceOf(Team::class, $team);
        $this->assertSame('Engineering', $team->getName());
        $this->assertSame('Core engineering', $team->getDescription());
        $this->assertSame(10, $team->getManagerId());
        $this->assertTrue($team->isActive());
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::createTeam
     */
    public function testCreateTeamMinimal(): void
    {
        $data = ['name' => 'Minimal'];

        $team = $this->service->createTeam($data);

        $this->assertInstanceOf(Team::class, $team);
        $this->assertSame('Minimal', $team->getName());
        $this->assertNotEmpty($team->getCreatedAt());
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::addMember
     */
    public function testAddMemberAsOwner(): void
    {
        $this->service->createTeam(['id' => 1, 'name' => 'T']);

        $member = $this->service->addMember(1, 100, TeamMember::ROLE_OWNER);

        $this->assertInstanceOf(TeamMember::class, $member);
        $this->assertSame(100, $member->getUserId());
        $this->assertTrue($member->canRead());
        $this->assertTrue($member->canWrite());
        $this->assertTrue($member->canDelete());
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::addMember
     */
    public function testAddMemberAsManager(): void
    {
        $this->service->createTeam(['id' => 2, 'name' => 'T']);

        $member = $this->service->addMember(2, 101, TeamMember::ROLE_MANAGER);

        $this->assertInstanceOf(TeamMember::class, $member);
        $this->assertTrue($member->canRead());
        $this->assertTrue($member->canWrite());
        $this->assertFalse($member->canDelete());
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::addMember
     */
    public function testAddMemberAsMember(): void
    {
        $this->service->createTeam(['id' => 3, 'name' => 'T']);

        $member = $this->service->addMember(3, 102, TeamMember::ROLE_MEMBER);

        $this->assertInstanceOf(TeamMember::class, $member);
        $this->assertTrue($member->canRead());
        $this->assertFalse($member->canWrite());
        $this->assertFalse($member->canDelete());
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::getMembers
     */
    public function testGetMembers(): void
    {
        $this->service->createTeam(['id' => 10, 'name' => 'T']);
        $this->service->addMember(10, 200);
        $this->service->addMember(10, 201);

        $members = $this->service->getMembers(10);

        $this->assertCount(2, $members);
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::canUserAccess
     */
    public function testCanUserAccessRead(): void
    {
        $this->service->createTeam(['id' => 20, 'name' => 'T']);
        $this->service->addMember(20, 300, TeamMember::ROLE_MEMBER);

        $this->assertTrue($this->service->canUserAccess(20, 300, 'read'));
        $this->assertFalse($this->service->canUserAccess(20, 300, 'write'));
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::canUserAccess
     */
    public function testCanUserAccessNonMember(): void
    {
        $this->service->createTeam(['id' => 30, 'name' => 'T']);

        $this->assertFalse($this->service->canUserAccess(30, 999, 'read'));
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::getUserTeams
     */
    public function testGetUserTeams(): void
    {
        $this->service->createTeam(['id' => 40, 'name' => 'A']);
        $this->service->createTeam(['id' => 41, 'name' => 'B']);
        $this->service->addMember(40, 400);
        $this->service->addMember(41, 400);

        $teams = $this->service->getUserTeams(400);

        $this->assertCount(2, $teams);
    }

    /**
     * @covers Ksfraser\Teams\Service\TeamService::getTeam
     */
    public function testGetTeam(): void
    {
        $this->service->createTeam(['id' => 50, 'name' => 'FindMe']);

        $team = $this->service->getTeam(50);

        $this->assertNotNull($team);
        $this->assertSame('FindMe', $team->getName());
    }
}