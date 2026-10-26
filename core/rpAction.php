<?php
/**
 * Perform a secure database action using prepared statements.
 *
 * This improved version adds flexibility for SELECT statements and returns the last insert ID for INSERTs.
 * It also includes more robust parameter binding based on data types.
 *
 * @param string $table The name of the table.
 * @param int $action The action code (1=INSERT, 2=UPDATE, 3=DELETE, 4=SELECT).
 * @param array $data The associative array of data to insert or update.
 * @param array $options Optional settings for the query (e.g., where, orderBy, limit).
 * @return array The result of the operation.
 *POS Version By Rahulphp6 v4.0 */
function secureDbAction($table, $action, $data = [], $where = '', $params = [])
{
    $conn = OpenCon();

    // Sanitize table name
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        return ['success' => false, 'error' => 'Invalid table name.'];
    }

    $sql = '';
    $types = '';
    $bindValues = [];

    try {
        switch ($action) {
            case 1: // INSERT
                $columns = implode(', ', array_map(fn($k) => "`$k`", array_keys($data)));
                $placeholders = implode(', ', array_fill(0, count($data), '?'));
                $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";
                $bindValues = array_values($data);
                foreach ($bindValues as $value) {
                    $types .= getParamType($value);
                }
                break;

            case 2: // UPDATE
                if (empty($where)) {
                    return ['success' => false, 'error' => 'Missing WHERE clause for update.'];
                }
                $set = implode(', ', array_map(fn($k) => "`$k` = ?", array_keys($data)));
                $sql = "UPDATE `$table` SET $set WHERE $where";
                $bindValues = array_merge(array_values($data), $params);
                foreach ($bindValues as $value) {
                    $types .= getParamType($value);
                }
                break;

            case 3: // DELETE
                if (empty($where)) {
                    return ['success' => false, 'error' => 'Missing WHERE clause for delete.'];
                }
                $sql = "DELETE FROM `$table` WHERE $where";
                $bindValues = $params;
                foreach ($bindValues as $value) {
                    $types .= getParamType($value);
                }
                break;

            case 4: // SELECT
                $columns = $data['columns'] ?? '*';
                $orderBy = $data['orderBy'] ?? '';
                $limit = isset($data['limit']) ? (int) $data['limit'] : '';
                $offset = isset($data['offset']) ? (int) $data['offset'] : null;

                // Updated regex to preserve SQL functions, parentheses, quotes, operators, and commas
                $columns = preg_replace('/[^\w\s,\`\*\(\)\-\+\=\<\>""\'\.]/', '', $columns);
                $orderBy = preg_replace('/[^a-zA-Z0-9_,`\s]+/', '', $orderBy);

                $sql = "SELECT $columns FROM `$table`";
                if ($where)
                    $sql .= " WHERE $where";
                if ($orderBy)
                    $sql .= " ORDER BY $orderBy";
                if ($limit)
                    $sql .= " LIMIT $limit";
                if ($offset !== null)
                    $sql .= " OFFSET $offset";

                $bindValues = $params;
                foreach ($bindValues as $value) {
                    $types .= getParamType($value);
                }
                break;

            case 5: // META - get column names
                // Use INFORMATION_SCHEMA for portability
                $sql = "SELECT COLUMN_NAME 
                        FROM INFORMATION_SCHEMA.COLUMNS 
                        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?";
                $bindValues = [$_ENV['DB_NAME'], $table];
                foreach ($bindValues as $value) {
                    $types .= getParamType($value);
                }
                break;

            default:
                return ['success' => false, 'error' => 'Invalid action code'];
        }

        $stmt = $conn->prepare($sql);
        if (!$stmt)
            throw new Exception($conn->error);

        if (!empty($bindValues)) {
            $stmt->bind_param($types, ...$bindValues);
        }

        $stmt->execute();
        $debugMode = isset($data['debug']) && $data['debug'] === true;
        if ($action === 1) {
            // $log = date('Y-m-d H:i:s') . " | INSERT: $sql\nValues: " . json_encode($bindValues) . "\n\n";
            // file_put_contents(__DIR__ . '/insert_debug.log', $log, FILE_APPEND);
            if ($stmt->affected_rows === 0 || $conn->insert_id === 0) {
                return [
                    'success' => false,
                    'error' => $conn->error ?: 'Insert failed',
                    'query' => $sql
                ];
            }

            return [
                'success' => true,
                'insert_id' => $conn->insert_id
            ];
        }

        if ($action === 4) {
            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            return ['success' => true, 'data' => $rows, 'query' => $debugMode ? $sql : null];
        }

        if ($action === 5) {
            $result = $stmt->get_result();
            $cols = $result->fetch_all(MYSQLI_ASSOC);
            // Flatten to just column names
            $fields = array_column($cols, 'COLUMN_NAME');
            return ['success' => true, 'data' => $fields];
        }

        return ['success' => true, 'affected_rows' => $stmt->affected_rows, 'query' => $sql . json_encode($bindValues)];
    } catch (Exception $e) {
        $logMessage = date('Y-m-d H:i:s') . " | ERROR: " . $e->getMessage() . "\nSQL: " . $sql . "\n\n";
        file_put_contents(__DIR__ . '/db_errors.log', $logMessage, FILE_APPEND);

        return [
            'success' => false,
            'error' => $e->getMessage(),
            'query' => $sql
        ];
    }
}
/**
 * Helper function to determine the parameter type for mysqli::bind_param.
 *
 * @param mixed $param The parameter to check.
 * @return string The type character ('s', 'i', 'd').
 */
