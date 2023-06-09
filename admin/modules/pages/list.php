<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = ['pageTitle' => 'Pages'];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

// Search form handling
$orderClause = "ORDER BY pages.created_at DESC";
$whereClause = '';
$dataCondition = [];

if (isGet()) {
    $body = getBody();

    if (!empty($body['order_by'])) {
        $field = trim($body['order_by']);
        $orderClause = "ORDER BY pages." . $field;

        if (!empty($body['sort_order'])) {
            $sortOrder = trim($body['sort_order']);
            $orderClause .= " $sortOrder";
        }
    }

    if (!empty($body['user_id'])) {
        $userId = trim($body['user_id']);
        $whereClause .= "WHERE pages.user_id=:user_id";
        $dataCondition['user_id'] = $userId;
    }

    if (!empty($body['keyword'])) {
        $keyword = trim($body['keyword']);
        if (strContains($whereClause, 'WHERE')) {
            $operator = ' AND';
        } else {
            $operator = 'WHERE';
        }
        $whereClause .= "$operator pages.title LIKE :pattern";
        $pattern = "%$keyword%";
        $dataCondition['pattern'] = $pattern;
    }
}

// Retrieve user data for  <select name="user_id">
$users = getAllRows("SELECT id, fullname, email FROM users ORDER BY fullname");

// Pagination
// Set the limit of number of records to be displayed per page
$limit = 5;

// Determine the total number of pages available
$sql = "SELECT id FROM pages $whereClause";
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
$columnNames = "pages.id, pages.title, pages.created_at, users.fullname AS user_name";
$sql = "SELECT $columnNames FROM pages INNER JOIN users ON pages.user_id=users.id";
$sql .= " $whereClause $orderClause LIMIT :limit OFFSET :offset";
$pages = getLimitRows($sql, $limit, $offset, $dataCondition);

$searchQueryString = getSearchQueryString('pages', 'list', $currentPage);

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Add button -->
            <p>
                <a href="<?php echo getAbsUrlAdmin('pages', 'add'); ?>" class="btn btn-success px-3">
                    <i class="fas fa-plus mr-1"></i> Add page
                </a>
            </p> <!-- /add button -->
            <hr>
            <!-- Search Form -->
            <form action="" method="get">
                <input type="hidden" name="module" value="pages">

                <div class="row">
                    <!-- order_by -->
                    <div class="col-6 col-md-2">
                        <div class="form-group">
                            <label>Order By:</label>
                            <select name="order_by" class="form-control">
                                <option value="title"
                                    <?php echo (!empty($field) && $field == 'title') ? 'selected' : null; ?>>
                                    Page Title
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
                </div> <!-- /.row -->

                <!-- keyword and search button -->
                <div class="form-group">
                    <label>Keyword:</label>
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <input type="search" class="form-control" name="keyword"
                                       placeholder="Search by page title ..."
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

            <div class="card" style="min-height: 500px">
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
                                <th>Page Title</th>
                                <th>Posted By</th>
                                <th>Created At</th>
                                <th style="width: 10%">Edit</th>
                                <th style="width: 10%">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($pages)):
                                $ordinalNumber = $offset;

                                foreach ($pages as $page):
                                    $ordinalNumber++;
                                    ?>
                                    <tr>
                                        <td><?php echo $ordinalNumber . '.'; ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="mr-auto">
                                                    <?php echo $page['title']; ?>
                                                </div>
                                                <div class="ml-3">
                                                    <a href="#" target="_blank"
                                                       class="btn btn-info btn-sm"
                                                       data-toggle="tooltip" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="ml-2 d-none d-xl-block">
                                                    <a href="<?php echo getAbsUrlAdmin('pages', 'duplicate')
                                                        . '&id=' . $page['id']; ?>"
                                                       class="btn btn-secondary btn-sm"
                                                       data-toggle="tooltip" title="Duplicate">
                                                        <i class="fas fa-clone"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $page['user_name']; ?></td>
                                        <td>
                                            <?php echo (!empty($page['created_at']))
                                                ? getFormattedDate($page['created_at'])
                                                : 'NULL'; ?>
                                        </td>
                                        <td>
                                            <a href="<?php
                                            echo getAbsUrlAdmin('pages', 'edit') . '&id=' . $page['id']; ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                                <span class="d-none d-xl-inline">Edit</span>
                                            </a>
                                        </td>
                                        <td>
                                            <?php $msgDelete = 'Delete page: ' . $page['title']; ?>
                                            <button type="button" class="btn btn-danger btn-sm cf-delete"
                                                    value="<?php echo $page['id']; ?>"
                                                    data-msg="<?php echo $msgDelete; ?>">
                                                <i class="fas fa-trash"></i>
                                                <span class="d-none d-xl-inline">Delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <tr>
                                    <td colspan="6">
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
                                   href="<?php echo getAbsUrlAdmin('pages') . '&page=1' . $searchQueryString; ?>">
                                    First
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('pages')
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
                                   href="<?php echo getAbsUrlAdmin('pages')
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
                                   href="<?php echo getAbsUrlAdmin('pages')
                                       . '&page=' . $nextPage . $searchQueryString; ?>">
                                    &raquo;
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('pages')
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
