const tasks = [
    { title: 'Math Homework', category: 'Assignment' },
    { title: 'Buy Groceries', category: 'Personal' },
    { title: 'Prepare for Exam', category: 'Exam' }
];

// Function to filter tasks by category
function filterTasks(category) {
    return tasks.filter(task => task.category === category);
}

module.exports = { filterTasks };  