<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/functions.php';
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = null;

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $imagePath = handleImageUpload($_FILES['image']);
    }

    if (createNote($title, $content, $imagePath)) {
        // Check if "Create Another" button was clicked
        if (isset($_POST['create_another'])) {
            header('Location: create.php?success=1');
            exit;
        } else {
            header('Location: success.php');
            exit;
        }
    } else {
        $error = "Failed to create note.";
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">Create New Note</h1>
        <h1 class="mb-4">Create New Note</h1>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Your note was created successfully! You can now create another one.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="create.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <div class="form-text">Or drag and drop an image below</div>
            </div>
            <div class="mb-3">
                <div class="drop-area" id="dropArea">
                    <p>Drag and drop image here</p>
                </div>
                <div id="imagePreview" class="mt-3"></div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" name="save" class="btn btn-primary">Save Note</button>
                <button type="submit" name="create_another" class="btn btn-outline-primary">Save & Create Another</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>