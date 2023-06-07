<?php

// Prevent direct access to file
if (!defined('_INCODE')) {
    http_response_code(403);
    exit;
}

//Import PHPMailer classes into the global namespace
use JetBrains\PhpStorm\NoReturn;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// User-defined filter input function
function filterInput($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

// Get current module
function getCurrentModule(): ?string
{
    if (!empty($_GET['module'])) {
        return filterInput($_GET['module']);
    }

    return null;
}

// Get current module
function getCurrentAction(): ?string
{
    if (!empty($_GET['action'])) {
        return filterInput($_GET['action']);
    }

    return null;
}


// Send a "Location:" header and a REDIRECT (302) status code back to the client
function redirect($path = 'index.php'): void
{
    $absUrl = _WEB_HOST_ROOT . '/' . $path;
    header("Location: $absUrl");
    exit;
}

// Send mail using phpmailer
function sendMail($to, $subject, $body): bool
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                 //Enable verbose debug output
        $mail->isSMTP();                                    //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                             //Enable SMTP authentication
        $mail->Username = 'tienphamminh0312@gmail.com';     //SMTP username
        $mail->Password = '';               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    //Enable implicit TLS encryption
        $mail->Port = 465;                                  //TCP
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Recipients
        $mail->setFrom('tienphamminh0312@gmail.com', 'Crater - Admin Page');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);  //Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body = $body;

        return $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function addLayout($layoutName = 'header', $dir = '', $dataHeader = []): void
{
    if (!empty($dir)) {
        $dir = '/' . $dir;
    }
    $path = _DIR_PATH_TEMPLATE . $dir . '/layouts/' . $layoutName . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
}

// Check if a request is POST
function isPost(): bool
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }

    return false;
}

// Check if a request is GET
function isGet(): bool
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }

    return false;
}

function getBody(): array
{
    $bodyArr = [];

    if (isGet()) {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $bodyArr[$key] = filter_input(
                        INPUT_GET,
                        $key,
                        FILTER_SANITIZE_SPECIAL_CHARS,
                        FILTER_REQUIRE_ARRAY
                    );
                } else {
                    $bodyArr[$key] = filter_input(
                        INPUT_GET,
                        $key,
                        FILTER_SANITIZE_SPECIAL_CHARS
                    );
                }
            }
        }
    }

    if (isPost()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $bodyArr[$key] = filter_input(
                        INPUT_POST,
                        $key,
                        FILTER_SANITIZE_SPECIAL_CHARS,
                        FILTER_REQUIRE_ARRAY
                    );
                } else {
                    $bodyArr[$key] = filter_input(
                        INPUT_POST,
                        $key,
                        FILTER_SANITIZE_SPECIAL_CHARS
                    );
                }
            }
        }
    }

    return $bodyArr;
}

// Check if an input string is Email
function isEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Check if an input string is INT (Ex: $range = ['min_range'=>1, 'max_range'=>20])
function isNumberInt($number, $range = [])
{
    if (!empty($range)) {
        $options = ['options' => $range];
        return filter_var($number, FILTER_VALIDATE_INT, $options);
    } else {
        return filter_var($number, FILTER_VALIDATE_INT);
    }
}

// Check if an input string is Float (Ex: $range = ['min_range'=>1, 'max_range'=>20])
function isNumberFloat($number, $range = [])
{
    if (!empty($range)) {
        $options = ['options' => $range];
        return filter_var($number, FILTER_VALIDATE_FLOAT, $options);
    } else {
        return filter_var($number, FILTER_VALIDATE_FLOAT);
    }
}

// Check if an input string is VN phone number
function isPhone($phone): bool
{
    $checkFirstZero = false;

    if ($phone[0] == '0') {
        $checkFirstZero = true;
        $phone = substr($phone, 1);
    }

    $checkNumberLast = false;

    if (isNumberInt($phone) && strlen($phone) == 9) {
        $checkNumberLast = true;
    }

    if ($checkFirstZero && $checkNumberLast) {
        return true;
    }

    return false;
}

// Check if an input string is valid slug
function isSlug($slug): bool
{
    if (preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $slug)) {
        return true;
    }

    return false;
}

// Get contextual feedback messages (Ex: $context = 'success', 'danger', 'warning' )
function getMessage($msg, $context = 'primary'): ?string
{
    if (!empty($msg)) {
        return '<div class="alert alert-dismissible alert-default-' . $context . '">' .
            '<button type="button" class="close" data-dismiss="alert">&times;</button>'
            . $msg
            . '</div>';
    }

    return null;
}

// Check if the input field has an error
function isFormError($fieldName, $errors): bool
{
    if (!empty($errors[$fieldName])) {
        return true;
    }

    return false;
}

// Get form validation errors
function getFormErrorMsg($fieldName, $errors): ?string
{
    if (isFormError($fieldName, $errors)) {
        return '<small class="text-danger">' . reset($errors[$fieldName]) . '</small>';
    }

    return null;
}

// Get old form value
function getOldFormValue($fieldName, $oldData)
{
    if (!empty($oldData[$fieldName])) {
        return $oldData[$fieldName];
    }

    return null;
}

