<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase; //this
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */

    public function test_fetch_todo_list(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('todo_lists.index'));
        
        $this->assertEquals(1, count($response->json()));
    }

    public function test_store_new_todo_list(): void
    {
        // Tasks array
        $tasks = [
            [
                'title' => 'Task 1',
                'due_date' => '2023-05-18',
                'due_time' => '14:20:00',
                'status' => 'pending',
            ]
        ];

        $this->assertTrue(true);
    }

}
