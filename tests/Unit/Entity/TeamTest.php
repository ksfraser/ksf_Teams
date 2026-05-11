<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\Teams\Entity;

use Ksfraser\Teams\Entity\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $team = new Team();

        $this->assertNull($team->getId());
        $this->assertSame('', $team->getName());
        $this->assertSame('', $team->getDescription());
        $this->assertNull($team->getManagerId());
        $this->assertSame('Department', $team->getType());
        $this->assertTrue($team->isActive());
    }

    /**
     * @covers Ksfraser\Teams\Entity\Team::setId
     * @covers Ksfraser\Teams\Entity\Team::getId
     */
    public function testSetId(): void
    {
        $team = new Team();
        $result = $team->setId(1);

        $this->assertInstanceOf(Team::class, $result);
        $this->assertSame(1, $team->getId());
    }

    /**
     * @covers Ksfraser\Teams\Entity\Team::setName
     * @covers Ksfraser\Teams\Entity\Team::getName
     */
    public function testSetName(): void
    {
        $team = new Team();
        $result = $team->setName('Engineering');

        $this->assertInstanceOf(Team::class, $result);
        $this->assertSame('Engineering', $team->getName());
    }

    /**
     * @covers Ksfraser\Teams\Entity\Team::setDescription
     * @covers Ksfraser\Teams\Entity\Team::getDescription
     */
    public function testSetDescription(): void
    {
        $team = new Team();
        $result = $team->setDescription('Core engineering team');

        $this->assertInstanceOf(Team::class, $result);
        $this->assertSame('Core engineering team', $team->getDescription());
    }

    /**
     * @covers Ksfraser\Teams\Entity\Team::setManagerId
     * @covers Ksfraser\Teams\Entity\Team::getManagerId
     */
    public function testSetManagerId(): void
    {
        $team = new Team();
        $result = $team->setManagerId(100);

        $this->assertInstanceOf(Team::class, $result);
        $this->assertSame(100, $team->getManagerId());
    }

    /**
     * @covers Ksfraser\Teams\Entity\Team::setType
     * @covers Ksfraser\Teams\Entity\Team::getType
     */
    public function testSetType(): void
    {
        $team = new Team();
        $result = $team->setType('Project');

        $this->assertInstanceOf(Team::class, $result);
        $this->assertSame('Project', $team->getType());
    }

    /**
     * @covers Ksfraser\Teams\Entity\Team::setActive
     * @covers Ksfraser\Teams\Entity\Team::isActive
     */
    public function testSetActive(): void
    {
        $team = new Team();
        $result = $team->setActive(false);

        $this->assertInstanceOf(Team::class, $result);
        $this->assertFalse($team->isActive());
    }

    /**
     * @covers Ksfraser\Teams\Entity\Team::setCreatedAt
     * @covers Ksfraser\Teams\Entity\Team::getCreatedAt
     */
    public function testSetCreatedAt(): void
    {
        $team = new Team();
        $result = $team->setCreatedAt('2026-01-01 10:00:00');

        $this->assertInstanceOf(Team::class, $result);
        $this->assertSame('2026-01-01 10:00:00', $team->getCreatedAt());
    }
}