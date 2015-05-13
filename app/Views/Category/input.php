<?php
/**
 * @var array $categories;
 * @var \Vovanmix\CustomAdmin\Models\Category $category
 */
?><h1 class="page-header">Category <?=$category?></h1>
<form method="post">

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?=$category->getName();?>">
    </div>

    <div class="form-group">
        <label for="parent_id">Parent Category</label>
        <select class="form-control" name="parent_id" id="parent_id">
            <option <?php if(empty($category->getParent_id())){ ?>selected="selected"<?php } ?> value="">No parent</option>
            <?php foreach($categories as $categoryItem){ ?>
                <?php /**@var \Vovanmix\CustomAdmin\Models\Category $categoryItem*/ ?>
                <option <?php if($category->getParent_id() == $categoryItem->getId()){ ?>selected="selected"<?php } ?> value="<?=$categoryItem->getId();?>"><?=$categoryItem->getName();?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="text">Text description</label>
        <textarea class="form-control" id="text" name="text"><?=$category->getText();?></textarea>
    </div>

    <input type="submit" class="btn btn-default"/>
    <button class="btn btn-default" onclick="history.back()">Cancel</button>
</form>