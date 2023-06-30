<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Contacts'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

// Search form handling
$orderClause = "ORDER BY contacts.created_at DESC";
$whereClause = '';
$dataCondition = [];

if (isGet()) {
    $body = getBody();

    if (!empty($body['order_by'])) {
        $field = trim($body['order_by']);
        $orderClause = "ORDER BY contacts." . $field;

        if (!empty($body['sort_order'])) {
            $sortOrder = trim($body['sort_order']);
            $orderClause .= " $sortOrder";
        }
    }

    if (!empty($body['status'])) {
        $status = trim($body['status']);
        if ($status == 1) {
            $dbStatus = 0;
        } elseif ($status == 2) {
            $dbStatus = 1;
        } elseif ($status == 3) {
            $dbStatus = 2;
        }
        if (isset($dbStatus)) {
            $whereClause .= "WHERE contacts.status=:status";
            $dataCondition['status'] = $dbStatus;
        }
    }

    if (!empty($body['department_id'])) {
        $departmentId = trim($body['department_id']);
        if (strContains($whereClause, 'WHERE')) {
            $operator = ' AND';
        } else {
            $operator = 'WHERE';
        }
        $whereClause .= "$operator contacts.department_id=:department_id";
        $dataCondition['department_id'] = $departmentId;
    }

    if (!empty($body['keyword'])) {
        $keyword = trim($body['keyword']);
        if (strContains($whereClause, 'WHERE')) {
            $operator = ' AND';
        } else {
            $operator = 'WHERE';
        }
        $whereClause .= "$operator (contacts.message LIKE :pattern OR contacts.fullname LIKE :pattern)";
        $pattern = "%$keyword%";
        $dataCondition['pattern'] = $pattern;
    }
}

// Retrieve department data for <select name="department_id">
$departments = getAllRows("SELECT id, name FROM departments ORDER BY name");

// Pagination
// Set the limit of number of records to be displayed per page
$limit = 5;

// Determine the total number of pages available
$sql = "SELECT id FROM contacts $whereClause";
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
$columnNames = "contacts.*, departments.name AS department_name";
$sql = "SELECT $columnNames FROM contacts";
$sql .= " INNER JOIN departments ON contacts.department_id=departments.id";
$sql .= " $whereClause $orderClause LIMIT :limit OFFSET :offset";
$contacts = getLimitRows($sql, $limit, $offset, $dataCondition);