function isLoggedIn(): bool
{
    if (getSession('login_token')) {
        $loginToken = getSession('login_token');

        // Check if $_SESSION['login_token'] exists in table 'login_tokens' (Log out of all devices)
        $sql = "SELECT user_id FROM login_tokens WHERE token=:token";
        $data = ['token' => $loginToken];
        $result = getFirstRow($sql, $data);

        if (!empty($result)) {
            // Check if user's status is active
            $sql = "SELECT status FROM users WHERE id=:id";
            $data = ['id' => $result['user_id']];
            $user = getFirstRow($sql, $data);
            if ($user['status'] == 1) {
                return true;
            }
        }
        removeSession();
    }

    return false;
}

// Auto logout after $duration seconds since 'last_activity' on current device
function autoLogoutAfterInactive($duration): void
{
    $now = time();
    $before = getSession('last_activity');
    if (!empty($before)) {
        if (($now - $before) >= $duration) {
            setFlashData('msg', 'Your session has timed out. Please sign in again!');
            setFlashData('msg_type', 'warning');
            redirect('admin/?module=auth&action=logout');
        }
    }
    setSession('last_activity', $now);
}

// Delete all 'login_token' of a user
function removeLoginTokens($userId): void
{
    $condition = "user_id=:user_id";
    $dataCondition = ['user_id' => $userId];
    delete('login_tokens', $condition, $dataCondition);
}


// Save 'last_activity' of a user
function saveLastActivity($userId): void
{
    $dataUpdate = ['last_activity' => date('Y-m-d H:i:s')];
    $condition = "id=:id";
    $dataCondition = ['id' => $userId];
    update('users', $dataUpdate, $condition, $dataCondition);
}

// Auto remove 'login_token' after $duration seconds since 'last_activity' of user
function autoRemoveLoginTokens($duration): void
{
    $sql = "SELECT * FROM users WHERE status=:status";
    $data = ['status' => 1];
    $allUsers = getAllRows($sql, $data);

    if (!empty($allUsers)) {
        foreach ($allUsers as $user) {
            $now = date('Y-m-d H:i:s');
            $before = $user['last_activity'];
            $diff = strtotime($now) - strtotime($before);

            if ($diff >= $duration) {
                // Delete all 'login_token' of a user
                removeLoginTokens($user['id']);
            }
        }
    }
}

// Get absolute URL for '<a href="">' (Admin Page)
function getAbsUrlAdmin($module = '', $action = '', $params = []): string
{
    $url = _WEB_HOST_ROOT_ADMIN . '/';
    if (!empty($module)) {
        $url .= '?module=' . $module;
    }

    if (!empty($action)) {
        $url .= '&action=' . $action;
    }

    if (!empty($params)) {
        $queryString = http_build_query($params);
        $url .= '&' . $queryString;
    }

    return $url;
}

// Check current module for adding '.active', '.menu-open' class to current element in the 'sidebar-menu'
function isActiveModule($module): bool
{
    $currentModule = getCurrentModule();
    if ($currentModule == $module) {
        return true;
    }

    return false;
}

// Check current action for adding '.active', '.menu-open' class to current element in the 'sidebar-menu'
function isActiveAction($module, $action): bool
{
    if (isActiveModule($module)) {
        $currentAction = getCurrentAction();
        if ($currentAction == $action) {
            return true;
        }
    }

    return false;
}

// Get user details
function getUserDetails($userId, $fields = '*')
{
    $sql = "SELECT " . $fields . " FROM users WHERE id=:id";
    $data = ['id' => $userId];

    return getFirstRow($sql, $data);
}

// Log '$userId' out of all devices
function logoutOfAllDevices($userId): void
{
    removeLoginTokens($userId);
    // Get flash message before remove all session variables
    $msg = getFlashData('msg');
    $msgType = getFlashData('msg_type');
    // Unset all session variables
    removeSession();
    // Then re-set flash message
    if (!empty($msg) && !empty($msgType)) {
        setFlashData('msg', $msg);
        setFlashData('msg_type', $msgType);
    }

    redirect('admin/?module=auth&action=login');
}

// Get a date formatted according to the specified format and datetime string.
function getFormattedDate($dateStr, $format = 'H:i:s d-m-Y')
{
    $dateObj = date_create($dateStr);
    if (!empty($dateObj)) {
        return date_format($dateObj, $format);
    }

    return null;
}


// Get query string of search form
function getSearchQueryString($module, $action, $currentPage)
{
    if (!empty($_SERVER['QUERY_STRING'])) {
        $queryString = $_SERVER['QUERY_STRING'];
        $queryString = str_replace('module=' . $module, '', $queryString);
        $queryString = str_replace('&action=' . $action, '', $queryString);
        return str_replace('&page=' . $currentPage, '', $queryString);
    }

    return null;
}

//  Check if a string contains a given substring
function strContains($haystack, $needle): bool
{
    $pos = strpos($haystack, $needle);
    if ($pos !== false) {
        return true;
    }

    return false;
}

// Check if $str is font-awesome icon tag
function isFontIcon($htmlStr): bool
{
    if (preg_match('/^(<i class="fa)[bdlrs]? fa(-[a-z]+)+("><\/i>)$/', $htmlStr)) {
        return true;
    }

    return false;
}