function getParamType($param)
{
    if (is_int($param)) {
        return 'i';
    } elseif (is_float($param)) {
        return 'd';
    } else {
        return 's';
    }
}
function flattenStdClass($data)
{
    if (is_object($data)) {
        $data = (array) $data;
    }
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = flattenStdClass($value);
        }
    }
    return $data;
}

function dbAction($table_name, $operation = 0, $form_data = "", $where_clause = "", $debug = 0, $db = db)
{
    $conn = OpenCon($db);
    $dbActionStatus = [];

    // Auto-fill from $_POST if needed
    if (empty($form_data) && $operation < 3) {
        $form_data = $_POST;
        array_pop($form_data); // remove submit button
    }

    if (!is_array($form_data)) {
        $form_data = [];
    }

    // ✅ Sanitize values: convert arrays/objects to JSON strings
    foreach ($form_data as $key => $val) {
        if (is_array($val) || is_object($val)) {
            $form_data[$key] = json_encode($val, JSON_UNESCAPED_UNICODE);
        }
    }

    $fields = array_keys($form_data);
    $values = array_values($form_data);

    // Prepare WHERE clause
    $whereSQL = '';
    if (!empty($where_clause)) {
        $whereSQL = strtoupper(substr(trim($where_clause), 0, 5)) === 'WHERE'
            ? " " . trim($where_clause)
            : " WHERE " . $where_clause;
    }

    $sql = '';
    $types = '';
    $bindValues = [];

    try {
        switch ($operation) {
            case 1: // INSERT
                $columns = implode(', ', array_map(fn($k) => "`$k`", $fields));
                $placeholders = implode(', ', array_fill(0, count($values), '?'));
                $sql = "INSERT INTO `$table_name` ($columns) VALUES ($placeholders)";
                $bindValues = $values;
                break;

            case 2: // UPDATE
                if (empty($whereSQL)) {
                    // mysqli_close removed
                    return [0, 'Missing WHERE clause for update'];
                }
                $set = implode(', ', array_map(fn($k) => "`$k` = ?", $fields));
                $sql = "UPDATE `$table_name` SET $set $whereSQL";
                $bindValues = $values;
                break;

            case 3: // DELETE
                if (empty($whereSQL)) {
                    // mysqli_close removed
                    return [0, 'Missing WHERE clause for delete'];
                }
                $sql = "DELETE FROM `$table_name` $whereSQL";
                break;

            case 4: // SELECT
                $sql = "SELECT * FROM `$table_name` $whereSQL";
                if ($debug) {
                    echo $sql . " DB:" . $db;
                }
                $result = mysqli_query($conn, $sql);
                // mysqli_close removed
                return $result;

            case 5: // META: get column names
                $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?";
                $bindValues = [$db, $table_name];
                $types = 'ss';
                $stmt = $conn->prepare($sql);
                if (!$stmt)
                    throw new Exception($conn->error);

                $stmt->bind_param($types, ...$bindValues);
                $stmt->execute();
                $result = $stmt->get_result();
                $cols = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
                // mysqli_close removed
                return array_column($cols, 'COLUMN_NAME');
        }

        // Bind types for INSERT/UPDATE
        foreach ($bindValues as $val) {
            $types .= is_int($val) ? 'i' : (is_float($val) ? 'd' : 's');
        }

        // Execute INSERT/UPDATE/DELETE
        if (in_array($operation, [1, 2, 3])) {
            $stmt = $conn->prepare($sql);
            if (!$stmt)
                throw new Exception($conn->error);

            if (!empty($bindValues)) {
                $stmt->bind_param($types, ...$bindValues);
            }
            $run = $stmt->execute();

            if ($debug) {
                echo $sql . " DB:" . $db;
            }

            $dbActionStatus = $run ? [1, $sql] : [0, $stmt->error];
            $stmt->close(); // ✅ Statement close karna safe hai
            // mysqli_close removed
            return $dbActionStatus;
        }

    } catch (Exception $e) {
        $log = date('Y-m-d H:i:s') . " | ERROR: " . $e->getMessage() . "\nSQL: $sql\n\n";
        file_put_contents(__DIR__ . '/db_errors.log', $log, FILE_APPEND);
        // mysqli_close removed
        return [0, $e->getMessage()];
    }

    // mysqli_close removed
    return [0, 'No valid operation matched'];
}
function safePost($key, $default = '', $sanitize = true)
{
    if (!isset($_POST[$key]))
        return $default;
    $value = $_POST[$key];
    if ($sanitize && is_string($value)) {
        $value = trim($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $value;
}

function safeGet($key, $default = '', $sanitize = true)
{
    if (!isset($_GET[$key]))
        return $default;
    $value = $_GET[$key];
    if ($sanitize && is_string($value)) {
        $value = trim($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $value;
}

function safePostInt($key, $default = 0)
{
    return isset($_POST[$key]) ? intval($_POST[$key]) : $default;
}

function safeGetInt($key, $default = 0)
{
    return isset($_GET[$key]) ? intval($_GET[$key]) : $default;
}

function safePostBool($key)
{
    return isset($_POST[$key]) && ($_POST[$key] === '1' || $_POST[$key] === 'true');
}

function safeGetBool($key)
{
    return isset($_GET[$key]) && ($_GET[$key] === '1' || $_GET[$key] === 'true');
}
function redirectTo($path = '', $delay = 0, $message = '', $errortype = 'success')
{
    $script = basename($_SERVER['SCRIPT_NAME']);
    $base = rtrim(BASE_URL, '/');

    // Build URL
    if ($path === '') {
        $url = $base;
    } elseif (strpos($path, '?') === 0) {
        // Prepend current script name if path starts with "?"
        $url = $base . '/' . $script . $path;
    } else {
        $url = $base . '/' . ltrim($path, '/');
    }

    // If headers not sent, use Location/Refresh
    if (!headers_sent()) {
        if ($delay > 0) {
            header("Refresh: $delay; URL=$url");
            if ($message) {
                echo "<script>boom('{$message}', '{$errortype}',true);</script>";
            }
        } else {
            header("Location: $url");
            if ($message) {
                // Optional: show toast immediately before redirect
                echo "<script>boom('{$message}', '{$errortype}',true);</script>";
            }
        }
        exit;
    }

    // JS fallback if headers already sent
    echo "<script>
        " . (!empty($message) ? "boom('{$message}', '{$errortype}', true);" : "") . "
        setTimeout(() => { 
            window.location.href = '{$url}'; 
        }, " . ($delay * 1000) . ");
    </script>";

    exit;
}

// end pos v4.0
function filterThis($string, $db = db)
{
    $conn = OpenCon($db);
    if (is_string($string)) {
        return @mysqli_real_escape_string($conn, $string);
    }
    mysqli_close($conn);
}
function array_map_deep($array, $callback)
{
    $new = array();
    foreach ($array as $key => $val) {
        if (is_array($val)) {
            $new[$key] = array_map_deep($val, $callback);
        } else {
            $new[$key] = call_user_func($callback, $val);
        }
    }
    return $new;
}
function is_multi($array)
{
    $rv = array_filter($array, 'is_array');
    if (count($rv) > 0)
        return true;
    return false;
}

function queryRun($query, $debug = 0, $db = db)
{
    $conn = OpenCon($db);

    if ($debug == 1) {
        print $query . " DB:" . $db;
        //die();
    }

    if ($debug == 3) {
        $query = $conn->query($query);

        if ($query == false) {
            echo "Error: " . mysqli_error($conn);
        }

        if ($query == true) {
            return $query;
        }
    }

    mysqli_close($conn);
}
function isAdmin()
{
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] >= 0 and $_SESSION['role'] <= 3) {
            return true;
        } else {
            return false;
        }
    }
}
function isUser($action = '')
{
    // 🔍 Branch-specific logic
    if (!empty($action) && $action === 'location') {
        $userId = defined('user_id') ? user_id : ($_SESSION['user_id'] ?? 0);
        $storeId = defined(constant_name: 'organizationId') ? organizationId : ($_SESSION['store'] ?? 0);

        $getUserBranch = getRow("user_locations", '', '', "WHERE user_id = $userId AND store = $storeId", 2);

        if (!empty($getUserBranch['location_id'])) {
            return $getUserBranch['location_id'];
        }

        return null; // fallback if no branch found
    }

    // ✅ Role-based check
    if (isset($_SESSION['role']) && $_SESSION['role'] > 3) {
        return true;
    } else {
        return false;
    }
}
function checkUser()
{
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] > 7) {
            return true;
        } else {
            return false;
        }
    }
}
function isShop()
{
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] >= 0) {
            return true;
        } else {
            return false;
        }
    }
}
function isSuper()
{
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 1) {
            return true;
        } else {
            return false;
        }
    }
}
function getName($table, $id, $type = 0, $name = 'name', $id_name = '', $db = db)
{
    $conn = OpenCon($db);
    $query = "SELECT * FROM $table where id=" . $id;
    if ($table == 'groups') {
        $query = "SELECT * FROM $table where group_id=" . $id;
    }
    if ($table == 'customers') {
        $query = "SELECT * FROM $table where contact_id='" . $id . "'";
    }
    if (!empty($id_name)) {
        $query = "SELECT * FROM $table where $id_name='" . $id . "'";
    }
    $name_result = $conn->query($query);

    if ($name_result->num_rows > 0) {
        $row = $name_result->fetch_assoc();
        if ($type == 0) {
            echo $row[$name];
        }
        if ($type == 1) {
            return $row[$name];
        }
        if ($type == 2) {
            return $row;
        }
    }

    mysqli_close($conn);
}
function getRow($table, $id = '', $name = '', $where_clause = '', $type = 0, $db = db)
{
    $conn = OpenCon($db);
    $query = '';

    // ✅ Build query safely
    if (!empty($where_clause)) {
        $query = "SELECT * FROM $table " . trim($where_clause);
    } elseif (!empty($id)) {
        if ($table === 'profile') {
            $query = "SELECT * FROM $table WHERE u_id = " . (int) $id;
        } else {
            $query = "SELECT * FROM $table WHERE id = " . (int) $id;
        }
    } else {
        // mysqli_close removed
        return null; // ❌ No valid query
    }

    if ($table == 'user_loactions') {
        // echo $query;
    }

    $name_result = $conn->query($query);
    $row = null;

    if ($name_result && $name_result->num_rows > 0) {
        $row = $name_result->fetch_assoc();

        if ($type === 0 && isset($row[$name])) {
            echo $row[$name];
        } elseif ($type === 1 && isset($row[$name])) {
            return $row[$name];
        } elseif ($type === 2) {
            return $row;
        }
    }
    return null;
}
function getRowById($table, $id, $column = 'id', $db = db)
{
    // 🔧 Build WHERE clause and parameter
    $where = "$column = ?";
    $params = [$id];

    // 🔍 Use secureDbAction for safe SELECT
    $result = secureDbAction($table, 4, [], $where, $params);

    // ✅ Return single row or null
    return (isset($result)) ? $result['data'][0] : null;
}
function lastId($table_name, $db = db)
{
    $conn = OpenCon($db);
    $query = "SELECT id FROM $table_name ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Could not query:' . mysqli_error($conn));
    }
    $id = mysqli_fetch_assoc($result);
    return $id;
}

