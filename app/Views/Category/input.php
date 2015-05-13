<?
/**
 * @var array $categories;
 * @var \Vovanmix\CustomAdmin\Models\Category $category
 */
?><h1>Category</h1>
<form method="post">

    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?=$category->getName();?>">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Parent Category</label>
        <select class="form-control" name="parent_id">
            <option <? if(empty($category->getParent_id())){ ?>selected="selected"<? } ?> value="">No parent</option>
            <? foreach($categories as $categoryItem){ ?>
                <? /**@var \Vovanmix\CustomAdmin\Models\Category $categoryItem*/ ?>
                <option <? if($category->getParent_id() == $categoryItem->getId()){ ?>selected="selected"<? } ?> value="<?=$categoryItem->getId();?>"><?=$categoryItem->getName();?></option>
            <? } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Text description</label>
        <textarea class="form-control" id="text" name="text"><?=$category->getText();?></textarea>
    </div>

    <!--
    <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" id="exampleInputFile">
        <p class="help-block">Example block-level help text here.</p>
      </div>
      -->

    <input type="submit" class="btn btn-default"/>
</form>