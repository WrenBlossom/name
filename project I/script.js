// script.js

// Function to toggle the sidebar
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    if (sidebar.style.left === "0px") {
        sidebar.style.left = "-250px"; // Hide sidebar
    } else {
        sidebar.style.left = "0px"; // Show sidebar
    }
}

// Function to toggle the user profile dropdown
function toggleProfile() {
    const userInfo = document.getElementById("userInfo");
    if (userInfo.style.display === "block") {
        userInfo.style.display = "none"; // Hide user profile
    } else {
        userInfo.style.display = "block"; // Show user profile
    }
}

// Function to toggle the notification dropdown
function toggleNotification() {
    const notificationDropdown = document.getElementById("notificationDropdown");
    if (notificationDropdown.style.display === "block") {
        notificationDropdown.style.display = "none"; // Hide notifications
    } else {
        notificationDropdown.style.display = "block"; // Show notifications
    }
}

// Initialize the chart using Chart.js

// Call the function to initialize the chart
initChart();