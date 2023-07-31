<!DOCTYPE html>
<html>
<head>
    <title>Item Infomation</title>
    <style>
          <?php require_once 'css/infoItem.css'; ?>
      </style>
</head>
<body>
    <div class="container">
        <h1>Item Infomation</h1>
        <div class="header">
            <div class="header-left">
                <a class="btn" href="<?php echo str_replace('{id}', $mainItem->getId(), $routes->get('loadAddItem')->getPath()) ?>">Add Child</a>
                <a class="btn" href="<?php echo $routes->get('loadAddCategory')->getPath() ?>">Add Category</a>
            </div>
            <div class="header-right">
                <a class="btn" href="<?php echo $routes->get('loadHome')->getPath() ?>">Home</a>
            </div>
        </div>

        <div class="tab">
            <button class="tablinks active" onclick="openTab(event, 'tab1')">Item's Infomation</button>
            <button class="tablinks" onclick="openTab(event, 'tab2')">Childs Item</button>
            <button class="tablinks" onclick="openTab(event, 'tab3')">Parent Item</button>
        </div>

        <div id="tab1" class="tabcontent" style="display: block;">
            <form id="addProductForm" action="<?php echo $id ?>" method="post">
                <label for="title">Title</label>
                <input class='input' type="text" name="title" id="title" required value="<?php echo htmlspecialchars($mainItem->getTitle()); ?>">
                <br>

                <label for="content">Content</label>
                <textarea class='textarea' name="content" id="content"><?php echo htmlspecialchars($mainItem->getContent()); ?></textarea>
                <br>

                <label for="category">Category</label>
                <select name="category" id="category" required>
                    <?php
                        foreach ($allCategories as $category) {
                            $categoryId = $category->getId();
                            $categoryContent = $category->getContent();
                            $selected = ($categoryId === $mainItem->getCategoryId()) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($categoryId) . '" ' . $selected . '>' . htmlspecialchars($categoryContent) . '</option>';
                        }
                    ?>
                </select>
                <br>

                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <?php
                        $statusOptions = array(
                            array('value' => 0, 'text' => 'TODO'),
                            array('value' => 1, 'text' => 'INPROGRESS'),
                            array('value' => 2, 'text' => 'COMPLETE'),
                            array('value' => 3, 'text' => 'POSTPONE')
                        );

                        foreach ($statusOptions as $option) {
                            $statusValue = $option['value'];
                            $statusText = $option['text'];
                            $selected = ($statusValue == $mainItem->getStatus()) ? 'selected' : '';

                            echo '<option value="' . htmlspecialchars($statusValue) . '" ' . $selected . '>' . htmlspecialchars($statusText) . '</option>';
                        }
                    ?>
                </select>
                <br>

                <label for="finishedTime">Finish Time</label>
                <input class='input' type="date" name="finishTime" id="finishTime" value="<?php echo htmlspecialchars($mainItem->getFinishTime()); ?>">
                <br>

                <input class="btn" type="submit" value="Save">
            </form>
        </div>

        <div id="tab2" class="tabcontent">
            <table class="task-table" id="table1">
                <tr>
                    <th>Title</th>
                    <th>Update Date</th>
                    <th>Finish Date</th>
                    <th>Status :
                        <select onchange="filterTableByStatus('table2')">
                            <option value='ALL'>ALL</option>
                            <option value='TODO'>TODO</option>
                            <option value='INPROGRESS'>INPROGRESS</option>
                            <option value='COMPLETE'>COMPLETE</option>
                            <option value='POSTPONE'>POSTPONE</option>
                        </select>
                    </th>
                    <th>Action</th>
                </tr>
                <?php
                        $html = '';
                        foreach ($subItems as $item) {
                            $html .= '<tr>';
                            $html .= '<td>' . $item->getTitle() . '</td>';
                            $html .= '<td>' . $item->getUpdateTime() . '</td>';
                            $html .= '<td>' . $item->getFinishTime() . '</td>';
                            $html .= '<td>' . STATUS[$item->getStatus()] . '</td>';
                            $html .= '<td>';
                            $html .= '<a class="delete-btn" onclick="postForm(0, ' . $item->getId() . ')">Delete</a>';
                            $html .= '<a class="edit-btn" href="' . str_replace('{id}', $item->getId(), $routes->get('loadInfoItem')->getPath()) . '">Edit</a>';
                            $html .= '</td>';
                            $html .= '</tr>';
                        }
                    echo $html;
                ?>
            </table>
        </div>

        <form id="postForm" action="" method="POST" hidden>
            <input id="model" name="model" value="">
            <input id="id" name="id" value="">
        </form>

        <div id="tab3" class="tabcontent">
            <?php
                if ($parentItems[0]->getId() != null) {
                    echo '<table class="task-table" id="table2">';
                    echo '<tr>';
                    echo '<th>Title</th>';
                    echo '<th>Update Date</th>';
                    echo '<th>Finish Date</th>';
                    echo '<th>Status :
                            <select onchange="filterTableByStatus(\'table2\')">
                                <option value=\'ALL\'>ALL</option>
                                <option value=\'TODO\'>TODO</option>
                                <option value=\'INPROGRESS\'>INPROGRESS</option>
                                <option value=\'COMPLETE\'>COMPLETE</option>
                                <option value=\'POSTPONE\'>POSTPONE</option>
                            </select>
                        </th>';
                    echo '<th>Action</th>';
                    echo '</tr>';

                    foreach ($parentItems as $item) {
                        echo '<tr>';
                        echo '<td>' . $item->getTitle() . '</td>';
                        echo '<td>' . $item->getUpdateTime() . '</td>';
                        echo '<td>' . $item->getFinishTime() . '</td>';
                        echo '<td>' . STATUS[$item->getStatus()] . '</td>';
                        echo '<td>';
                        echo '<a class="delete-btn" onclick="postForm(0, ' . $item->getId() . ')">Delete</a>';
                        echo '<a class="edit-btn" href="' . str_replace('{id}', $item->getId(), $routes->get('loadInfoItem')->getPath()) . '">Edit</a>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    echo '<p>No parent items</p>';
                }
            ?>
        </div>
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

        function filterTableByStatus(tableId) {
            var statusFilter = document.querySelector('#' + tableId + ' select');
            
            var selectedStatus = statusFilter.value;
            
            var rows = document.querySelectorAll('#' + tableId + ' tr');
            
            if (selectedStatus === 'ALL') {
                for (var i = 0; i < rows.length; i++) {
                    rows[i].style.display = 'table-row';
                }
            } else {
                for (var i = 1; i < rows.length; i++) {
                    var rowStatus = rows[i].querySelector('td:nth-child(4)').innerHTML;
                    
                    if (rowStatus !== selectedStatus) {
                        rows[i].style.display = 'none';
                    } else {
                        rows[i].style.display = 'table-row';
                    }
                }
            }
        }

        function postForm(model, id){
            document.getElementById('id').value = id;
            document.getElementById('model').value = model;
            form = document.getElementById("postForm");
            form.submit();
        }
    </script>
</body>
</html>
