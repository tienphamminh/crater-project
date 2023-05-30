<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    if (!empty(getBody()['id'])) {
        // Check if portfolio exists in table 'portfolios'
        $portfolioId = getBody()['id'];
        $sql = "SELECT id FROM portfolios WHERE id=:id";
        $data = ['id' => $portfolioId];

        if (getNumberOfRows($sql, $data) > 0) {
            // Delete gallery of portfolio (portfolio_images)
            $condition = "portfolio_id=:portfolio_id";
            $dataCondition = ['portfolio_id' => $portfolioId];
            delete('portfolio_images', $condition, $dataCondition);
            
            // Delete the portfolio
            $condition = "id=:id";
            $dataCondition = ['id' => $portfolioId];
            $isPortfolioDeleted = delete('portfolios', $condition, $dataCondition);
            if ($isPortfolioDeleted) {
                setFlashData('msg', 'Portfolio has been deleted successfully.');
                setFlashData('msg_type', 'success');
                redirect('admin/?module=portfolios');
            }
        }
    }
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

redirect('admin/?module=portfolios');