$searchQueryString = getSearchQueryString('contacts', 'list', $currentPage);

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Search Form -->
            <form action="" method="get">
                <input type="hidden" name="module" value="contacts">

                <div class="row">
                    <!-- order_by -->
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <label>Order By:</label>
                            <select name="order_by" class="form-control">
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
                                <option value="updated_at"
                                    <?php echo (!empty($field) && $field == 'updated_at') ? 'selected' : null; ?>>
                                    Updated At
                                </option>
                            </select>
                        </div>
                    </div> <!-- /order_by -->

                    <!-- sort_order -->
                    <div class="col-6 col-md-2">
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

                    <!-- department_id -->
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <label>Department:</label>
                            <select name="department_id" class="form-control">
                                <option value="">
                                    All Departments
                                </option>
                                <?php
                                if (!empty($departments)):
                                    foreach ($departments as $department):
                                        ?>
                                        <option value="<?php echo $department['id']; ?>"
                                            <?php echo (!empty($departmentId) && $departmentId == $department['id'])
                                                ? 'selected'
                                                : null; ?>
                                        >
                                            <?php echo $department['name']; ?>
                                        </option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div> <!-- /department_id -->

                    <!-- status -->
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="status" class="form-control">
                                <option value="">
                                    All Status
                                </option>
                                <option value="1"
                                    <?php echo (!empty($status) && $status == 1) ? 'selected' : null; ?>>
                                    Not yet
                                </option>
                                <option value="2"
                                    <?php echo (!empty($status) && $status == 2) ? 'selected' : null; ?>>
                                    In progress
                                </option>
                                <option value="3"
                                    <?php echo (!empty($status) && $status == 3) ? 'selected' : null; ?>>
                                    Done
                                </option>
                            </select>
                        </div>
                    </div> <!-- /status -->
                </div> <!-- /.row -->

                <!-- keyword and search button -->
                <div class="form-group">
                    <label>Keyword:</label>
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <input type="search" name="keyword" class="form-control"
                                       placeholder="Search by customer name or contact message ..."
                                       value="<?php echo (!empty($keyword)) ? $keyword : null; ?>">
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i>
                                <span class="d-none d-md-inline ml-1">Search</span>
                            </button>
                        </div>
                    </div>
                </div> <!-- /keyword and search button -->
            </form> <!-- /Search Form -->

            <div class="card" style="min-height: 585px">
                <div class="card-header">
                    <h3 class="card-title text-primary"><?php echo 'Total: ' . $totalRows . ' rows'; ?></h3>
                </div> <!-- /.card-header -->

                <div class="card-body">
                    <?php echo getMessage($msg, $msgType); ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 15%">From</th>
                                <th style="width: 12%">To</th>
                                <th style="width: 20%">Message</th>
                                <th style="width: 8%">Status</th>
                                <th style="width: 18%">Note</th>
                                <th style="width: 12%">Created At</th>
                                <th style="width: 5%">Edit</th>
                                <th style="width: 5%">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($contacts)):
                                $ordinalNumber = $offset;

                                foreach ($contacts as $contact):
                                    $ordinalNumber++;
                                    ?>
                                    <tr>
                                        <td><?php echo $ordinalNumber . '.'; ?></td>
                                        <td>
                                            <?php echo $contact['fullname']; ?>
                                            <br>
                                            <em> <?php echo $contact['email']; ?></em>
                                        </td>
                                        <td><?php echo $contact['department_name']; ?></td>
                                        <td><?php echo $contact['message']; ?></td>
                                        <td>
                                            <?php
                                            if ($contact['status'] == '2') {
                                                echo '<span class="badge bg-gradient-success">Done</span>';
                                            } elseif ($contact['status'] == '1') {
                                                echo '<span class="badge bg-gradient-warning">In progress</span>';
                                            } else {
                                                echo '<span class="badge bg-gradient-danger">Not yet</span>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $contact['note']; ?></td>
                                        <td>
                                            <?php echo (!empty($contact['created_at']))
                                                ? getFormattedDate($contact['created_at'])
                                                : 'NULL'; ?>
                                        </td>
                                        <td>
                                            <a href="<?php
                                            echo getAbsUrlAdmin('contacts', 'edit') . '&id=' . $contact['id']; ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            $msgDelete = 'Delete contact message of customer: ';
                                            $msgDelete .= $contact['fullname'] . ' - ' . $contact['email'];
                                            ?>
                                            <button type="button" class="btn btn-danger btn-sm cf-delete"
                                                    value="<?php echo $contact['id']; ?>"
                                                    data-msg="<?php echo $msgDelete; ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
                </div> <!-- /.card-body -->

                <div class="card-footer clearfix">
                    <ul class="pagination m-0 float-right">
                        <?php
                        // Display Previous button
                        if ($currentPage > 1):
                            $prevPage = $currentPage - 1;
                            ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('contacts') . '&page=1' . $searchQueryString; ?>">
                                    First
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('contacts')
                                       . '&page=' . $prevPage . $searchQueryString; ?>">
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
                                   href="<?php echo getAbsUrlAdmin('contacts')
                                       . '&page=' . $index . $searchQueryString; ?>">
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
                                   href="<?php echo getAbsUrlAdmin('contacts')
                                       . '&page=' . $nextPage . $searchQueryString; ?>">
                                    &raquo;
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('contacts')
                                       . '&page=' . $totalPages . $searchQueryString; ?>">
                                    Last
                                </a>
                            </li>
                        <?php
                        endif;
                        ?>
                    </ul>
                </div> <!-- /.card-footer -->
            </div> <!-- /.card -->

        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Delete Modal
addLayout('modal-delete', 'admin');
// Add Footer
addLayout('footer', 'admin');
