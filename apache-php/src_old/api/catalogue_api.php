<?php require_once '../_helper.php';
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            addItem();
            break;
        case 'DELETE':
            removeItemByName();
            break;
        case 'PATCH':
            updateItemCostByName();
            break;
        case 'GET':
            getItemByName();
            break;
        default:
            outputStatus(2, 'Invalid Mode');
    }
}
catch (Exception $e) {
    $message = $e->getMessage();
    outputStatus(2, $message);
}


function addItem()
{
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    if (!isset($data['name']) || !isset($data['cost']) || !isset($data['desc'])) {
        throw new Exception("No input provided");
    }
    $toyName = $data['name'];
    $toyDesc = $data['desc'];
    $toyCost = $data['cost'];
    $mysqli = openMysqli();
    $result = $mysqli->query("SELECT * FROM toys WHERE title = '{$toyName}';");
    if ($result->num_rows === 1) {
        $message = $toyName . ' already exists';
        outputStatus(1, $message);
    }
    else {
    $query = "INSERT INTO toys (title, description, cost)
        VALUES ('" . $toyName . "', '" . $toyDesc . "', " . $toyCost . ");";
        $mysqli->query($query);
        $mysqli->close();
        $message = 'Added ' . $toyName . ' with cost of ' . $toyCost;
        outputStatus(0, $message);
    }
}
function removeItemByName()
{
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    if (!isset($data['name'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $toyName = $data['name'];
    $result = $mysqli->query("SELECT * FROM toys WHERE title = '{$toyName}';");
    if ($result->num_rows === 1) {
        $query = "DELETE FROM toys WHERE title = '" . $toyName . "';";
        $mysqli->query($query);
        $mysqli->close();
        $message = 'Removed ' . $toyName;
        outputStatus(0, $message);
    } else {
        $message = $toyName . ' does not exist';
        outputStatus(1, $message);
    }
}
function updateItemCostByName()
{
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    if (!isset($data['name']) || !isset($data['cost'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $toyName = $data['name'];
    $toyCost = $data['cost'];
    $result = $mysqli->query("SELECT * FROM toys WHERE title = '{$toyName}';");
    if ($result->num_rows === 1) {
        $query = "UPDATE toys SET cost = " . $toyCost . " WHERE title = '" . $toyName . "';";
        $mysqli->query($query);
        $mysqli->close();
        $message = 'Updated ' . $toyName . ' with cost of ' . $toyCost;
        outputStatus(0, $message);
    } else {
        $message = $toyName . ' does not exist';
        outputStatus(1, $message);
    }
}
function getItemByName()
{
    if (!isset($_GET['name'])) {
        throw new Exception("No input provided");
    }
    $mysqli = openMysqli();
    $toyName = $_GET['name'];
    $query = "SELECT * FROM toys WHERE title = '{$toyName}';";
    $result = $mysqli->query($query);
    if ($result->num_rows === 1) {
        foreach ($result as $toy) {
            echo "{status: 0, name: '" . $toy['title'] . "', description: '" . $toy['description'] . "', cost: " . $toy['cost'] . "}";
        }
        $mysqli->close();
    } else {
        $message = $toyName . ' does not exist';
        outputStatus(1, $message);
    }
}
?>