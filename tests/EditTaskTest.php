<?php

use PHPUnit\Framework\TestCase;
require_once './src/EditTask.php';

class EditTaskTest extends TestCase {
    private $editTask;

    protected function setUp(): void {
        // Sample tasks for testing
        $tasks = [
            1 => ['title' => 'Test Task 1', 'description' => 'Description 1', 'dueDate' => '2024-12-01', 'priority' => 'High', 'category' => 'Work'],
            2 => ['title' => 'Test Task 2', 'description' => 'Description 2', 'dueDate' => '2024-12-02', 'priority' => 'Medium', 'category' => 'Personal'],
        ];
        $this->editTask = new EditTask($tasks);
    }

    public function testEditTaskSuccessfully() {
        $updatedData = ['title' => 'Updated Task', 'description' => 'Updated Description'];
        
        // Edit the task and get the updated task details
        $task = $this->editTask->editTask(1, $updatedData);

        // Assertions to verify the task was updated correctly
        $this->assertEquals('Updated Task', $task['title']);
        $this->assertEquals('Updated Description', $task['description']);
    }

    public function testEditNonExistentTaskThrowsException() {
        $this->expectException(InvalidArgumentException::class);
        
        // Attempt to edit a non-existent task
        $this->editTask->editTask(999, ['title' => 'New Title', 'description' => 'New Description']);
    }

    public function testDeleteTaskSuccessfully() {
        $result = $this->editTask->deleteTask(1);
        $this->assertTrue($result); // Assert deletion was successful
        
        // Verify the task was removed
        $this->assertArrayNotHasKey(1, $this->editTask->getTasks());
    }

    public function testDeleteNonExistentTaskThrowsException() {
        $this->expectException(InvalidArgumentException::class);
        
        // Attempt to delete a non-existent task
        $this->editTask->deleteTask(999);
    }
}