function table_sum($table, $col, $limits = '', $db = db)
{
    $conn = OpenCon($db);
    $sum_q = "SELECT *, SUM($col) AS Total FROM $table WHERE MONTH(date) = MONTH(CURDATE()) AND status=1 ORDER BY Total DESC";
    if ($limits != "") {
        $sum_q .= " LIMIT " . $limits;
    }
    $sum_run = mysqli_query($conn, $sum_q);
    return $sum_run;
    mysqli_close($conn);
}
function progress($value, $max, $type = 0)
{
    $max = $max;

    $value = $value;

    $scale = 1.0;

    if (!empty($max)) {
        $percent = ($value * 100) / $max;
    } else {
        $percent = 0;
    }

    // Limit to 100 percent (if more than the max is allowed)

    if ($percent > 100) {
        $percent = 100;
    }
    if ($type) {
        return number_format($percent, 2);
    } else {
        echo number_format($percent, 2);
    }
}
function colSum($table, $col, $where_clause = '', $db = db)
{
    $conn = OpenCon($db);
    $sum_q = "SELECT SUM($col) AS Total FROM $table";
    if ($where_clause != "") {
        $sum_q .= " WHERE " . $where_clause;
    }
    if ($table == "report") {
        // echo $sum_q."<br>";
    }
    $sum_run = mysqli_query($conn, $sum_q);
    return $sum_run;
    mysqli_close($conn);
}
function getTotal($table, $col, $where_clause = '', $db = db)
{
    $Total = 0;
    $query = "SELECT SUM($col) AS Total FROM $table";
    if ($where_clause != "") {
        $query .= " WHERE " . $where_clause;
    }
    $excute = queryRun($query, 3, $db);
    if ($excute->num_rows > 0) {
        $tot = $excute->fetch_assoc();
        if (isset($tot['Total'])) {
            $Total = $tot['Total'];
        }
    }
    return $Total;
}
// permissions
function isPermMode($role, $ModuleKey)
{
    $perFetch = dbAction('permission_role', 4, '', 'role_id=' . $role);
    if ($perFetch->num_rows > 0) {
        $isPerm = array();
        foreach ($perFetch as $permData) {
            $permName = getRow('permissions', $permData['permission_id'], 'name', '', 1);
            // print_r($permName);
            if (!empty($permName)) {
                $fileName = strtolower($permName);
                $first_name = explode("-", $fileName);
                if (isset($first_name[0])) {
                    $fileName = $first_name[0];
                }
                // echo strtolower($fileName) . "=" . strtolower($ModuleKey) . "<br>";
                if (strtolower($fileName) == strtolower($ModuleKey)) {
                    if ($permData['isRead'] == 1) {
                        //echo $permData['isRead'];
                        $isPerm[] = "1";
                    } else {
                        $isPerm[] = "0";
                    }
                    if ($permData['isWrite'] == 1) {
                        $isPerm[] = "1";
                    } else {
                        $isPerm[] = "0";
                    }

                    if ($permData['isEdit'] == 1) {
                        $isPerm[] = "1";
                    } else {
                        $isPerm[] = "0";
                    }

                    if ($permData['isDelete'] == 1) {
                        $isPerm[] = "1";
                    } else {
                        $isPerm[] = "0";
                    }
                }
            }
        }
        return $isPerm;
        //print_r($isPerm);
    }
}
function mgs($mgs = 'Action Permormed Successfully!', $key = 1)
{
    if ($key) {
        echo '<div class="alert alert-success alert-dismissible text-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-check"></i> ' . $mgs . '</div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible text-sm"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-ban"></i> ' . $mgs . '</div>';
    }
}
function alert($mgs = 'Action Permormed Successfully!', $key = 1)
{
    if ($key) {
        $icon = "success";
    } else {
        $icon = "error";
    } ?>
    <script>
        boom($mgs, $icon, true);
    </script>
    <?php
}
function isModCheck($name)
{
    $name = strtolower($name);
    $first_name = explode("-", $name);
    if (isset($first_name[0])) {
        $name = $first_name[0];
    }
    if ($name != 'permissions') {
        $query = "SELECT * from permissions where name='" . $name . "' AND status=1";
        // echo $query;
        $check_mod = queryRun($query, 3);
        if ($check_mod->num_rows > 0) {
            $row = $check_mod->fetch_assoc();
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}
/**
 * Advanced Universal Dropdown Generator
 * Replaces: dropdown(), elements(), diffElement(), selectElement()
 */
function renderDropdown($name, $table, $title = '', $selectedId = 0, $options = [])
{
    // 1. Defaults Set Karein
    $valCol = $options['val_col'] ?? 'id';
    $textCol = $options['text_col'] ?? 'name';
    $class = $options['class'] ?? 'form-control select2bs4';
    $wrapper = $options['wrapper'] ?? true;
    $req = !empty($options['required']) ? 'required' : '';
    $storeId = defined('organizationId') ? intval(organizationId) : 0;

    // Quick Add Modal enable karne ka flag (default true ya options se control)
    $showAddBtn = $options['add_modal'] ?? true;

    // Default WHERE condition
    $where = $options['where'] ?? "status=1";

    // Auto-append store filter
    if (!isset($options['use_store']) || $options['use_store'] === true) {
        if ($storeId)
            $where .= " AND store=$storeId";
    }

    $extraHtml = '';

    // 2. Table Specific Logic
    if ($table === 'roles' && !empty($options['filter_roles'])) {
        $where .= ' AND id>2';
    }

    // 3. Database Fetch Logic
    if (!empty($options['group_by'])) {
        $dbConn = $options['db'] ?? db;
        $query = "SELECT * FROM $table WHERE $where GROUP BY " . $options['group_by'];
        $rows = queryRun($query, 3, $dbConn);
    } else {
        $rows = dbAction($table, 4, '', $where, 0);
    }
    // 4. HTML Generation
    $html = '';

    if ($wrapper) {
        $html .= '<div class="form-group mb-3 dynamicselect">';
    }

    // Label render
    if (!empty($title)) {
        $html .= "<label class='form-label text-muted'>$title</label>$extraHtml";
    }

    // Agar Quick Add Button chahiye toh Bootstrap input-group use hoga
    if ($showAddBtn) {
        $html .= '<div class="input-group d-flex align-items-center">';
    }

    // Select tag start (flex-grow dena zaroori hai taaki yeh poori available width le le)
    $disabled = !empty($options['disabled']) ? 'disabled' : '';
    $html .= "<select class='$class flex-grow-1' name='$name' id='$name' $req $disabled>";

    // Default Option
    $defaultText = !empty($title) ? "--$title--" : "--Select Option--";
    $html .= "<option value=''>$defaultText</option>";

    // Populate Data
    foreach ($rows as $r) {
        $val = $r[$valCol] ?? '';
        $text = $r[$textCol] ?? '';
        $keynames = renderColName($table);
        $val = $r[$keynames[0]] ?? $valCol;
        $text = $r[$keynames[1]] ?? $textCol;
        $sel = ($val !== '' && $val == $selectedId) ? ' selected' : '';

        $attr = '';
        if (isset($r['user_id'])) {
            $attr .= " data-user_id='{$r['user_id']}'";
        }

        $html .= "<option value='$val'$sel$attr>$text</option>";
    }

    $html .= "</select>";
    if ($showAddBtn) {
        $html .= "<button type='button' class='btn btn-light quick-add-btn' data-bs-toggle='offcanvas'  data-bs-target='#crudCanvas' data-table='" . $table . "' data-select-id='" . $name . "' data-title='" . $title . "' title='Add New " . $title . "' style='padding: 6px 10px'><i class='fa fa-plus'></i></button>";
        $html .= '</div>';
    }
    if ($wrapper) {
        $html .= "</div>";
    }

    echo $html;
}
function renderColName($table, $colId = 'id', $colName = 'name')
{
    // Default values initialize karein
    $val = $colId;
    $text = $colName;
    // PHP mein array return karein
    return [$val, $text];
}