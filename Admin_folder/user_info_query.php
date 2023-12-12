<?php
include_once __DIR__ . '/admin_sessions/admin_session.php';
include_once __DIR__ . '/admin_sessions/admin_login_state.php';
include __DIR__ . '/adminHeader.php';
include __DIR__ . '/adminMenu.php';
include_once __DIR__ . '/../db/db.php';
$database = new Database();
// 定义每页显示的记录数
$perPage = 5;
// 获取当前页数
//$page = isset($_POST['send_param']) && is_numeric($_POST['send_param']) ? $_POST['send_param'] : 1;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
// 计算查询的偏移量
$offset = ($page - 1) * $perPage;
// 查询数据
$table = 'tb_users';                    // 用户表
$where = '';                            // 可选的查询条件
$params = array();                      // 可选的查询参数
$fields = array('*');                   // 所有字段
$order = '';                            // 可选的排序字段和顺序
$limit = $offset . ',' . $perPage;      // 分页限制

$results = $database->select($table, $where, $params, $fields, $order, $limit);

?>
    <main class="flex-shrink-0">
        <div class="container mt-lg-4">
            <table class="table table-primary table-hover caption-top text-center">
                <caption class="text-primary">用户信息表</caption>
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">用户ID</th>
                    <th scope="col">用户姓名</th>
                    <th scope="col">用户修改</th>
                    <th scope="col">用户密码重置</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                <?php foreach ($results as $row) { ?>
                    <tr>
                        <th scope="row"><?php echo $row['id']; ?></th>
                        <td><?php echo $row['uid']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><a class="btn btn-outline-success btn-sm"
                               style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .7rem;"
                               href="user_info_set.php?uid=<?php echo base64_encode($row['uid']); ?>">修改</a>
                        </td>
                        <td><a class="btn btn-outline-success btn-sm"
                               style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .7rem;"
                               href="user_pwd_reset.php?uid=<?php echo base64_encode($row['uid']); ?>">密码重置</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php
            $totalRecords = $database->select($table);   // 获取记录总数
            $totalPages = ceil((count($totalRecords)) / $perPage);
            ?>
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php for ($y = 1; $y <= $totalPages; $y++) : ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="user_info_query.php?page=<?php echo $y; ?>"><?php echo $y; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>
<?php include __DIR__ . '/adminFooter.php'; ?>