<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = [
    'pageTitle' => 'Users'
];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

// Search form handling
$orderByClause = "ORDER BY users.created_at DESC";
$whereClause = '';
$dataCondition = [];

if (isGet()) {
    $body = getBody();

    if (!empty($body['order_by'])) {
        $field = trim($body['order_by']);
        $orderByClause = "ORDER BY users." . $field;

        if (!empty($body['sort_order'])) {
            $sortOrder = trim($body['sort_order']);
            $orderByClause .= " $sortOrder";
        }
    }

    if (!empty($body['status'])) {
        $status = trim($body['status']);
        if ($status == 1) {
            $dbStatus = 1;
        } elseif ($status == 2) {
            $dbStatus = 0;
        }
        if (isset($dbStatus)) {
            $whereClause .= "WHERE status=:status";
            $dataCondition['status'] = $dbStatus;
        }
    }

    if (!empty($body['group_id'])) {
        $groupId = trim($body['group_id']);
        if (str_contains($whereClause, 'WHERE')) {
            $operator = ' AND';
        } else {
            $operator = 'WHERE';
        }
        $whereClause .= "$operator group_id=:group_id";
        $dataCondition['group_id'] = $groupId;
    }


    if (!empty($body['keyword'])) {
        $keyword = trim($body['keyword']);
        if (str_contains($whereClause, 'WHERE')) {
            $operator = ' AND';
        } else {
            $operator = 'WHERE';
        }
        $whereClause .= "$operator fullname LIKE :pattern";
        $pattern = "%$keyword%";
        $dataCondition['pattern'] = $pattern;
    }
}

// Retrieve group data for  <select name="group_id">
$groups = getAllRows("SELECT id, name FROM `groups`");

// Pagination
// Set the limit of number of records to be displayed per page
$limit = 3;

// Determine the total number of pages available
$sql = "SELECT id FROM users $whereClause";
$totalRows = getNumberOfRows($sql, $dataCondition);
$totalPages = ceil($totalRows / $limit);

// Determine the current page number
if (!empty(getBody()['page'])) {
    $currentPage = getBody()['page'];
    if ($currentPage < 1 || $currentPage > $totalPages) {
        $currentPage = 1;
    }
} else {
    $currentPage = 1;
}

// Calculating the OFFSET from page number
$offset = ($currentPage - 1) * $limit;

// Retrieve data
$columnNames = "users.id, users.fullname, users.email, users.phone, users.created_at, users.status, groups.name AS group_name";
$sql = "SELECT $columnNames FROM users INNER JOIN `groups` ON users.group_id=`groups`.id";
$sql .= " $whereClause $orderByClause LIMIT :limit OFFSET :offset";
$users = getLimitRows($sql, $limit, $offset, $dataCondition);

