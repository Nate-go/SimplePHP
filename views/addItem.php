<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
    <style>
          <?php require_once 'css/addItem.css'; ?>
      </style>
</head>
<body>
    <h1>Add Item</h1>
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
                        foreach ($allCategories as $item) {
                            $html .= '<option value=' . $item->getId() . '>' . $item->getContent() . '</option>';
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
        <input class='input' type="datetime-local" name="finishedTime" id="finishedTime" required>
        <br>
        <input class="btn" type="submit" value="Add">
    </form>
</body>
</html>