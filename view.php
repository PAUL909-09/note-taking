<?php
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$note = getNoteById($_GET['id']);

if (!$note) {
    header('Location: index.php');
    exit;
}
?>
<?php include 'includes/header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4"><?php echo htmlspecialchars($note['title']); ?></h1>
        <div class="note-content">
            <?php echo nl2br(htmlspecialchars($note['content'])); ?>
        </div>
        <?php if ($note['image_path']): ?>
            <div class="mt-3">
                <img src="<?php echo htmlspecialchars($note['image_path']); ?>" class="img-fluid" alt="Note Image">
            </div>
        <?php endif; ?>
        <div class="mt-4">
            <a href="edit.php?id=<?php echo $note['id']; ?>" class="btn btn-warning">Edit</a>
            <a href="delete.php?id=<?php echo $note['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            <a href="export.php?id=<?php echo $note['id']; ?>&type=pdf" class="btn btn-info">Export PDF</a>
            <a href="export.php?id=<?php echo $note['id']; ?>&type=word" class="btn btn-secondary">Export Word</a>
        </div>
        <div class="mt-3">
            <small>Created: <?php echo date('M d, Y H:i', strtotime($note['created_at'])); ?></small><br>
            <small>Last updated: <?php echo date('M d, Y H:i', strtotime($note['updated_at'])); ?></small>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>