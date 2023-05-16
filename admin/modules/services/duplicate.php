<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

$body = getBody();

if (!empty($body['id'])) {
    $serviceId = $body['id'];
    $sql = "SELECT * FROM `services` WHERE id=:id";
    $data = ['id' => $serviceId];
    $serviceDetails = getFirstRow($sql, $data);
    if (!empty($serviceDetails)) {
        $duplicate = $serviceDetails['duplicate'];
        $duplicate++;
        $newServiceName = $serviceDetails['name'] . ' (' . $duplicate . ')';
        $serviceDetails['name'] = $newServiceName;
        $serviceDetails['created_at'] = date('Y-m-d H:i:s');

        unset($serviceDetails['id']);
        unset($serviceDetails['duplicate']);
        unset($serviceDetails['updated_at']);

        $isDataInserted = insert('services', $serviceDetails);

        if ($isDataInserted) {
            setFlashData('msg', 'Service has been duplicated successfully.');
            setFlashData('msg_type', 'success');

            // Update 'duplicate' field of the original service
            $dataUpdate = ['duplicate' => $duplicate];
            $condition = "id=:id";
            $dataCondition = ['id' => $serviceId];
            $isDataUpdated = update('services', $dataUpdate, $condition, $dataCondition);

            redirect('admin/?module=services');
        }
    }
}

setFlashData('msg', 'Something went wrong, please try again.');
setFlashData('msg_type', 'danger');
redirect('admin/?module=services');