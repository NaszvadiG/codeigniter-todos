<?php if ($this->session->flashdata('success')): ?>
    <div><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>


<?php echo anchor('todos/add_edit', 'Add a todo'); ?>
<?php foreach ($todos as $todo): ?>
    <div>
        <span><?= $todo->title; ?></span><?php echo anchor('todos/add_edit/' . $todo->id, 'Edit'); ?> | <?php echo anchor('todos/delete/' . $todo->id, 'Delete'); ?>
    </div>
<?php endforeach; ?>