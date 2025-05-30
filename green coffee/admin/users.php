<?php
include 'C:\xampp\htdocs\green coffee (2)\green coffee\component\connection.php';

// Fetch all users
$sql = "SELECT name, email, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<style>
    /* General Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #fff;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Table Headers */
thead {
    background: #2E8B57; /* Forest Green */
    color: white;
    font-weight: bold;
}

/* Table Rows */
th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

/* Zebra Striping for Rows */
tbody tr:nth-child(even) {
    background: #f5f5f5;
}

/* Hover Effect */
tbody tr:hover {
    background: #e0e0e0;
    transition: 0.3s;
}

/* Table Borders */
th {
    border-top: 1px solid #ddd;
}

/* Responsive Table */
@media (max-width: 768px) {
    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px;
    }
}

</style>
<h2>User Management</h2>
<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['created_at']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        ?>
    </tbody>
</table>
