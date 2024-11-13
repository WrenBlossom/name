document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;
    const message = document.getElementById('message');

    // Dummy credentials for demonstration
    const userCredentials = {
        user: { username: 'user', password: 'user123' },
        admin: { username: 'admin', password: 'admin123' }
    };

    // Validate credentials
    if (role === 'user' && username === userCredentials.user.username && password === userCredentials.user.password) {
        message.textContent = 'User  logged in successfully!';
        message.style.color = 'green';
    } else if (role === 'admin' && username === userCredentials.admin.username && password === userCredentials.admin.password) {
        message.textContent = 'Admin logged in successfully!';
        message.style.color = 'green';
    } else {
        message.textContent = 'Invalid credentials. Please try again.';
        message.style.color = 'red';
    }
});