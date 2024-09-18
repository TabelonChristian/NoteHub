<?php
session_start();

// Include the database connection file
include 'dbconnection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user_id from the session
$user_id = $_SESSION['user_id'];

// Connect to the database using the connectDB() function
$pdo = connectDB();

if ($pdo === null) {
    // Handle database connection error
    echo "Failed to connect to the database.";
    exit();
}

// Fetch notes from the database
$stmt = $pdo->prepare("SELECT * FROM notetable WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notepad Dashboard</title>
    <link rel="stylesheet" href="Css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="whole-container">
        <div class="main-content">
            <div class="sidebar">
                <div class="menu">
                    <div class="header">
                        <a href="dashboard.php">Note<span class="Orange">hub</span></a>        
                    </div>
                    <div class="togglebar">
                        <button><i class='bx bxs-notepad'></i>All Notes</button>
                        <button><i class='bx bxs-heart'></i>Favorites</button>
                        <button><i class='bx bxs-archive' ></i>Archives</button>
                    </div>
                </div>
                <div class="logout">
                    <div class="profile-picture">
                        <img src="Image/Bg.avif" alt="" id="profile">
                    </div>
                    <div class="options" id="options">
                        <button class="option"><i class='bx bxs-user-account' ></i>Account</button>
                        <a href="logout.php" class="option"><i class='bx bxs-log-out'></i>Logout</a>
                    </div>
                </div>
            </div>
            <div class="notes-container">
                <div class="container">
                    <div class="addnote" title="Create Note" id="addNoteButton">
                        <span class="addCon"><i class='bx bx-plus'></i>Add new note</span>
                    </div>
                    <div class="overlay" id="overlay"></div>
                    <div class="modal-box" id="modalBox">
                        <form id="myForm" class="modal-form" action="addnote.php" method="POST">
                            <div class="navigate">
                                <a href="dashboard.php"><i class='bx bx-arrow-back'></i></a>
                                <div class="nav2">
                                    <div class="favo"><i class='bx bxs-heart' title="Add to Favorites"></i></div>
                                    <button type="submit" class="check"><i class='bx bx-check'></i></button>
                                </div>
                            </div>
                            <input type="text" name="formTitle" id="formTitle" placeholder="Title">
                            <textarea id="description" name="description" rows="10" cols="100" placeholder="Start typing..."></textarea><br><br>
                        </form>
                    </div>
                    <?php foreach ($notes as $note): ?>
                    <div class="listnote">
                        <div class="title">
                            <p><?php echo $note['note_title']; ?></p>
                        </div>
                        <div class="description">
                            <p><?php echo $note['note_desc']; ?></p>
                        </div>
                        <div class="stat">
                            <div class="date"><?php echo $note['note_date']; ?></div>
                            <div class="sett" id="settings">
                                <div class="opt">
                                    <div class="fav">
                                        <i class='bx bxs-heart'  title="Add to Favorites"></i>
                                   </div>
                                    <div class="setts">
                                        <i class='bx bx-dots-horizontal-rounded' title="Settings" id="setts"></i>
                                    </div>
                                </div>
                                <div class="options-menu" id="menus">
                                    <div class="mens">
                                        <button onclick="showEditOverlay(<?php echo $note['note_id']; ?>)"><i class='bx bx-edit-alt' ></i>Edit</button>
                                        <form action="deletenote.php" method="post">
                                            <input type="hidden" name="note_id" value="<?php echo $note['note_id']; ?>">
                                            <button type="submit"><i class='bx bx-trash'></i>Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
            </div>
        </div>
    </div>

    <div class="overlay" id="editOverlay"></div>
    <div class="modal-box" id="editModalBox">
    <form id="editForm" class="modal-form" action="editnote.php" method="POST">
        <div class="navigate">
            <a href="dashboard.php"><i class='bx bx-arrow-back'></i></a>
            <div class="nav2">
                <div class="favo"><i class='bx bxs-heart' title="Add to Favorites"></i></div>
                <button type="submit" class="check"><i class='bx bx-check'></i></button>
            </div>
        </div>
        <input type="hidden" name="note_id" id="editNoteId" value="">
        <input type="text" name="editFormTitle" id="editFormTitle" placeholder="Title">
        <textarea id="editDescription" name="editDescription" rows="10" cols="100" placeholder="Start typing..."></textarea><br><br>
    </form>
    </div>

    <script src="Jsscript/dashboard.js"></script>
</body>
</html>