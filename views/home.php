<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <style>
          <?php require_once 'css/styles.css'; ?>
      </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <a class="btn" href="<?php echo str_replace('{id}', 'null', $routes->get('addItem')->getPath()) ?>">Add Child</a>
                <a class="btn" href="<?php echo $routes->get('addCategory')->getPath() ?>">Add Category</a>
            </div>
            <div class="header-right">
                <button class="btn">Search</button>
                <input type="text" class="search-bar" placeholder="Search...">
            </div>
        </div>

        <div class="tab">
            <button class="tablinks active" onclick="openTab(event, 'tab1')">Today</button>
            <button class="tablinks" onclick="openTab(event, 'tab2')">All</button>
            <button class="tablinks" onclick="openTab(event, 'tab3')">Category</button>
        </div>

        <div id="tab1" class="tabcontent" style="display: block;">
            <div class="roll-table">
                <table class="task-table" id="table1">
                    <tr>
                        <th>Title</th>
                        <th>Update Date</th>
                        <th>Finish Date</th>
                        <th>Status : 
                            <select onchange="filterTableByStatus('table1')">
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
                            foreach ($todayItems as $item) {
                                $html .= '<tr>';
                                $html .= '<td>' . $item->getTitle() . '</td>';
                                $html .= '<td>' . $item->getUpdateTime() . '</td>';
                                $html .= '<td>' . $item->getFinishTime() . '</td>';
                                $html .= '<td>' . STATUS[$item->getStatus()] . '</td>';
                                $html .= '<td>';
                                $html .= '<a class="delete-btn" onclick="postForm(0, ' . $item->getId() . ')">Delete</a>';
                                $html .= '<a class="edit-btn" href="' . str_replace('{id}', $item->getId(), $routes->get('infoItem')->getPath()) . '">Edit</a>';
                                $html .= '</td>';
                                $html .= '</tr>';
                            }
                        echo $html;
                    ?>
                </table>
            </div>
        </div>

        <div id="tab2" class="tabcontent">
            <div class="roll-table">
                <table class="task-table" id="table2">
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
                            foreach ($allItems as $item) {
                                $html .= '<tr>';
                                $html .= '<td>' . $item->getTitle() . '</td>';
                                $html .= '<td>' . $item->getUpdateTime() . '</td>';
                                $html .= '<td>' . $item->getFinishTime() . '</td>';
                                $html .= '<td>' . STATUS[$item->getStatus()] . '</td>';
                                $html .= '<td>';
                                $html .= '<a class="delete-btn" onclick="postForm(0, ' . $item->getId() . ')">Delete</a>';
                                $html .= '<a class="edit-btn" href="' . str_replace('{id}', $item->getId(), $routes->get('infoCategory')->getPath()) . '">Edit</a>';
                                $html .= '</td>';
                                $html .= '</tr>';
                            }
                        echo $html;
                    ?>
                </table>
            </div>
        </div>

        <form id="postForm" action="" method="POST">
            <input id="model" hidden name="model" value="">
            <input id="id" hidden name="id" value="">
        </form>

        <div id="tab3" class="tabcontent">
            <div class="roll-table">
                <table class="task-table">
                    <tr>
                        <th>Content</th>
                        <th>Update Date</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $html = '';
                        foreach ($allCategory as $item) {
                            $html .= '<tr>';
                            $html .= '<td>' . $item->getContent() . '</td>';
                            $html .= '<td>' . $item->getUpdateTime() . '</td>';
                            $html .= '<td>';
                            $html .= '<a class="delete-btn" onclick="postForm(1, ' . $item->getId() . ')">Delete</a>';
                            $html .= '<a class="edit-btn" href="' . str_replace('{id}', $item->getId(), $routes->get('infoItem')->getPath()) . '">Edit</a>';
                            $html .= '</td>';
                            $html .= '</tr>';
                        }
                        echo $html;
                    ?>
                </table>
            </div>
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
