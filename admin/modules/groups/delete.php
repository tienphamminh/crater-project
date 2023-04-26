<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

if (isPost()) {
    if (!empty(getBody()['id'])) {
        // Check if group exists in table 'groups'
        $groupId = getBody()['id'];
        $sql = "SELECT id FROM `groups` WHERE id=:id";
        $data = ['id' => $groupId];

        if (getNumberOfRows($sql, $data) > 0) {
            // Check how many users are left in the group
            $sql = "SELECT id FROM users WHERE group_id=:group_id";
            $data = ['group_id' => $groupId];
            $usersLeft = getNumberOfRows($sql, $data);
            if ($usersLeft > 0) {
                setFlashData('msg', 'Can not delete, this group still has ' . $usersLeft . ' users left.');
                setFlashData('msg_type', 'danger');
                redirect('admin/?module=groups');
            } else {
                // If there are no users left in the group, delete the group
                $condition = "id=:id";
                $dataCondition = ['id' => $groupId];
                $isGroupDeleted = delete('groups', $condition, $dataCondition);
                if ($isGroupDeleted) {
                    setFlashData('msg', 'Group has been deleted successfully.');
                    setFlashData('msg_type', 'success');
                    redirect('admin/?module=groups');
                }
            }
        }
    }
    setFlashData('msg', 'Something went wrong, please try again.');
    setFlashData('msg_type', 'danger');
}

redirect('admin/?module=groups');
