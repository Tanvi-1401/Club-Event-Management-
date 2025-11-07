<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$role = $_SESSION['role'];

// ✅ Handle Add Event
if ($role == 'admin' && isset($_POST['add_event'])) {
    $club = $_POST['club'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $desc = $_POST['description'];
    $link = $_POST['form_link'];

    $conn->query("INSERT INTO events (club, title, date, description, form_link)
                  VALUES ('$club', '$title', '$date', '$desc', '$link')");
}

// ✅ Handle Delete
if ($role == 'admin' && isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM events WHERE id=$id");
}

// ✅ Handle AJAX Update (when form submitted)
if ($role == 'admin' && isset($_POST['ajax_update'])) {
    $id = $_POST['event_id'];
    $club = $_POST['club'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $desc = $_POST['description'];
    $link = $_POST['form_link'];

    $update = $conn->query("UPDATE events SET 
        club='$club',
        title='$title',
        date='$date',
        description='$desc',
        form_link='$link'
        WHERE id=$id");

    echo $update ? "success" : "error";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>College Club Event Management</title>
    <style>
        body { font-family: Arial; background-color: #eef3ff; }
        table { border-collapse: collapse; width: 85%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #0066ff; color: white; }
        .logout { float: right; margin: 10px; }
        .admin-form { width: 70%; margin: 20px auto; background: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 0 10px gray; }
        input, textarea { width: 95%; padding: 8px; border-radius: 5px; border: 1px solid #aaa; }
        button { padding: 8px 16px; border: none; border-radius: 6px; background: #007bff; color: white; cursor: pointer; }
        button:hover { background: #0056b3; }
        
        /* Modal Styling */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 999; 
            padding-top: 100px; 
            left: 0; top: 0; width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: white;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            width: 40%;
            box-shadow: 0 0 10px gray;
        }
        .close {
            color: red;
            float: right;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
<a href="logout.php" class="logout">Logout</a>
<h2 style="text-align:center;">Welcome, <?php echo $_SESSION['username']; ?> (<?php echo ucfirst($role); ?>)</h2>

<?php if ($role == 'admin'): ?>
<div class="admin-form">
    <h3>Add New Event</h3>
    <form method="POST">
        <input type="text" name="club" placeholder="Club Name (e.g., GDSC, IEEE)" required><br><br>
        <input type="text" name="title" placeholder="Event Title" required><br><br>
        <input type="date" name="date" required><br><br>
        <textarea name="description" placeholder="Description" rows="3"></textarea><br><br>
        <input type="text" name="form_link" placeholder="Registration Form Link (optional)"><br><br>
        <button type="submit" name="add_event">Add Event</button>
    </form>
</div>
<?php endif; ?>

<table>
    <tr>
        <th>Club</th>
        <th>Date</th>
        <th>Event</th>
        <th>Description</th>
        <th>Registration</th>
        <?php if ($role == 'admin') echo "<th>Action</th>"; ?>
    </tr>

    <?php
    $res = $conn->query("SELECT * FROM events ORDER BY date ASC");
    while ($row = $res->fetch_assoc()) {
        echo "<tr id='row{$row['id']}'>
                <td>{$row['club']}</td>
                <td>{$row['date']}</td>
                <td>{$row['title']}</td>
                <td>{$row['description']}</td>
                <td>";
        if (!empty($row['form_link'])) {
            echo "<a href='{$row['form_link']}' target='_blank'>Register</a>";
        } else {
            echo "No Link";
        }
        echo "</td>";

        if ($role == 'admin') {
    echo "<td>
            <button style='background:#007bff;color:white;border:none;padding:6px 12px;border-radius:5px;cursor:pointer;margin-right:5px;'
                onclick=\"openEditModal({$row['id']}, '{$row['club']}', '{$row['title']}', '{$row['date']}', '".htmlspecialchars($row['description'], ENT_QUOTES)."', '{$row['form_link']}')\">
                Edit
            </button>
            <button style='background:#ff4d4d;color:white;border:none;padding:6px 12px;border-radius:5px;cursor:pointer;'
                onclick=\"if(confirm('Delete this event?')) window.location='?delete={$row['id']}';\">
                Delete
            </button>
          </td>";
}

        echo "</tr>";
    }
    ?>
</table>

<!-- ✅ Edit Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Edit Event</h3>
    <form id="editForm">
      <input type="hidden" name="event_id" id="edit_id">
      <input type="text" name="club" id="edit_club" placeholder="Club" required><br><br>
      <input type="text" name="title" id="edit_title" placeholder="Title" required><br><br>
      <input type="date" name="date" id="edit_date" required><br><br>
      <textarea name="description" id="edit_description" rows="3"></textarea><br><br>
      <input type="text" name="form_link" id="edit_link" placeholder="Registration Link"><br><br>
      <button type="submit">Update Event</button>
    </form>
  </div>
</div>

<script>
function openEditModal(id, club, title, date, desc, link) {
    document.getElementById("editModal").style.display = "block";
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_club").value = club;
    document.getElementById("edit_title").value = title;
    document.getElementById("edit_date").value = date;
    document.getElementById("edit_description").value = desc;
    document.getElementById("edit_link").value = link;
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
}

// ✅ Handle AJAX Update
document.getElementById("editForm").addEventListener("submit", function(e){
    e.preventDefault();
    let formData = new FormData(this);
    formData.append("ajax_update", true);

    fetch("club_home.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {
            alert("Event updated successfully!");
            location.reload();
        } else {
            alert("Update failed!");
        }
    });
});
</script>

</body>
</html>
