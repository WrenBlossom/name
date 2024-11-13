// Add an event listener to the form for submission
document.getElementById('add-spot-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting normally

    // Get the values from the form
    const spotNumber = document.getElementById('spot-number').value;
    const spotStatus = document.getElementById('spot-status').value;

    // Validate input
    if (spotNumber && spotStatus) {
        // Get the table body
        const tableBody = document.getElementById('parking-table').getElementsByTagName('tbody')[0];
        
        // Create a new row
        const newRow = tableBody.insertRow();
        
        // Create cells for the new row
        const cell1 = newRow.insertCell(0);
        const cell2 = newRow.insertCell(1);
        
        // Set the cell values
        cell1.textContent = spotNumber;
        cell2.textContent = spotStatus;

        // Add a class based on the status for styling
        cell2.className = spotStatus.toLowerCase(); // 'available' or 'occupied'

        // Clear the form inputs
        document.getElementById('spot-number').value = '';
        document.getElementById('spot-status').value = '';
    } else {
        alert('Please fill in all fields.');
    }
});

// Add an event listener to the toggle button
document.getElementById('toggle-sidebar').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open'); // Toggle the 'open' class
});