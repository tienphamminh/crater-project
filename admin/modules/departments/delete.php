<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    if (!empty(getBody()['id'])) {
        // Check if department exists in table 'departments'
        $departmentId = getBody()['id'];
        $sql = "SELECT id FROM departments WHERE id=:id";
        $data = ['id' => $departmentId];

        if (getNumberOfRows($sql, $data) > 0) {
            // Check how many unprocessed contacts
            $sql = "SELECT id FROM contacts WHERE department_id=:department_id";
            $data = ['department_id' => $departmentId];
            $contactsLeft = getNumberOfRows($sql, $data);
            if ($contactsLeft > 0) {
                setFlashData('msg', 'Can not delete, this department still has ' . $contactsLeft . ' unprocessed contacts.');
                setFlashData('msg_type', 'danger');
                redirect('admin/?module=departments');
            } else {
                // If there are no unprocessed contacts, delete the department
                $condition = "id=:id";
                $dataCondition = ['id' => $departmentId];
                $isDepartmentDeleted = delete('departments', $condition, $dataCondition);
                if ($isDepartmentDeleted) {
                    setFlashData('msg', 'Department has been deleted successfully.');
                    setFlashData('msg_type', 'success');
                    redirect('admin/?module=departments');
                }
            }
        }
    }
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

redirect('admin/?module=departments');
