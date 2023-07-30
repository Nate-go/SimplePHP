<!DOCTYPE html>
<html>
<head>
    <title>Category Infomation</title>
    <style>
          <?php require_once 'css/infoItem.css'; ?>
      </style>
</head>
<body>
    <div class="container">
        <h1>Category Infomation</h1>
        <div class="header">
                <div class="header-left">
                    <a class="btn" href="<?php echo str_replace('{id}', 'null', $routes->get('addItem')->getPath()) ?>">Add Item</a>
                </div>
                <div class="header-right">
                    <a class="btn" href="<?php echo $routes->get('loadHome')->getPath() ?>">Home</a>
                </div>
            </div>
        <form id="addProductForm" action="<?php echo $id?>" method="post">
            <label for="title">Content</label>
            <input class='input' type="text" name="content" id="content" required value="<?php echo htmlspecialchars($category->getContent()); ?>">
            <br>
            <input class="btn" type="submit" value=Save>
        </form>
    </div>
</body>
</html>