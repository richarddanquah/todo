<?php

namespace Tests\Unit;
use App\Models\Todo;
use Tests\TestCase; // Changed from PHPUnit\Framework\TestCase
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_todo_creation()
    {
        $todo = Todo::factory()->create([
            'status' => 'in progress'
        ]);

        $this->assertEquals('in progress', $todo->status);
    }
}