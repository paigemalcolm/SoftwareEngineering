<?php

use PHPUnit\Framework\TestCase;
require_once './src/TaskManager.php';

class TaskManagerTest extends TestCase {

    public function testAddTaskSuccessfully() {

        // Create TaskManager instance
        $taskManager = new TaskManager();

        // Add a task and store the task details
        $task = $taskManager->addTask(
            "Complete Unit Tests",
            "Write tests for task manager",
            "2024-10-20",
            "High",
            "Development",
            null 
        );

        // Assertions for verifying task was added correctly
        $this->assertEquals("Complete Unit Tests", $task['title']);
        $this->assertEquals("Write tests for task manager", $task['description']);
        $this->assertEquals("2024-10-20", $task['dueDate']);
        $this->assertEquals("High", $task['priority']);
        $this->assertEquals("Development", $task['category']);
        $this->assertEquals("Not Started", $task['status']);
    }

    // Test case for empty fields to throw an exception
    public function testAddTaskWithEmptyFieldsThrowsException() {
        $taskManager = new TaskManager();
        
        // Expect and invalid arguement expection to be thrown
        $this->expectException(InvalidArgumentException::class);

        // Add a task with 'title' field missing
        $taskManager->addTask(
            "",
            "Write tests for task manager",
            "2024-10-20",
            "High",
            "Development",
            null
        );
    }
}
