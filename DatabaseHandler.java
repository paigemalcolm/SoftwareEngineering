import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import javax.swing.JOptionPane;

public class DatabaseHandler {
    // Database connection details
    private static final String DB_URL = "jdbc:mysql://localhost:3306/TaskMonitor"; // Update with your DB URL
    private static final String DB_USER = ""; // Replace with your DB username
    private static final String DB_PASSWORD = ""; // Replace with your DB password

    // Method to establish a connection to the database
    private Connection connectToDatabase() {
        try {
            return DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
        } catch (SQLException e) {
            e.printStackTrace();
            JOptionPane.showMessageDialog(null, "Database connection failed.");
            return null;
        }
    }

    // Method to authenticate user during login
    public boolean authenticateUser(String email, String password) {
        String query = "SELECT * FROM user WHERE email = ? AND passwordHash = ?";

        try (Connection conn = connectToDatabase();
             PreparedStatement stmt = conn.prepareStatement(query)) {

            stmt.setString(1, email);
            stmt.setString(2, password); // For real applications, use a hashed password

            ResultSet rs = stmt.executeQuery();
            return rs.next(); // Returns true if a matching user is found

        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    // Method to register a new user
    public boolean registerUser(String email, String password) {
        String query = "INSERT INTO user (email, passwordHash) VALUES (?, ?)";

        try (Connection conn = connectToDatabase();
             PreparedStatement stmt = conn.prepareStatement(query)) {

            stmt.setString(1, email);
            stmt.setString(2, password); // For real applications, store a hashed password

            int rowsAffected = stmt.executeUpdate();
            return rowsAffected > 0; // Returns true if the user was successfully added

        } catch (SQLException e) {
            if (e.getErrorCode() == 1062) { // Duplicate entry for email
                JOptionPane.showMessageDialog(null, "Email already registered.");
            } else {
                e.printStackTrace();
            }
            return false;
        }
    }
}