<?php

class EditTask {
    private $tasks = [];

    public function __construct($tasks) {
        $this->tasks = $tasks; // Initialize with existing tasks
    }

    public function editTask($taskId, $updatedData) {
        // Validate task ID
        if (!isset($this->tasks[$taskId])) {
            throw new InvalidArgumentException("Task not found");
        }

        // Validate required fields in updated data
        if (empty($updatedData['title']) || empty($updatedData['description'])) {
            throw new InvalidArgumentException("Title and description cannot be empty");
        }

        // Update task details
        $this->tasks[$taskId] = array_merge($this->tasks[$taskId], $updatedData);
        return $this->tasks[$taskId];
    }

    public function deleteTask($taskId) {
        // Validate task ID
        if (!isset($this->tasks[$taskId])) {
            throw new InvalidArgumentException("Task not found");
        }

        // Remove the task from the array
        unset($this->tasks[$taskId]);
        return true; 
    }

    // Method to retrieve all tasks
    public function getTasks() {
        return $this->tasks;
    }
}