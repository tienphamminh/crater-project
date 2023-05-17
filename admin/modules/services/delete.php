<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    if (!empty(getBody()['id'])) {
        // Check if service exists in table 'services'
        $serviceId = getBody()['id'];
        $sql = "SELECT id FROM services WHERE id=:id";
        $data = ['id' => $serviceId];

        if (getNumberOfRows($sql, $data) > 0) {
            // Delete the service
            $condition = "id=:id";
            $dataCondition = ['id' => $serviceId];
            $isServiceDeleted = delete('services', $condition, $dataCondition);
            if ($isServiceDeleted) {
                setFlashData('msg', 'Service has been deleted successfully.');
                setFlashData('msg_type', 'success');
                redirect('admin/?module=services');
            }
        }
    }
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

redirect('admin/?module=services');
