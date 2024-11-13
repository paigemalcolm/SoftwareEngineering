import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;
import java.awt.event.FocusAdapter;
import java.awt.event.FocusEvent;

public class TaskManagerUI extends JFrame {
    private CardLayout cardLayout = new CardLayout();
    private JPanel mainPanel = new JPanel(cardLayout);
    private PlaceholderTextField emailFieldLogin, emailFieldSignup;
    private PlaceholderPasswordField passwordFieldLogin, passwordFieldSignup;
    private DatabaseHandler dbHandler = new DatabaseHandler(); // Instance of DatabaseHandler

    public TaskManagerUI() {
        setTitle("Task Manager");
        setSize(500, 600);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLocationRelativeTo(null);
        setLayout(new BorderLayout());

        // Main panel styling
        mainPanel.setBackground(new Color(13, 71, 161));

        // Login Panel
        JPanel loginPanel = createLoginPanel();
        
        // Signup Panel
        JPanel signupPanel = createSignupPanel();

        // Add panels to main panel
        mainPanel.add(loginPanel, "Login");
        mainPanel.add(signupPanel, "Signup");

        add(mainPanel);
        setVisible(true);
    }

    private JPanel createLoginPanel() {
        JPanel loginPanel = new JPanel();
        loginPanel.setBackground(new Color(13, 71, 161));
        loginPanel.setLayout(new GridBagLayout());
        GridBagConstraints gbc = new GridBagConstraints();
        
        // Title
        JLabel title = new JLabel("Task Manager");
        title.setFont(new Font("Arial", Font.BOLD, 28));
        title.setForeground(Color.WHITE);
        
        JLabel subtitle = new JLabel("Welcome Back!");
        subtitle.setFont(new Font("Arial", Font.PLAIN, 18));
        subtitle.setForeground(Color.WHITE);
        
        // Email field with placeholder
        emailFieldLogin = new PlaceholderTextField("email", 20);
        styleRoundedTextField(emailFieldLogin);
        
        // Password field with placeholder
        passwordFieldLogin = new PlaceholderPasswordField("password", 20);
        styleRoundedTextField(passwordFieldLogin);
        
        // Login button
        JButton loginButton = new JButton("Log in");
        styleButton(loginButton);
        loginButton.addActionListener(e -> {
            String email = emailFieldLogin.getText();
            String password = new String(passwordFieldLogin.getPassword());

            if (dbHandler.authenticateUser(email, password)) {
                JOptionPane.showMessageDialog(null, "Login successful!");
                // Proceed to the main application screen
            } else {
                JOptionPane.showMessageDialog(null, "Invalid email or password.");
            }
        });

        // Sign up link
        JLabel switchToSignup = new JLabel("New user? Sign up");
        switchToSignup.setForeground(Color.WHITE);
        switchToSignup.setFont(new Font("Arial", Font.PLAIN, 14));
        switchToSignup.setCursor(new Cursor(Cursor.HAND_CURSOR));
        switchToSignup.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent e) {
                cardLayout.show(mainPanel, "Signup");
            }
        });

        // Arrange components
        gbc.insets = new Insets(10, 0, 10, 0);
        gbc.gridx = 0; gbc.gridy = 0;
        loginPanel.add(title, gbc);
        gbc.gridy++;
        loginPanel.add(subtitle, gbc);
        gbc.gridy++;
        loginPanel.add(emailFieldLogin, gbc);
        gbc.gridy++;
        loginPanel.add(passwordFieldLogin, gbc);
        gbc.gridy++;
        loginPanel.add(loginButton, gbc);
        gbc.gridy++;
        loginPanel.add(switchToSignup, gbc);
        
        return loginPanel;
    }

    private JPanel createSignupPanel() {
        JPanel signupPanel = new JPanel();
        signupPanel.setBackground(new Color(13, 71, 161));
        signupPanel.setLayout(new GridBagLayout());
        GridBagConstraints gbc = new GridBagConstraints();

        // Title
        JLabel title = new JLabel("Task Manager");
        title.setFont(new Font("Arial", Font.BOLD, 28));
        title.setForeground(Color.WHITE);

        JLabel subtitle = new JLabel("Welcome!");
        subtitle.setFont(new Font("Arial", Font.PLAIN, 18));
        subtitle.setForeground(Color.WHITE);

        // Email field with placeholder
        emailFieldSignup = new PlaceholderTextField("email", 20);
        styleRoundedTextField(emailFieldSignup);

        // Password field with placeholder
        passwordFieldSignup = new PlaceholderPasswordField("password", 20);
        styleRoundedTextField(passwordFieldSignup);

        // Signup button
        JButton signupButton = new JButton("Sign up");
        styleButton(signupButton);
        signupButton.addActionListener(e -> {
            String email = emailFieldSignup.getText();
            String password = new String(passwordFieldSignup.getPassword());

            if (dbHandler.registerUser(email, password)) {
                JOptionPane.showMessageDialog(null, "Signup successful!");
                cardLayout.show(mainPanel, "Login");
            } else {
                JOptionPane.showMessageDialog(null, "Signup failed. Email might already be registered.");
            }
        });

        // Log in link
        JLabel switchToLogin = new JLabel("Already have an account? Log in");
        switchToLogin.setForeground(Color.WHITE);
        switchToLogin.setFont(new Font("Arial", Font.PLAIN, 14));
        switchToLogin.setCursor(new Cursor(Cursor.HAND_CURSOR));
        switchToLogin.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent e) {
                cardLayout.show(mainPanel, "Login");
            }
        });

        // Arrange components
        gbc.insets = new Insets(10, 0, 10, 0);
        gbc.gridx = 0; gbc.gridy = 0;
        signupPanel.add(title, gbc);
        gbc.gridy++;
        signupPanel.add(subtitle, gbc);
        gbc.gridy++;
        signupPanel.add(emailFieldSignup, gbc);
        gbc.gridy++;
        signupPanel.add(passwordFieldSignup, gbc);
        gbc.gridy++;
        signupPanel.add(signupButton, gbc);
        gbc.gridy++;
        signupPanel.add(switchToLogin, gbc);

        return signupPanel;
    }

    private void styleRoundedTextField(JTextField textField) {
        textField.setFont(new Font("Arial", Font.PLAIN, 16));
        textField.setPreferredSize(new Dimension(250, 40));
        textField.setBorder(BorderFactory.createCompoundBorder(
                BorderFactory.createLineBorder(Color.LIGHT_GRAY, 1, true),
                new EmptyBorder(10, 15, 10, 10)));
    }

    private void styleButton(JButton button) {
        button.setFont(new Font("Arial", Font.BOLD, 16));
        button.setBackground(Color.WHITE);
        button.setForeground(new Color(13, 71, 161));
        button.setFocusPainted(false);
        button.setPreferredSize(new Dimension(250, 40));
    }

    public static void main(String[] args) {
        new TaskManagerUI();
    }
}

