<?php

namespace Tests\Unit\Shared;

use App\Core\Shared\Domain\IdGenerator;
use Tests\TestCase;

class GenerateIdTest extends TestCase
{
    private IdGenerator $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = new FixedIdGenerator;
    }

    public function test_can_generate_id()
    {
        $this->assertIsString($this->idGenerator->generate());
        $this->assertEquals('001', $this->idGenerator->generate());
    }
}
