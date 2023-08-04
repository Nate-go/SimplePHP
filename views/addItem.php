<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
    <style>
          <?php require_once 'css/infoItem.css'; ?>
      </style>
</head>
<body>
    <div class="container">
    <h1>Add Item</h1>
    <div class="header">
            <div class="header-left">
                <a class="btn" href="<?php echo $routes->get('loadAddCategory')->getPath() ?>">Add Category</a>
            </div>
            <div class="header-right">
            <a class="btn" href="<?php echo $routes->get('loadHome')->getPath() ?>">Home</a>
            </div>
        </div>
    
    <form id="addProductForm" action="<?php echo $id?>" method="post">
        <label for="title">Title</label>
        <input class='input' type="text" name="title" id="title" required>
        <br>

        <label for="content">Content</label>
        <textarea class='textarea' name="content" id="content"></textarea>
        <br>

        <label for="category">Category</label>
        <select name="category" id="category" required>
                <?php
                        $html = '';
                        foreach ($allCategories as $category) {
                            if($id !== 'null') {
                                $html .= '<option value="' . htmlspecialchars($parentItem->getCategoryId()) . ' selected">' . htmlspecialchars($categories[$parentItem->getCategoryId()]) . '</option>';
                                break;
                            }
                            $categoryId = $category->getId();
                            $categoryContent = $category->getContent();
                            $selected = ($categoryId === $parentItem->getCategoryId()) ? 'selected' : '';
                            $html .= '<option value="' . htmlspecialchars($categoryId) . '" ' . $selected . '>' . htmlspecialchars($categoryContent) . '</option>';
                        }
                    echo $html;
                ?>
        </select>
        <br>

        <label for="status">Status</label>
        <select name="status" id="status" required>
                <option value=0>TODO</option>
                <option value=1>INPROGRESS</option>
                <option value=2>COMPLETE</option>
                <option value=3>POSTPONE</option>
        </select>
        <br>

        <label for="finishedTime">Finish Time</label>
        <input class='input' type="date" name="finishedTime" id="finishedTime" required>
        <br>
        <input class="btn" type="submit" value="Add">
    </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var startDateInput = document.getElementById("finishedTime");

            var today = new Date().toISOString().split('T')[0];
            var max = <?php echo '"' . $parentItem->getFinishTime() . '";'?>

            startDateInput.setAttribute("min", today);
            if(max !== 'null') {
                startDateInput.setAttribute("max", max);
            }
        })
</script>
</body>
</html>