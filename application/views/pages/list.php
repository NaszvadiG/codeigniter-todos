<?php echo anchor('todos/add_edit', 'Add a todo'); ?>
<?php foreach ($todos as $todo): ?>
    <div>
        <span><?= $todo->title; ?></span><?php echo anchor('todos/add_edit/' . $todo->id, 'Edit'); ?> | <?php echo anchor('todos/delete/' . $todo->id, 'Delete'); ?>
    </div>
<?php endforeach; ?>