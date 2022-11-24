<?php require_once '../_helper.php';
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            addUser();
            break;
        case 'DELETE':
            removeUser();
            break;
        case 'PATCH':
            updateUserPassword();
            break;
        case 'GET':
            getUserByID();
            break;
        default:
            outputStatus(2, 'Invalid Mode');
    }
}
catch (Exception $e) {
    $message = $e->getMessage();
    outputStatus(2, $message);
};

function addUser() {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    if (!isset($data['name']) || !isset($data['pass'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $usrName = $data['name'];
    $usrPass = $data['pass'];
    $result = $mysqli->query("SELECT * FROM users WHERE name = '{$usrName}';");
    if ($result->num_rows === 1) {
        $message = 'User '. $usrName . ' already exists';
        outputStatus(1, $message);
    } else {
        $usrPass = generatePass($usrName, $usrPass);
        $query = "INSERT INTO users (name, password)
        VALUES ('" . $usrName . "', '" . $usrPass . "');";
        $mysqli->query($query);
        $mysqli->close();
        $message = 'Added user ' . $usrName;
        outputStatus(0, $message);
    }
}
function removeUser()
{
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    if (!isset($data['name'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $usrName = $data['name'];
    $result = $mysqli->query("SELECT * FROM users WHERE name = '{$usrName}';");
    if ($result->num_rows === 1) {
        $query = "DELETE FROM users WHERE name = '" . $usrName . "';";
        $mysqli->query($query);
        $mysqli->close();
        $message = 'Removed user ' . $usrName;
        outputStatus(0, $message);
    } else {
        $message = 'User ' . $usrName . ' does not exist';
        outputStatus(1, $message);
    }
}
function updateUserPassword()
{
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    if (!isset($data['name']) || !isset($data['pass'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $usrName = $data['name'];
    $usrPass = $data['pass'];
    $result = $mysqli->query("SELECT * FROM users WHERE name = '{$usrName}';");
    if ($result->num_rows === 1) {
        $usrPass = generatePass($usrName, $usrPass);
        $query = "UPDATE users SET password = '" . $usrPass . "' WHERE name = '" . $usrName . "';";
        $mysqli->query($query);
        $mysqli->close();
        $message = 'Changed password for ' . $usrName;
        outputStatus(0, $message);
    } else {
        $message = $usrName . ' does not exist';
        outputStatus(1, $message);
    }
}
function getUserByID()
{
    if (!isset($_GET['id'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $usrID = $_GET['id'];
    $result = $mysqli->query("SELECT * FROM users WHERE ID = '{$usrID}';");
    if ($result->num_rows === 1) {
        foreach ($result as $info) {
            echo "{status: 0, name: '" . $info['name'] . "}";
        }
        $mysqli->close();
    } else {
        $message = 'User ID '. $usrID . ' does not exist';
        outputStatus(1, $message);
    }
}
function generatePass($usrName, $usrPass) {
    $cmd = "htpasswd -nb {$usrName} {$usrPass}";
    exec($cmd, $output);
    $str = implode('', $output);
    $str = preg_replace('/^' . $usrName . ':/', '', $str);
    return $str;
}