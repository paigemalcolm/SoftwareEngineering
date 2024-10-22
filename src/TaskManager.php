<?php

class TaskManager {
    private $tasks = [];

    public function addTask($title, $description, $dueDate, $priority, $category, $file = null) {
        // Validate required fields, throw exception if not validated
        if (empty($title) || empty($description) || empty($dueDate) || empty($priority) || empty($category)) {
            throw new InvalidArgumentException("All required fields must be filled");
        }

        // Create task array
        $newTask = [
            'title' => $title,
            'description' => $description,
            'dueDate' => $dueDate,
            'priority' => $priority,
            'category' => $category,
            'file' => $file,
            'status' => 'Not Started'
        ];

        // Add new task to task array
        $this->tasks[] = $newTask;
        return $newTask;
    }

    // Method to retrieve all tasks
    public function getTasks() {
        return $this->tasks;
    }
}