// Custom JTextField with placeholder text functionality
class PlaceholderTextField extends JTextField {
    private String placeholder;

    public PlaceholderTextField(String placeholder, int columns) {
        super(columns);
        this.placeholder = placeholder;
        addPlaceholderFeature();
    }

    private void addPlaceholderFeature() {
        setText(placeholder);
        setForeground(Color.GRAY);

        addFocusListener(new FocusAdapter() {
            @Override
            public void focusGained(FocusEvent e) {
                if (getText().equals(placeholder)) {
                    setText("");
                    setForeground(Color.BLACK);
                }
            }

            @Override
            public void focusLost(FocusEvent e) {
                if (getText().isEmpty()) {
                    setText(placeholder);
                    setForeground(Color.GRAY);
                }
            }
        });
    }
}

// Custom JPasswordField with placeholder text functionality
class PlaceholderPasswordField extends JPasswordField {
    private String placeholder;
    private boolean showingPlaceholder = true;

    public PlaceholderPasswordField(String placeholder, int columns) {
        super(columns);
        this.placeholder = placeholder;
        addPlaceholderFeature();
    }

    private void addPlaceholderFeature() {
        setEchoChar((char) 0); // Show text initially
        setText(placeholder);
        setForeground(Color.GRAY);

        addFocusListener(new FocusAdapter() {
            @Override
            public void focusGained(FocusEvent e) {
                if (showingPlaceholder) {
                    setText("");
                    setEchoChar('\u2022'); // Show dots when typing starts
                    setForeground(Color.BLACK);
                    showingPlaceholder = false;
                }
            }

            @Override
            public void focusLost(FocusEvent e) {
                if (getPassword().length == 0) {
                    setEchoChar((char) 0); // Show text as placeholder
                    setText(placeholder);
                    setForeground(Color.GRAY);
                    showingPlaceholder = true;
                }
            }
        });
    }
}
