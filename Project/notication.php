<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        #notification-section {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            max-width: 400px;
        }
        #notification-list {
            list-style: none;
            padding: 0;
        }
        #notification-list li {
            padding: 10px;
            background: #fff;
            margin: 5px 0;
            border-left: 5px solid #007bff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .delete-btn, .update-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
            border-radius: 3px;
            margin-left: 5px;
        }
        .update-btn {
            background: orange;
        }
    </style>
</head>
<body>

    <h2>Set a Reminder</h2>
    <label for="end_time">End Time:</label>
    <input type="datetime-local" id="end_time" name="end_time" required>
    <button onclick="setReminder()">Set Reminder</button>

    <!-- Notification Section -->
    <div id="notification-section">
        <h3>Scheduled Notifications</h3>
        <ul id="notification-list"></ul>
    </div>
    <a href="dashboard.php">⬅️ Go Back to Dashboard</a>

    <script>
        function setReminder() {
            let endTimeInput = document.getElementById("end_time");
            let endTime = new Date(endTimeInput.value).getTime();
            let currentTime = new Date().getTime();

            if (isNaN(endTime) || endTime <= currentTime) {
                alert("Please select a valid future time.");
                return;
            }

            let reminders = JSON.parse(localStorage.getItem("reminders")) || [];
            reminders.push({ time: endTime });
            localStorage.setItem("reminders", JSON.stringify(reminders));

            alert("Reminder Set!");
            displayReminders();
        }

        function displayReminders() {
            let reminders = JSON.parse(localStorage.getItem("reminders")) || [];
            let notificationList = document.getElementById("notification-list");
            notificationList.innerHTML = "";

            reminders.forEach((reminder, index) => {
                let timeDifference = reminder.time - new Date().getTime();

                if (timeDifference > 0) {
                    setTimeout(() => {
                        showNotification("Reminder: Your scheduled time has ended!");
                    }, timeDifference);
                }

                let listItem = document.createElement("li");
                let reminderTime = new Date(reminder.time).toLocaleString();
                listItem.innerHTML = `Reminder set for: ${reminderTime}`;

                let updateButton = document.createElement("button");
                updateButton.textContent = "Update";
                updateButton.classList.add("update-btn");
                updateButton.onclick = function () {
                    updateReminder(index);
                };

                let deleteButton = document.createElement("button");
                deleteButton.textContent = "Delete";
                deleteButton.classList.add("delete-btn");
                deleteButton.onclick = function () {
                    deleteReminder(index);
                };

                listItem.appendChild(updateButton);
                listItem.appendChild(deleteButton);
                notificationList.appendChild(listItem);
            });
        }

        function deleteReminder(index) {
            let reminders = JSON.parse(localStorage.getItem("reminders")) || [];
            reminders.splice(index, 1);
            localStorage.setItem("reminders", JSON.stringify(reminders));
            displayReminders();
        }

        function updateReminder(index) {
            let newTime = prompt("Enter new reminder time (YYYY-MM-DD HH:MM)");
            if (!newTime) return;
            let newTimestamp = new Date(newTime).getTime();
            if (isNaN(newTimestamp) || newTimestamp <= new Date().getTime()) {
                alert("Invalid time selected!");
                return;
            }
            let reminders = JSON.parse(localStorage.getItem("reminders")) || [];
            reminders[index].time = newTimestamp;
            localStorage.setItem("reminders", JSON.stringify(reminders));
            alert("Reminder updated!");
            displayReminders();
        }

        function showNotification(message) {
            alert(message);
            if (Notification.permission === "granted") {
                new Notification("Time's up!", { body: message });
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        new Notification("Time's up!", { body: message });
                    }
                });
            }
        }

        document.addEventListener("DOMContentLoaded", displayReminders);
    </script>

</body>
</html>
