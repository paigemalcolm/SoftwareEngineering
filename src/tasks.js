function openFilterModal(filterModal) {
    filterModal.style.display = 'block';
}

// Function to apply filters, refactored to take the task list and selected category as arguments
function applyTaskFilters(taskList, selectedCategory) {
    const tasks = taskList.querySelectorAll('li');
    tasks.forEach(task => {
        if (task.getAttribute('data-category') === selectedCategory) {
            task.style.display = 'list-item';
        } else {
            task.style.display = 'none';
        }
    });
}

// Function to initialize event listeners (not used for testing)
function initializeTaskFilters(filterIcon, filterModal, categoryFilter, applyFiltersButton, taskList) {
    filterIcon.addEventListener('click', () => openFilterModal(filterModal));

    applyFiltersButton.addEventListener('click', () => {
        const selectedCategory = categoryFilter.value;
        applyTaskFilters(taskList, selectedCategory);
    });
}

module.exports = {
    openFilterModal,
    applyTaskFilters,
    initializeTaskFilters
};