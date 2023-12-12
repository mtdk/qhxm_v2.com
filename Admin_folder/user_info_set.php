<?php
include_once __DIR__ . '/admin_sessions/admin_session.php';
include_once __DIR__ . '/admin_sessions/admin_login_state.php';
include __DIR__ . '/adminHeader.php';
include __DIR__ . '/adminMenu.php';
include_once __DIR__ . '/../db/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $uid = trim(base64_decode(htmlspecialchars($_GET['uid'])));
}
//$uid = '946448OXG10O56MV';
$database = new Database();
$table = 'tb_users';                    // 用户表
$where = 'uid = :uid';                            // 可选的查询条件
$params = array(':uid' => $uid);                      // 可选的查询参数
$fields = array('*');                   // 所有字段

$results = $database->select($table, $where, $params, $fields);

if ($results) {
    $username = $results[0]['username'];
    $department_id = $results[0]['department_id'];
    $role_id = $results[0]['role_id'];
    $userstate_id = $results[0]['userstate_id'];
}

$table_departments = 'tb_departments';
$dep_where = '';
$dep_params = array();
$dep_fields = array('department_id', 'department_name');
$dep_results = $database->select($table_departments, $dep_where, $dep_params, $dep_fields);

$table_role = 'tb_role';
$role_where = '';
$role_params = array();
$role_fields = array('role_id', 'role_name');
$role_results = $database->select($table_role, $role_where, $role_params, $role_fields);

$table_userstate = 'tb_userstate';
$ustate_where = '';
$ustate_params = array();
$ustate_fields = array('userstate_id', 'userstate_name');
$ustate_results = $database->select($table_userstate, $ustate_where, $ustate_params, $ustate_fields);
?>
    <main class="flex-shrink-0">
        <div class="container mt-lg-4">
            <div class="row">
                <div class="text-center mb-2">
                    <h2>分散设备运行记录</h2>
                </div>
            </div>
            <form class="row g-3 needs-validation" novalidate action="user_info_save.php" method="post">
                <div class="col-sm-2">
                    <label for="uid" class="form-label">用户ID</label>
                    <input type="text" class="form-control" id="uid" value="<?php echo $uid; ?>"
                           name="uid" readonly required>
                    <div class="invalid-feedback">
                        用户ID不能为空...
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="user_name" class="form-label">用户名</label>
                    <input type="text" class="form-control" id="user_name" value="<?php echo $username; ?>"
                           name="user_name" required>
                    <div class="invalid-feedback">
                        用户名不能为空...
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="department_id" class="form-label">用户部门</label>
                    <select name="department_id" class="form-select" id="department_id" required>
                        <option value="">请选择...</option>
                        <?php
                        foreach ($dep_results as $dep_value) {
                            if ($dep_value['department_id'] == $department_id) {
                                echo "<option selected value=" . $dep_value['department_id'] . ">" . $dep_value['department_name'] . "</option>";
                            } else {
                                echo "<option value=" . $dep_value['department_id'] . ">" . $dep_value['department_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        请选择用户...
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="role_id" class="form-label">用户权限</label>
                    <select name="role_id" class="form-select" id="role_id" required>
                        <option value="">请选择...</option>
                        <?php foreach ($role_results as $role_value) {
                            if ($role_value['role_id'] == $role_id) {
                                echo "<option selected value=" . $role_value['role_id'] . ">" . $role_value['role_name'] . "</option>";
                            } else {
                                echo "<option value=" . $role_value['role_id'] . ">" . $role_value['role_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        请选择用户权限...
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="userstate_id" class="form-label">用户状态</label>
                    <select name="userstate_id" class="form-select" id="userstate_id" required>
                        <option value="">请选择...</option>
                        <?php foreach ($ustate_results as $ustate_value) {
                            if ($ustate_value['userstate_id'] == $userstate_id) {
                                echo "<option selected value=" . $ustate_value['userstate_id'] . ">" . $ustate_value['userstate_name'] . "</option>";
                            } else {
                                echo "<option value=" . $ustate_value['userstate_id'] . ">" . $ustate_value['userstate_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        请选择用户状态...
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">提&nbsp;交&nbsp;保&nbsp;存</button>
                    <a class="btn btn-primary" href="user_info_query.php">返&nbsp;回</a>
                </div>
                <script>
                    (() => {
                        'use strict'

                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        const forms = document.querySelectorAll('.needs-validation')

                        // Loop over them and prevent submission
                        Array.from(forms).forEach(form => {
                            form.addEventListener('submit', event => {
                                if (!form.checkValidity()) {
                                    event.preventDefault()
                                    event.stopPropagation()
                                }

                                form.classList.add('was-validated')
                            }, false)
                        })
                    })()
                </script>
            </form>
        </div>
    </main>
<?php include __DIR__ . '/adminFooter.php'; ?>