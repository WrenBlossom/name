document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the default way

    // Get form values
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;

    // Simple validation (you can extend this)
    if (username && email && password && role) {
        const message = `Registration Successful! \nUsername: ${username} \nEmail: ${email} \nRole: ${role}`;
        document.getElementById('message').innerText = message;
        // Here you can add code to send this data to a server
    } else {
        document.getElementById('message').innerText = 'Please fill in all fields.';
    }
});