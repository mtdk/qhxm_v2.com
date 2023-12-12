<?php

/**
 * 数据库操作
 */
class Database
{
    private string $host = 'localhost'; // 数据库主机名
    private string $user = 'mtdk'; // 数据库用户名
    private string $password = '12345678'; // 数据库密码
    private string $dbname = 'qhxm_v2'; // 数据库名称
    private PDO $dbh; // 数据库连接句柄
    private $error; // 错误信息

    public function __construct()
    {
        // 设置数据源名称（DSN）
        $dsn = "mysql:host=$this->host;dbname=$this->dbname";

        // 设置PDO选项
        $options = array(
            PDO::ATTR_PERSISTENT => true, // 持久连接
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // 抛出异常
        );

        // 创建PDO实例
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    // 新增数据
    /**
     * @param $table $数据表
     * @param $data $需要新增的数据
     * @return int      $返回受影响的记录数
     */
    public function insert($table, $data): int
    {
        $keys = array_keys($data);
        $values = array_values($data);
        $placeholders = implode(',', array_fill(0, count($values), '?'));

        $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES ($placeholders)";

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->rowCount();
    }

    // 修改数据

    /**
     * @param $table $数据表名
     * @param $data $需要更新的字段集
     * @param array $conditions $更新条件
     * @return int  $返回受影响的记录数
     */
    public function update($table, $data, array $conditions = array()): int
    {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ", ");
        $where = "";
        if (!empty($conditions)) {
            $where = " WHERE ";
            $i = 0;
            foreach ($conditions as $key => $value) {
                $where .= ($i > 0) ? " AND " : "";
                $where .= "$key = :$key";
                $i++;
            }
        }
        $query = "UPDATE $table SET $set $where";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute(array_merge($data, $conditions));
        return $stmt->rowCount();
    }

    // 删除数据

    /**
     * @param $table $数据表
     * @param $where $删除条件
     * @return int      $返回受影响记录数
     */
    public function delete($table, $where): int
    {
        $sql = "DELETE FROM $table WHERE $where";

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // 查询数据

    /**
     * @param $table $数据表
     * @param string $where $查询条件
     * @param array $params $条件集合
     * @param array $fields $显示字段
     * @param string $order $排序
     * @param string $limit $记录数量限制
     * @return bool|array   $返回数据集
     */
    public function select($table, string $where = '', array $params = array(), array $fields = array('*'), string $order = '', string $limit = ''): bool|array
    {
        $sql = "SELECT " . implode(',', $fields) . " FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        if ($order) {
            $sql .= " ORDER BY $order";
        }
        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}