<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Services'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

// Search form handling
$orderClause = "ORDER BY services.created_at DESC";
$whereClause = '';
$dataCondition = [];

if (isGet()) {
    $body = getBody();

    if (!empty($body['order_by'])) {
        $field = trim($body['order_by']);
        $orderClause = "ORDER BY services." . $field;

        if (!empty($body['sort_order'])) {
            $sortOrder = trim($body['sort_order']);
            $orderClause .= " $sortOrder";
        }
    }

    if (!empty($body['user_id'])) {
        $userId = trim($body['user_id']);
        if (str_contains($whereClause, 'WHERE')) {
            $operator = ' AND';
        } else {
            $operator = 'WHERE';
        }
        $whereClause .= "$operator services.user_id=:user_id";
        $dataCondition['user_id'] = $userId;
    }


    if (!empty($body['keyword'])) {
        $keyword = trim($body['keyword']);
        if (str_contains($whereClause, 'WHERE')) {
            $operator = ' AND';
        } else {
            $operator = 'WHERE';
        }
        $whereClause .= "$operator services.name LIKE :pattern";
        $pattern = "%$keyword%";
        $dataCondition['pattern'] = $pattern;
    }
}

// Retrieve user data for  <select name="user_id">
$users = getAllRows("SELECT id, fullname, email FROM users ORDER BY fullname");

// Pagination
// Set the limit of number of records to be displayed per page
$limit = 20;

// Determine the total number of pages available
$sql = "SELECT id FROM services $whereClause";
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
$columnNames = "services.id, services.name, services.icon, services.created_at, users.fullname AS user_name";
$sql = "SELECT $columnNames FROM services INNER JOIN users ON services.user_id=users.id";
$sql .= " $whereClause $orderClause LIMIT :limit OFFSET :offset";
$services = getLimitRows($sql, $limit, $offset, $dataCondition);

$searchQueryString = getSearchQueryString('services', 'list', $currentPage);

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- add button -->
            <p>
                <a href="<?php echo getAbsUrlAdmin('services', 'add'); ?>" class="btn btn-success px-3">
                    <i class="fa fa-plus mr-1"></i> Add service
                </a>
            </p> <!-- /add button -->
            <hr>
            <!-- Search Form -->
            <form action="" method="get">
                <input type="hidden" name="module" value="services">

                <div class="row">
                    <!-- order_by -->
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <label>Order By:</label>
                            <select name="order_by" class="form-control">
                                <option value="name"
                                    <?php echo (!empty($field) && $field == 'name') ? 'selected' : null; ?>>
                                    Service Name
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

                    <!-- posted by -->
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label>Posted By:</label>
                            <select name="user_id" class="form-control">
                                <option value="">
                                    All Users
                                </option>
                                <?php
                                if (!empty($users)):
                                    foreach ($users as $user):
                                        ?>
                                        <option value="<?php echo $user['id']; ?>"
                                            <?php echo (!empty($userId) && $userId == $user['id'])
                                                ? 'selected'
                                                : null; ?>
                                        >
                                            <?php echo $user['fullname'] . ' - ' . $user['email']; ?>
                                        </option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div> <!-- /posted by -->
                </div>

                <!-- keyword and search button -->
                <div class="form-group">
                    <label>Keyword:</label>
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <input type="search" class="form-control" name="keyword"
                                       placeholder="Search by service name ..."
                                       value="<?php echo (!empty($keyword)) ? $keyword : null; ?>">
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-search"></i>
                                <span class="d-none d-md-inline ml-1">Search</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form> <!-- /Search Form -->

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
                                <th style="width: 5%">Icon</th>
                                <th>Service Name</th>
                                <th>Posted By</th>
                                <th>Created At</th>
                                <th style="width: 10%">Edit</th>
                                <th style="width: 10%">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($services)):
                                $ordinalNumber = $offset;

                                foreach ($services as $service):
                                    $ordinalNumber++;
                                    ?>
                                    <tr>
                                        <td><?php echo $ordinalNumber . '.'; ?></td>
                                        <td class="icon-2x">
                                            <?php
                                            $icon = html_entity_decode($service['icon']);
                                            echo (isFontIcon($icon))
                                                ? $icon
                                                : '<img src="' . $icon . '" width="50">'; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="mr-auto">
                                                    <?php echo $service['name']; ?>
                                                </div>
                                                <div class="ml-3">
                                                    <a href="#"
                                                       class="btn btn-info btn-sm"
                                                       data-toggle="tooltip" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="ml-2 d-none d-xl-block">
                                                    <a href="<?php echo getAbsUrlAdmin('services', 'duplicate')
                                                        . '&id=' . $service['id']; ?>"
                                                       class="btn btn-secondary btn-sm"
                                                       data-toggle="tooltip" title="Duplicate">
                                                        <i class="fas fa-clone"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $service['user_name']; ?></td>
                                        <td>
                                            <?php echo (!empty($service['created_at']))
                                                ? getFormattedDate($service['created_at'])
                                                : 'NULL'; ?>
                                        </td>
                                        <td>
                                            <a href="<?php
                                            echo getAbsUrlAdmin('services', 'edit') . '&id=' . $service['id']; ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                                <span class="d-none d-xl-inline">Edit</span>
                                            </a>
                                        </td>
                                        <td>
                                            <?php $msgDelete = 'Delete service: ' . $service['name']; ?>
                                            <button type="button" class="btn btn-danger btn-sm cf-delete"
                                                    value="<?php echo $service['id']; ?>"
                                                    data-msg="<?php echo $msgDelete; ?>">
                                                <i class="fa fa-trash"></i>
                                                <span class="d-none d-xl-inline">Delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <tr>
                                    <td colspan="7">
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
                                   href="<?php echo getAbsUrlAdmin('services') . '&page=1' . $searchQueryString; ?>">
                                    First
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin(
                                           'services'
                                       ) . '&page=' . $prevPage . $searchQueryString; ?>">
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
                                   href="<?php echo getAbsUrlAdmin(
                                           'services'
                                       ) . '&page=' . $index . $searchQueryString; ?>">
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
                                   href="<?php echo getAbsUrlAdmin(
                                           'services'
                                       ) . '&page=' . $nextPage . $searchQueryString; ?>">
                                    &raquo;
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin(
                                           'services'
                                       ) . '&page=' . $totalPages . $searchQueryString; ?>">
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
// Add Delete Modal
addLayout('modal-delete', 'admin');
// Add Footer
addLayout('footer', 'admin');
