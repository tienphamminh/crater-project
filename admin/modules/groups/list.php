<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

// Add Header
$dataHeader = [
    'pageTitle' => 'Groups'
];
addLayout('header', 'admin', $dataHeader);
addLayout('sidebar', 'admin', $dataHeader);
addLayout('breadcrumb', 'admin', $dataHeader);

// Search form handling
$orderByClause = "ORDER BY created_at DESC";
$whereClause = '';
$dataCondition = [];
if (isGet()) {
    $body = getBody();

    if (!empty($body['order_by'])) {
        $field = $body['order_by'];
        $orderByClause = "ORDER BY $field";

        if (!empty($body['sort_order'])) {
            $sortOrder = $body['sort_order'];
            $orderByClause .= " $sortOrder";
        }
    }


    if (!empty($body['keyword'])) {
        $keyword = $body['keyword'];

        $whereClause .= "WHERE name LIKE :pattern";
        $pattern = "%$keyword%";
        $dataCondition['pattern'] = $pattern;
    }
}

// Pagination
// Set the limit of number of records to be displayed per page
$limit = 8;

// Determine the total number of pages available
$sql = "SELECT id FROM `groups` $whereClause";
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
$sql = "SELECT * FROM `groups` $whereClause $orderByClause LIMIT :limit OFFSET :offset";
$groups = getLimitRows($sql, $limit, $offset, $dataCondition);


if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('module=groups', '', $queryString);
    $queryString = str_replace('&action=list', '', $queryString);
    $queryString = str_replace('&page=' . $currentPage, '', $queryString);
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <p>
                <a href="<?php echo getAbsUrlAdmin('groups', 'add'); ?>" class="btn btn-success px-3">
                    Add group <i class="fa fa-plus ml-1"></i>
                </a>
            </p>
            <hr>

            <form action="" method="get">
                <input type="hidden" name="module" value="groups">
                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Order By:</label>
                            <select name="order_by" class="form-control">
                                <option value="name"
                                    <?php echo (!empty($field) && $field == 'name') ? 'selected' : null; ?>>
                                    Group Name
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
                                <option value="updated_at"
                                    <?php echo (!empty($field) && $field == 'updated_at') ? 'selected' : null; ?>>
                                    Updated At
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
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
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Keyword:</label>
                            <div class="input-group">
                                <input type="search" class="form-control" name="keyword"
                                       placeholder="Search by group name ..."
                                       value="<?php echo (!empty($keyword)) ? $keyword : null; ?>">
                                <div class=" input-group-append">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fa fa-search mr-1"></i> Search
                                    </button>
                                </div>
                            </div>
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
                                <th style="width: 25%">Group Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th style="width: 10%">Permission</th>
                                <th style="width: 10%">Edit</th>
                                <th style="width: 10%">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($groups)):
                                $ordinalNumber = $offset;

                                foreach ($groups as $group):
                                    $ordinalNumber++;
                                    $groupId = $group['id'];
                                    ?>
                                    <tr>
                                        <td><?php echo $ordinalNumber . '.'; ?></td>
                                        <td><?php echo $group['name']; ?></td>
                                        <td>
                                            <?php echo (!empty($group['created_at']))
                                                ? getFormattedDate($group['created_at'])
                                                : 'NULL'; ?>
                                        </td>
                                        <td>
                                            <?php echo (!empty($group['updated_at']))
                                                ? getFormattedDate($group['updated_at'])
                                                : 'NULL'; ?>
                                        </td>
                                        <td>
                                            <a href="<?php
                                            echo getAbsUrlAdmin('groups', 'assign') . '&id=' . $groupId; ?>"
                                               class="btn btn-info btn-sm">
                                                <i class="fa fa-tags"></i>
                                                Assign
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php
                                            echo getAbsUrlAdmin('groups', 'edit') . '&id=' . $groupId; ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td>
                                            <form action="<?php echo getAbsUrlAdmin('groups', 'delete'); ?>"
                                                  method="post">
                                                <input type="hidden" name="id" value="<?php echo $group['id']; ?>">
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
                                   href="<?php echo getAbsUrlAdmin('groups') . '&page=1' . $queryString; ?>">
                                    First
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin('groups') . '&page=' . $prevPage . $queryString; ?>">
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
                                   href="<?php echo getAbsUrlAdmin('groups') . '&page=' . $index . $queryString; ?>">
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
                                   href="<?php echo getAbsUrlAdmin('groups') . '&page=' . $nextPage . $queryString; ?>">
                                    &raquo;
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo getAbsUrlAdmin(
                                           'groups'
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
