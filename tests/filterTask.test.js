const { openFilterModal, applyTaskFilters } = require('../src/tasks');

describe('Task Filtering Functionality', () => {
    // Test 1: Open filter modal
    test('should open filter modal when called', () => {
        // Mock modal element
        const mockFilterModal = { style: { display: 'none' } };

        // Call function to open modal
        openFilterModal(mockFilterModal);

        // Check if the modal is displayed
        expect(mockFilterModal.style.display).toBe('block');
    });

    // Test 2: Apply task filters based on selected category
    test('should filter tasks by selected category', () => {
        // Mock task list with tasks
        const mockTaskList = {
            querySelectorAll: jest.fn().mockReturnValue([
                { getAttribute: jest.fn(() => 'Assignment'), style: { display: 'none' } },
                { getAttribute: jest.fn(() => 'Exam'), style: { display: 'none' } },
                { getAttribute: jest.fn(() => 'Personal'), style: { display: 'none' } }
            ])
        };

        // Call function to apply filters for the 'Exam' category
        applyTaskFilters(mockTaskList, 'Exam');

        // Verify that only the 'Exam' task is displayed
        expect(mockTaskList.querySelectorAll()[1].style.display).toBe('list-item');
        expect(mockTaskList.querySelectorAll()[0].style.display).toBe('none');
        expect(mockTaskList.querySelectorAll()[2].style.display).toBe('none');
    });

    // Test 3: Ensure all tasks are hidden if no matching category is found
    test('should hide all tasks if no matching category is found', () => {
        // Mock task list with tasks
        const mockTaskList = {
            querySelectorAll: jest.fn().mockReturnValue([
                { getAttribute: jest.fn(() => 'Assignment'), style: { display: 'none' } },
                { getAttribute: jest.fn(() => 'Exam'), style: { display: 'none' } },
                { getAttribute: jest.fn(() => 'Personal'), style: { display: 'none' } }
            ])
        };

        // Call function to apply filters for a category not in the list
        applyTaskFilters(mockTaskList, 'NonExistentCategory');

        // Verify that all tasks are hidden
        mockTaskList.querySelectorAll().forEach(task => {
            expect(task.style.display).toBe('none');
        });
    });
});