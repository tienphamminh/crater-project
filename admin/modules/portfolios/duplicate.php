<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

$body = getBody();

if (!empty($body['id'])) {
    $portfolioId = $body['id'];
    $sql = "SELECT * FROM portfolios WHERE id=:id";
    $data = ['id' => $portfolioId];
    $portfolioDetails = getFirstRow($sql, $data);
    if (!empty($portfolioDetails)) {
        $duplicate = $portfolioDetails['duplicate'];
        $duplicate++;
        $newPortfolioName = $portfolioDetails['name'] . ' (' . $duplicate . ')';
        $newPortfolioSlug = $portfolioDetails['slug'] . '-' . $duplicate;
        $portfolioDetails['name'] = $newPortfolioName;
        $portfolioDetails['slug'] = $newPortfolioSlug;
        $portfolioDetails['created_at'] = date('Y-m-d H:i:s');

        unset($portfolioDetails['id']);
        unset($portfolioDetails['duplicate']);
        unset($portfolioDetails['updated_at']);

        $isDataInserted = insert('portfolios', $portfolioDetails);

        if ($isDataInserted) {
            setFlashData('msg', 'Portfolio has been duplicated successfully.');
            setFlashData('msg_type', 'success');

            // Update 'duplicate' field of the original portfolio
            $dataUpdate = ['duplicate' => $duplicate];
            $condition = "id=:id";
            $dataCondition = ['id' => $portfolioId];
            update('portfolios', $dataUpdate, $condition, $dataCondition);

            redirect('admin/?module=portfolios');
        }
    }
}

setFlashData('msg', 'Something went wrong, please try again.');
setFlashData('msg_type', 'danger');
redirect('admin/?module=portfolios');
