<?php
    /** @var $plant ?\App\Model\Plant */
?>

<div class="form-group">
    <label for="type">Type</label>
    <input type="text" id="type" name="plant[type]" value="<?= $plant ? $plant->getType() : '' ?>">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" name="plant[content]"><?= $plant? $plant->getContent() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
