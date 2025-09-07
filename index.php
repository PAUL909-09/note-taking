<?php
require_once 'includes/functions.php';
$notes = getNotes();
?>
<?php include 'includes/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h1>My Notes</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="create.php" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Create New Note
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($notes)): ?>
            <div class="alert alert-info">
                <h4>No notes found</h4>
                <p>Get started by creating your first note!</p>
                <a href="create.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Create Your First Note
                </a>
            </div>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($notes as $note): ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo htmlspecialchars($note['title']); ?></h5>
                            <small><?php echo date('M d, Y', strtotime($note['updated_at'])); ?></small>
                        </div>
                        <p class="mb-1"><?php echo substr(htmlspecialchars($note['content']), 0, 100) . '...'; ?></p>
                        <?php if ($note['image_path']): ?>
                            <img src="<?php echo htmlspecialchars($note['image_path']); ?>" class="img-thumbnail" style="max-width: 100px;">
                        <?php endif; ?>
                        <div class="mt-2">
                            <a href="view.php?id=<?php echo $note['id']; ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="edit.php?id=<?php echo $note['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="delete.php?id=<?php echo $note['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                            <a href="export.php?id=<?php echo $note['id']; ?>&type=pdf" class="btn btn-sm btn-info">
                                <i class="bi bi-file-pdf"></i> PDF
                            </a>
                            <a href="export.php?id=<?php echo $note['id']; ?>&type=word" class="btn btn-sm btn-secondary">
                                <i class="bi bi-file-word"></i> Word
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<!-- Add this before the footer include -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
    <a href="create.php" class="btn btn-primary rounded-circle p-3" title="Create New Note">
        <i class="bi bi-plus-lg" style="font-size: 1.5rem;"></i>
    </a>
</div>