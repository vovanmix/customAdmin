<?php
/**
 * @var array $categories;
 * @var \Vovanmix\CustomAdmin\Models\Product $product
 */
?><h1 class="page-header">Product <?=$product?></h1>
<form method="post">

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?=$product->getName();?>">
    </div>

    <div class="form-group">
        <label for="category_id">Category</label>
        <select class="form-control" name="category_id" id="category_id">
            <option <?php if(empty($product->getCategory_id())){ ?>selected="selected"<?php } ?> value="">No category</option>
            <?php foreach($categories as $categoryItem){ ?>
                <?php /**@var \Vovanmix\CustomAdmin\Models\Category $categoryItem*/ ?>
                <option <?php if($product->getCategory_id() == $categoryItem->getId()){ ?>selected="selected"<?php } ?> value="<?=$categoryItem->getId();?>"><?=$categoryItem->getName();?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="text">Text description</label>
        <textarea class="form-control" id="text" name="text"><?=$product->getText();?></textarea>
    </div>

    <!--
    <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" id="exampleInputFile">
        <p class="help-block">Example block-level help text here.</p>
      </div>
      -->

    <input type="submit" class="btn btn-default"/>
    <button class="btn btn-default" onclick="history.back()">Cancel</button>
</form>