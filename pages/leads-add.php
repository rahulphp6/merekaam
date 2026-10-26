<!-- Customer & Contact -->
<div class="col-md-6 mb-3">
  <?php renderDropdown('project_id', 'projects'); ?>
</div>
<!-- Job Type & Commodity -->
<div class="col-md-6 mb-3">
  <?php renderDropdown('lead', 'leads', 'Lead'); ?>
</div>
<?php include_once 'crud/canvas.php'; ?>