<?php

class TaskManager {
    private $tasks = [];

    public function addTask($title, $description, $dueDate, $priority, $category, $file = null) {
        if (empty($title) || empty($description) || empty($dueDate) || empty($priority) || empty($category)) {
            throw new InvalidArgumentException("All required fields must be filled");
        }

        $newTask = [
            'title' => $title,
            'description' => $description,
            'dueDate' => $dueDate,
            'priority' => $priority,
            'category' => $category,
            'file' => $file,
            'status' => 'Not Started'
        ];

        $this->tasks[] = $newTask;
        return $newTask;
    }

    public function getTasks() {
        return $this->tasks;
    }
}
