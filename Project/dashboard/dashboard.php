<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkopedia Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Parkopedia Dashboard</h1>
        </header>
        <div class="main-content">
            <nav class="sidebar">
                <ul>
                    <li><a href= "index.html">Home</a></li><br>
                    <li><a href="#parking-info">Parking Info</a></li><br>
                    <li><a href="#add-spot">Add Parking Spot</a></li><br>
                    <li><a href="#reports">Reports</a></li><br>
                    <li><a href="#login">log In</a></li><br>
                </ul>
            </nav>
            <main>
                <section id="parking-info">
                    <h2>Parking Spots</h2>
                    <table id="parking-table">
                        <thead>
                            <tr>
                                <th>Spot Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Example data, you can replace this with a database query
                            $parkingSpots = [
                                ['number' => 1, 'status' => 'Occupied'],
                                ['number' => 2, 'status' => 'Available'],
                                ['number' => 3, 'status' => 'Occupied'],
                                ['number' => 4, 'status' => 'Available'],
                            ];

                            foreach ($parkingSpots as $spot) {
                                echo "<tr>
                                        <td>{$spot['number']}</td>
                                        <td class='" . strtolower($spot['status']) . "'>{$spot['status']}</td>
                                      </tr>";
                            }
                            foreach ($parkingSpots as $spot) {
                                echo "<tr>
                                        <td>{$spot['number']}</td>
                                        <td class='" . strtolower($spot['status']) . "'>{$spot['status']}</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </section>
                <section id="add-spot">
                    <h2>Add Parking Spot</h2>
                    <form id="add-spot-form">
                        <input type="text" id="spot-number" placeholder="Spot Number" required>
                        <select id="spot-status" required>
                            <option value="">Select Status</option>
                            <option value="Available">Available</option>
                            <option value="Occupied">Occupied</option>
                        </select>
                        <button type="submit">Add Spot</button>
                    </form>
                </section>
                <section id="reports">
                    <h2>Reports</h2>
                    <p>Coming soon...</p>
                </section>
            </main>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>