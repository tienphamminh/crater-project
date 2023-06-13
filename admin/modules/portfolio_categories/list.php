<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = [
    'pageTitle' => 'Portfolio Categories'
];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

$view = 'add'; // Default view
if (!empty($_GET['view'])) {
    $view = filterInput($_GET['view']);
}

// Search form handling
$orderClause = "ORDER BY portfolio_categories.created_at DESC";
$whereClause = '';
$dataCondition = [];
if (isGet()) {
    $body = getBody();

    if (!empty($body['order_by'])) {
        $field = $body['order_by'];
        $orderClause = "ORDER BY portfolio_categories." . $field;

        if (!empty($body['sort_order'])) {
            $sortOrder = $body['sort_order'];
            $orderClause .= " $sortOrder";
        }
    }

    if (!empty($body['keyword'])) {
        $keyword = $body['keyword'];

        $whereClause .= "WHERE portfolio_categories.name LIKE :pattern";
        $pattern = "%$keyword%";
        $dataCondition['pattern'] = $pattern;
    }
}

// Pagination
// Set the limit of number of records to be displayed per page
$limit = 5;

// Determine the total number of pages available
$sql = "SELECT id FROM portfolio_categories $whereClause";
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
$sql = "SELECT portfolio_categories.*, COUNT(portfolios.id) AS portfolios_count FROM portfolio_categories";
$sql .= " LEFT JOIN portfolios ON portfolio_categories.id=portfolios.portfolio_category_id";
$sql .= " $whereClause GROUP BY portfolio_categories.id $orderClause LIMIT :limit OFFSET :offset";
$categories = getLimitRows($sql, $limit, $offset, $dataCondition);

$searchQueryString = getSearchQueryString('portfolio_categories', 'list', $currentPage);

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- left column -->
                <div class="col-md-5">
                    <?php
                    if ($view == 'edit') {
                        require_once 'edit.php';
                    } else {
                        require_once 'add.php';
                    }
                    ?>
                </div> <!-- /.col (left) -->

                <!-- right column -->
                <div class="col-md-7">
                    <!-- Search Form -->
                    <div class="card" style="min-height: 235px">
                        <form action="" method="get">
                            <div class="card-body">
                                <input type="hidden" name="module" value="portfolio_categories">
                                <div class="row">
                                    <!-- order_by -->
                                    <div class="col-6 col-lg-3">
                                        <div class="form-group">
                                            <label>Order By:</label>
                                            <select name="order_by" class="form-control">
                                                <option value="name"
                                                    <?php echo (!empty($field) && $field == 'name') ? 'selected' : null; ?>>
                                                    Category Name
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
                                    <div class="col-6 col-lg-3">
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
                                </div> <!-- /.row -->

                                <!-- keyword and search button -->
                                <div class="form-group">
                                    <label>Keyword:</label>
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="form-group">
                                                <input type="search" class="form-control" name="keyword"
                                                       placeholder="Search by category name ..."
                                                       value="<?php echo (!empty($keyword)) ? $keyword : null; ?>">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> <!-- /keyword and search button -->
                            </div>
                        </form>
                    </div> <!-- /.card -->

                    <!-- Data Table -->
                    <div class="card" style="min-height: 500px">
                        <div class="card-header">
                            <h3 class="card-title text-primary"><?php echo 'Total: ' . $totalRows . ' rows'; ?></h3>
                        </div> <!-- /.card-header -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <?php echo getMessage($msg, $msgType); ?>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>Category Name</th>
                                        <th style="width: 30%">Created At</th>
                                        <th style="width: 10%">Edit</th>
                                        <th style="width: 10%">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($categories)):
                                        $ordinalNumber = $offset;

                                        foreach ($categories as $category):
                                            $ordinalNumber++;
                                            ?>
                                            <tr>
                                                <td><?php echo $ordinalNumber . '.'; ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="mr-auto">
                                                            <?php echo $category['name']; ?>
                                                        </div>
                                                        <div class="ml-3">
                                                            <span class="badge bg-cyan">
                                                                <?php echo $category['portfolios_count']; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo (!empty($category['created_at']))
                                                        ? getFormattedDate($category['created_at'])
                                                        : 'NULL'; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php
                                                    echo getAbsUrlAdmin(
                                                        'portfolio_categories',
                                                        '',
                                                        ['view' => 'edit', 'id' => $category['id']]
                                                    ); ?>"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php $msgDelete = 'Delete portfolio category: ' . $category['name']; ?>
                                                    <button type="button" class="btn btn-danger btn-sm cf-delete"
                                                            value="<?php echo $category['id']; ?>"
                                                            data-msg="<?php echo $msgDelete; ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="5">
                                                <div class="alert alert-default-danger text-center">
                                                    No data to display.
                                                </div>
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
                                           href="<?php echo getAbsUrlAdmin('portfolio_categories')
                                               . '&page=1' . $searchQueryString; ?>">
                                            First
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo getAbsUrlAdmin('portfolio_categories')
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
                                           href="<?php echo getAbsUrlAdmin('portfolio_categories')
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
                                           href="<?php echo getAbsUrlAdmin('portfolio_categories')
                                               . '&page=' . $nextPage . $searchQueryString; ?>">
                                            &raquo;
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo getAbsUrlAdmin('portfolio_categories')
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

                </div> <!-- /.col (right) -->
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </section> <!-- /.content -->

<?php
// Add Delete Modal
addLayout('modal-delete', 'admin');
// Add Footer
addLayout('footer', 'admin');
