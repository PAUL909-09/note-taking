<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'includes/functions.php';

// Debug: Check if ID is passed
if (!isset($_GET['id'])) {
    die("Error: No note ID provided");
}

$id = $_GET['id'];
echo "<!-- Debug: Note ID = " . htmlspecialchars($id) . " -->";

$note = getNoteById($id);

// Debug: Check if note was found
if (!$note) {
    die("Error: Note not found in database");
} else {
    echo "<!-- Debug: Note found: " . htmlspecialchars($note['title']) . " -->";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Check if POST data is being received
    echo "<!-- Debug: POST data received -->";
    echo "<!-- Debug: Title = " . htmlspecialchars($_POST['title']) . " -->";
    echo "<!-- Debug: Content = " . htmlspecialchars($_POST['content']) . " -->";
    
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = $note['image_path']; // Keep existing image by default
    
    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        echo "<!-- Debug: New image uploaded -->";
        
        // Delete old image if exists
        if ($note['image_path'] && file_exists($note['image_path'])) {
            unlink($note['image_path']);
        }
        $imagePath = handleImageUpload($_FILES['image']);
    }
    
    // Handle image removal
    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'on') {
        echo "<!-- Debug: Remove image checked -->";
        if ($note['image_path'] && file_exists($note['image_path'])) {
            unlink($note['image_path']);
        }
        $imagePath = null;
    }
    
    // Debug: Check update result
    $updateResult = updateNote($id, $title, $content, $imagePath);
    echo "<!-- Debug: Update result = " . ($updateResult ? 'true' : 'false') . " -->";
    
    if ($updateResult) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Failed to update note.";
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">Edit Note</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="edit.php?id=<?php echo htmlspecialchars($id); ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($note['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($note['content']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <div class="form-text">Or drag and drop an image below</div>
            </div>
            <?php if ($note['image_path']): ?>
                <div class="mb-3">
                    <p>Current Image:</p>
                    <img src="<?php echo htmlspecialchars($note['image_path']); ?>" class="img-thumbnail" style="max-width: 200px;">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image">
                        <label class="form-check-label" for="remove_image">Remove current image</label>
                    </div>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <div class="drop-area" id="dropArea">
                    <p>Drag and drop image here</p>
                </div>
                <div id="imagePreview" class="mt-3"></div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Note</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>