<?php
require_once 'config/database.php';

// Function to get all notes
function getNotes() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM notes ORDER BY updated_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get a single note by ID
function getNoteById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to create a new note
// function createNote($title, $content, $imagePath = null) {
//     global $pdo;
//     $stmt = $pdo->prepare("INSERT INTO notes (title, content, image_path) VALUES (?, ?, ?)");
//     return $stmt->execute([$title, $content, $imagePath]);
// }
function createNote($title, $content, $imagePath = null) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO notes (title, content, image_path) VALUES (?, ?, ?)");
        $result = $stmt->execute([$title, $content, $imagePath]);
        
        // Log the result
        error_log("Note creation result: " . ($result ? 'Success' : 'Failure'));
        if (!$result) {
            error_log("SQL Error: " . print_r($stmt->errorInfo(), true));
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

// Function to update a note
// function updateNote($id, $title, $content, $imagePath = null) {
//     global $pdo;
//     $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, image_path = ? WHERE id = ?");
//     return $stmt->execute([$title, $content, $imagePath, $id]);
// }

// function updateNote($id, $title, $content, $imagePath = null) {
//     global $pdo;
    
//     // Debug: Check function parameters
//     error_log("Debug updateNote: ID = $id, Title = $title, ImagePath = $imagePath");
    
//     $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, image_path = ? WHERE id = ?");
//     $result = $stmt->execute([$title, $content, $imagePath, $id]);
    
//     // Debug: Check SQL execution result
//     error_log("Debug updateNote: SQL execution result = " . ($result ? 'true' : 'false'));
//     error_log("Debug updateNote: SQL Error = " . print_r($stmt->errorInfo(), true));
    
//     return $result;
// }
function updateNote($id, $title, $content, $imagePath = null) {
    global $pdo;
    
    // Debug: Log function parameters
    error_log("Debug updateNote: ID = $id, Title = $title, ImagePath = $imagePath");
    
    try {
        $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, image_path = ? WHERE id = ?");
        $result = $stmt->execute([$title, $content, $imagePath, $id]);
        
        // Debug: Check SQL execution result
        error_log("Debug updateNote: SQL execution result = " . ($result ? 'true' : 'false'));
        if (!$result) {
            $errorInfo = $stmt->errorInfo();
            error_log("Debug updateNote: SQL Error = " . print_r($errorInfo, true));
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Debug updateNote: PDO Exception = " . $e->getMessage());
        return false;
    }
}

// Function to delete a note
function deleteNote($id) {
    global $pdo;
    // Get image path before deletion
    $note = getNoteById($id);
    if ($note && $note['image_path'] && file_exists($note['image_path'])) {
        unlink($note['image_path']);
    }
    
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
    return $stmt->execute([$id]);
}

// Function to handle image upload
// function handleImageUpload($file) {
//     $targetDir = "assets/images/";
//     $targetFile = $targetDir . basename($file["name"]);
//     $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
//     // Check if image file is actual image
//     $check = getimagesize($file["tmp_name"]);
//     if ($check === false) {
//         return false;
//     }
    
//     // Check file size (5MB limit)
//     if ($file["size"] > 5000000) {
//         return false;
//     }
    
//     // Allow certain file formats
//     if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//         return false;
//     }
    
//     // Generate unique filename
//     $targetFile = $targetDir . uniqid() . "." . $imageFileType;
    
//     // Upload file
//     if (move_uploaded_file($file["tmp_name"], $targetFile)) {
//         return $targetFile;
//     }
    
//     return false;
// }
function handleImageUpload($file) {
    $targetDir = "assets/images/";
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    
    // Check if image file is actual image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return false;
    }
    
    // Check file size (5MB limit)
    if ($file["size"] > 5000000) {
        return false;
    }
    
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return false;
    }
    
    // Generate unique filename
    $targetFile = $targetDir . uniqid() . "." . $imageFileType;
    
    // Upload file without conversion if GD is not available
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }
    
    return false;
}
?>