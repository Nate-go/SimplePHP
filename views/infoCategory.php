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
                    <a class="btn" href="<?php echo str_replace('{id}', 'null', $routes->get('loadAddItem')->getPath()) ?>">Add Item</a>
                </div>
                <div class="header-right">
                    <a class="btn" href="<?php echo $routes->get('loadHome')->getPath() ?>">Home</a>
                </div>
            </div>

        <div class="tab">
            <button class="tablinks active" onclick="openTab(event, 'tab1')">Infomation</button>
            <button class="tablinks" onclick="openTab(event, 'tab2')">Items follow</button>
        </div>    
        <div id="tab1" class="tabcontent" style="display: block;">
            <form id="addProductForm" action="<?php echo $id?>" method="post">
                <label for="title">Content</label>
                <input class='input' type="text" name="content" id="content" required value="<?php echo htmlspecialchars($category->getContent()); ?>">
                <br>
                <input class="btn" type="submit" value=Save>
            </form>
        </div>

        <div id="tab2" class="tabcontent">
            <div class="roll-table">
                <table class="task-table" id="table2">
                <tr>
                        <th>Title</th>
                        <th>Update Date</th>
                        <th>Finish Date</th>
                        <th>Status : 
                            <select name='status' onchange="filterTable('table2')">
                                <option value='ALL'>ALL</option>
                                <option value='TODO'>TODO</option>
                                <option value='INPROGRESS'>INPROGRESS</option>
                                <option value='COMPLETE'>COMPLETE</option>
                                <option value='POSTPONE'>POSTPONE</option>
                            </select>
                        </th>
                        <th>Category : 
                            <select name='category' onchange="filterTable('table2')">
                                <option value='ALL'>ALL</option>
                                <?php
                                    foreach ($allCategories as $category) {
                                        $categoryContent = $category->getContent();
                                        echo '<option value="' . htmlspecialchars($categoryContent) . '" ' . '>' . htmlspecialchars($categoryContent) . '</option>';
                                    }
                                ?>
                            </select>
                        </th>
                        <th>Action</th>
                    </tr>
                    <?php
                            $html = '';
                            foreach ($allItems as $item) {
                                $html .= '<tr>';
                                $html .= '<td>' . $item->getTitle() . '</td>';
                                $html .= '<td>' . $item->getUpdateTime() . '</td>';
                                $html .= '<td>' . $item->getFinishTime() . '</td>';
                                $html .= '<td>' . STATUS[$item->getStatus()] . '</td>';
                                $html .= '<td>' . $categories[$item->getCategoryId()] . '</td>';
                                $html .= '<td>';
                                $html .= '<a class="delete-btn" onclick="postForm(0, ' . $item->getId() . ')">Delete</a>';
                                $html .= '<a class="edit-btn" href="' . str_replace('{id}', $item->getId(), $routes->get('loadInfoItem')->getPath()) . '">Edit</a>';
                                $html .= '<a class="finish-btn" onclick="postForm(2, ' . $item->getId() . ')">Finish</a>';
                                $html .= '</td>';
                                $html .= '</tr>';
                            }
                        echo $html;
                    ?>
                </table>
            </div>
        </div>
        <form id="postForm" action="" method="POST">
            <input style='display:none;' id="model" name="model" value="">
            <input style='display:none;' id="id" name="id" value="">
        </form>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function filterTable(tableId) {
            var statusFilter = document.querySelector('#' + tableId + ' select[name="status"]');
            var selectedStatus = statusFilter.value;

            var categoryFilter = document.querySelector('#' + tableId + ' select[name="category"]');
            var selectedCategory = categoryFilter.value;

            var rows = document.querySelectorAll('#' + tableId + ' tr');
            
            for (var i = 1; i < rows.length; i++) {
                var rowStatus = rows[i].querySelector('td:nth-child(4)').innerHTML;
                var rowCategory = rows[i].querySelector('td:nth-child(5)').innerHTML;

                if ((rowStatus === selectedStatus || selectedStatus === 'ALL') && (rowCategory === selectedCategory || selectedCategory === 'ALL')) {
                    rows[i].style.display = 'table-row';
                } else {
                    rows[i].style.display = 'none';
                }
            }
            
        }

        function postForm(model, id){
            var actionText = "";
            switch(model) {
                case 0:
                    actionText = "delete this item ? ";
                    break;
                case 1:
                    actionText = "delete this category ? it also delete all item fllow";
                    break;
                case 2:
                    actionText = "finish this item ? it and all children (if have) will be COMPLETE";
                    break;
                }
            var confirmationMessage = "Are you sure you want to " + actionText;

            if (window.confirm(confirmationMessage)) {
                document.getElementById('id').value = id;
                document.getElementById('model').value = model;
                form = document.getElementById("postForm");
                form.submit();
            } 
        }
    </script>
</body>
</html>