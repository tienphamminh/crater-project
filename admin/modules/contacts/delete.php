<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    if (!empty(getBody()['id'])) {
        // Check if contact exists in table 'contacts'
        $contactId = getBody()['id'];
        $sql = "SELECT id FROM contacts WHERE id=:id";
        $data = ['id' => $contactId];

        if (getNumberOfRows($sql, $data) > 0) {
            // Delete the contact
            $condition = "id=:id";
            $dataCondition = ['id' => $contactId];
            $isContactDeleted = delete('contacts', $condition, $dataCondition);
            if ($isContactDeleted) {
                setFlashData('msg', 'Contact has been deleted successfully.');
                setFlashData('msg_type', 'success');
                redirect('admin/?module=contacts');
            }
        }
    }
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

redirect('admin/?module=contacts');
