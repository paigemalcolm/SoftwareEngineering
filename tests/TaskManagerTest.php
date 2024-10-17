<?php

use PHPUnit\Framework\TestCase;
require_once '../src/TaskManager.php';

class TaskManagerTest extends TestCase {

    public function testAddTaskSuccessfully() {
        $taskManager = new TaskManager();
        $task = $taskManager->addTask(
            "Complete Unit Tests",
            "Write tests for task manager",
            "2024-10-20",
            "High",
            "Development",
            null // No file uploaded
        );

        // Assertions
        $this->assertEquals("Complete Unit Tests", $task['title']);
        $this->assertEquals("Write tests for task manager", $task['description']);
        $this->assertEquals("2024-10-20", $task['dueDate']);
        $this->assertEquals("High", $task['priority']);
        $this->assertEquals("Development", $task['category']);
        $this->assertEquals("Not Started", $task['status']);
    }

    public function testAddTaskWithEmptyFieldsThrowsException() {
        $taskManager = new TaskManager();
        
        $this->expectException(InvalidArgumentException::class);

        // Missing 'title' field
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