if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('module=users', '', $queryString);
    $queryString = str_replace('&action=list', '', $queryString);
    $queryString = str_replace('&page=' . $currentPage, '', $queryString);
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- add button -->
            <p>
                <a href="<?php echo getAbsUrlAdmin('users', 'add'); ?>" class="btn btn-success px-3">
                    <i class="fa fa-plus mr-1"></i> Add user
                </a>
            </p> <!-- /add button -->

            <hr>

            <form action="" method="get">
                <input type="hidden" name="module" value="users">

                <div class="row">
                    <div class="col-sm-10">
                        <div class="row">
                            <!-- status -->
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="">
                                            Choose Status
                                        </option>
                                        <option value="1"
                                            <?php echo (!empty($status) && $status == 1) ? 'selected' : null; ?>>
                                            Active
                                        </option>
                                        <option value="2"
                                            <?php echo (!empty($status) && $status == 2) ? 'selected' : null; ?>>
                                            Not Active
                                        </option>
                                    </select>
                                </div>
                            </div> <!-- /status -->

                            <!-- group_id -->
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Group:</label>
                                    <select name="group_id" class="form-control">
                                        <option value="">
                                            Choose Group
                                        </option>
                                        <?php
                                        if (!empty($groups)):
                                            foreach ($groups as $group):
                                                ?>
                                                <option value="<?php echo $group['id']; ?>"
                                                    <?php echo (!empty($groupId) && $groupId == $group['id'])
                                                        ? 'selected'
                                                        : null; ?>
                                                >
                                                    <?php echo $group['name']; ?>
                                                </option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                            </div> <!-- /group_id -->

                            <!-- order_by -->
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Order By:</label>
                                    <select name="order_by" class="form-control">
                                        <option value="fullname"
                                            <?php echo (!empty($field) && $field == 'fullname') ? 'selected' : null; ?>>
                                            User Name
                                        </option>
                                        <option value="created_at"
                                            <?php
                                            if (empty($field)) {
                                                echo 'selected';
                                            } elseif ($field == 'created_at') {
                                                echo 'selected';
                                            }
                                            ?>
                                        >
                                            Created At
                                        </option>
                                    </select>
                                </div>
                            </div> <!-- /order_by -->

                            <!-- sort_order -->
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Sort Order:</label>
                                    <select name="sort_order" class="form-control">
                                        <option value="ASC"
                                            <?php echo (!empty($sortOrder) && $sortOrder == 'ASC') ? 'selected' : null; ?>>
                                            ASC
                                        </option>
                                        <option value="DESC"
                                            <?php
                                            if (empty($sortOrder)) {
                                                echo 'selected';
                                            } elseif ($sortOrder == 'DESC') {
                                                echo 'selected';
                                            }
                                            ?>
                                        >
                                            DESC
                                        </option>
                                    </select>
                                </div>
                            </div> <!-- /sort_order -->
                        </div>
                    </div>
                </div>


                <!-- keyword and search button -->
                <div class="form-group">
                    <label>Keyword:</label>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="search" class="form-control" name="keyword"
                                       placeholder="Search by user name or email ..."
                                       value="<?php echo (!empty($keyword)) ? $keyword : null; ?>">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-search mr-1"></i> Search
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary"><?php echo 'Total: ' . $totalRows . ' rows'; ?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?php echo getMessage($msg, $msgType); ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Group</th>
                                <th>Created At</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%">Edit</th>
                                <th style="width: 10%">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($users)):
                                $ordinalNumber = $offset;

                                foreach ($users as $user):
                                    $ordinalNumber++;
                                    ?>
                                    <tr>
                                        <td><?php echo $ordinalNumber . '.'; ?></td>
                                        <td><?php echo $user['fullname']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['phone']; ?></td>
                                        <td><?php echo $user['group_name']; ?></td>
                                        <td>
                                            <?php echo (!empty($user['created_at']))
                                                ? getFormattedDate($user['created_at'])
                                                : 'NULL'; ?>
                                        </td>

                                        <td>
                                            <?php
                                            if ($user['status'] == '1') {
                                                echo '<span class="badge bg-gradient-success">Active</span>';
                                            } else {
                                                echo '<span class="badge bg-gradient-gray">Not Active</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php
                                            echo getAbsUrlAdmin('users', 'edit') . '&id=' . $user['id']; ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            <form action="<?php echo getAbsUrlAdmin('users', 'delete'); ?>"
                                                  method="post">
                                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <tr>
                                    <td colspan="9">
                                        <div class="alert alert-default-danger text-center">No data to display.</div>
                                    </td>
                                </tr>
                            <?php
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination m-0 float-right">
                        <?php
                        // Display Previous button
                        if ($currentPage > 1):
                            $prevPage = $currentPage - 1;
                            ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('users') . '&page=1' . $queryString; ?>">
                                    First
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('users') . '&page=' . $prevPage . $queryString; ?>">
                                    &laquo;
                                </a>
                            </li>
                        <?php
                        endif;
                        ?>

                        <?php
                        $range = 5;
                        $half = floor($range / 2);
                        $begin = $currentPage - $half;
                        $end = $currentPage + $half;
                        if ($totalPages <= $range) {
                            $begin = 1;
                            $end = $totalPages;
                        } else {
                            if ($begin < 1) {
                                $begin = 1;
                                $end = $range;
                            }
                            if ($end > $totalPages) {
                                $begin = $totalPages - $range + 1;
                                $end = $totalPages;
                            }
                        }
                        // Display page-item
                        for ($index = $begin; $index <= $end; $index++):
                            ?>
                            <li class="page-item <?php echo ($index == $currentPage) ? 'active' : null; ?>">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('users') . '&page=' . $index . $queryString; ?>">
                                    <?php echo $index; ?>
                                </a>
                            </li>
                        <?php
                        endfor;
                        ?>

                        <?php
                        // Display Next button
                        if ($currentPage < $totalPages):
                            $nextPage = $currentPage + 1;
                            ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('users') . '&page=' . $nextPage . $queryString; ?>">
                                    &raquo;
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin(
                                           'users'
                                       ) . '&page=' . $totalPages . $queryString; ?>">
                                    Last
                                </a>
                            </li>
                        <?php
                        endif;
                        ?>
                    </ul>
                </div>
            </div><!-- /.card -->

        </div><!-- /.container-fluid -->

    </section> <!-- /.content -->

<?php
// Add Footer
addLayout('footer', 'admin');
