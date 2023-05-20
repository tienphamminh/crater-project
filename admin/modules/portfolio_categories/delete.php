<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    if (!empty(getBody()['id'])) {
        // Check if category exists in table 'portfolio_categories'
        $categoryId = getBody()['id'];
        $sql = "SELECT id FROM portfolio_categories WHERE id=:id";
        $data = ['id' => $categoryId];

        if (getNumberOfRows($sql, $data) > 0) {
            // Check how many portfolios  are left in the category
            $sql = "SELECT id FROM portfolios WHERE portfolio_category_id=:category_id";
            $data = ['category_id' => $categoryId];
            $portfoliosLeft = getNumberOfRows($sql, $data);
            if ($portfoliosLeft > 0) {
                setFlashData('msg', 'Can not delete, this category still has ' . $portfoliosLeft . ' portfolios left.');
                setFlashData('msg_type', 'danger');
                redirect('admin/?module=portfolio_categories');
            } else {
                // If there are no portfolios left in the category, delete the category
                $condition = "id=:id";
                $dataCondition = ['id' => $categoryId];
                $isCategoryDeleted = delete('portfolio_categories', $condition, $dataCondition);
                if ($isCategoryDeleted) {
                    setFlashData('msg', 'Category has been deleted successfully.');
                    setFlashData('msg_type', 'success');
                    redirect('admin/?module=portfolio_categories');
                }
            }
        }
    }
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

redirect('admin/?module=portfolio_categories');
