const { filterTasks } = require('../src/tasks');  // Use require instead of import

describe('filterTasks', () => {
    test('should filter tasks by category', () => {
        const filtered = filterTasks('Assignment');
        expect(filtered.length).toBe(1);
        expect(filtered[0].title).toBe('Math Homework');
    });

    test('should return an empty array if no tasks match the category', () => {
        const filtered = filterTasks('Nonexistent Category');
        expect(filtered.length).toBe(0);
    });

    test('should filter tasks by the "Personal" category', () => {
        const filtered = filterTasks('Personal');
        expect(filtered.length).toBe(1);
        expect(filtered[0].title).toBe('Buy Groceries');
    });
});