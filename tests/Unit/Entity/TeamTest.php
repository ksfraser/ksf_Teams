<?php

declare(strict_types=1);

namespace Ksfraser\Teams\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Ksfraser\Teams\Entity\Team;
use Ksfraser\Teams\Entity\TeamMember;

class TeamTest extends TestCase
{
    public function testCanCreateTeam(): void
    {
        $team = new Team();
        $this->assertInstanceOf(Team::class, $team);
    }

    public function testCanSetNameAndDescription(): void
    {
        $team = new Team();
        $team->setName('Engineering');
        $team->setDescription('Dev team');
        $this->assertEquals('Engineering', $team->getName());
    }

    public function testCanSetActive(): void
    {
        $team = new Team();
        $team->setActive(true);
        $this->assertTrue($team->isActive());
    }

    public function testCanAddMember(): void
    {
        $team = new Team();
        $member = new TeamMember();
        $member->setEmployeeId(1);
        $team->addMember($member);
        
        $this->assertCount(1, $team->getMembers());
    }
}

class TeamMemberTest extends TestCase
{
    public function testCanCreateTeamMember(): void
    {
        $member = new TeamMember();
        $this->assertInstanceOf(TeamMember::class, $member);
    }

    public function testCanSetRole(): void
    {
        $member = new TeamMember();
        $member->setRole(TeamMember::ROLE_LEAD);
        $this->assertEquals(TeamMember::ROLE_LEAD, $member->getRole());
    }

    public function testCanCheckIsLead(): void
    {
        $member = new TeamMember();
        $member->setRole(TeamMember::ROLE_LEAD);
        $this->assertTrue($member->isLead());
        
        $member->setRole(TeamMember::ROLE_MEMBER);
        $this->assertFalse($member->isLead());
    }
}