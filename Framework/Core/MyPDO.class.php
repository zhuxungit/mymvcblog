<?php
namespace Core;

use PDO;
/*
 *  数据库操作类，单例模式
 */
class MyPDO
{
    private $type;              //数据库类型
    private $host;              //主机地址
    private $port;              //端口号
    private $dbname;            //数据库名称
    private $charset;           //字符编码
    private $user;              //数据库用户名
    private $pwd;               //数据库密码
    private $pdo;               //PDO对象
    private static $instance;   //私有的静态属性用来保存MyPDO单例

    /*
     * 私有的构造函数用来阻止在类的外部实例化，并且初始化成员变量
     */
    private function __construct($param)
    {
        $this->initParam($param);
        $this->initPDO();
        $this->initException();
    }

    /*
     * 私有的__clone()用来阻止在类的外部clone对象
     */
    private function __clone()
    {
    }

    /*
     * 初始化成员变量
     */
    private function initParam($param)
    {
        $this->type = isset($param['type']) ? $param['type'] : $GLOBALS['configs']['database']['type'];
        $this->host=isset($param['host']) ? $param['host'] : $GLOBALS['configs']['database']['host'];
        $this->port=isset($param['port']) ? $param['port'] : $GLOBALS['configs']['database']['port'];
        $this->dbname=isset($param['dbname']) ? $param['dbname'] : $GLOBALS['configs']['database']['dbname'];
        $this->charset=isset($param['charset']) ? $param['charset'] : $GLOBALS['configs']['database']['charset'];
        $this->user=isset($param['user']) ? $param['user'] : $GLOBALS['configs']['database']['user'];
        $this->pwd=isset($param['pwd']) ? $param['pwd'] : $GLOBALS['configs']['database']['pwd'];
    }

    /*
     * 初始化PDO
     */
    private function initPDO()
    {
        try{
            $dsn="{$this->type}:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";
            $this->pdo=new PDO($dsn,  $this->user,  $this->pwd);
        } catch (PDOException $ex) {
            $this->showException($ex);
        }
    }

    /*
     * 设置PDO属性，实现自动抛出异常
     */
    private function initException()
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
    }

    /*
     * 显示异常信息
     */
    private function showException($ex,$sql='')
    {
        if($sql!='')
            echo 'SQL语句执行失败<br>错误的SQL语句是：'.$sql,'<br>';
        echo '错误编号：'.$ex->getCode(),'<br>';
        echo '错误行号：'.$ex->getLine(),'<br>';
        echo '错误文件：'.$ex->getFile(),'<br>';
        echo '错误信息：'.$ex->getMessage(),'<br>';
        exit;
    }

    /*
     * 获取PDOStatement对象
     */
    private function getPDOStatement($sql)
    {
        try{
            return $this->pdo->query($sql);
        } catch (Exception $ex) {
            $this->showException($ex, $sql);
        }
    }

    /*
     * 获取匹配常量,
     */
    private function getFetchType($type)
    {
        switch($type){
            case 'assoc':
                return PDO::FETCH_ASSOC;
            case 'num':
                return PDO::FETCH_NUM;
            case 'both':
                return PDO::FETCH_BOTH;
            default :
                return PDO::FETCH_ASSOC;
        }
    }

    /*
     * 获取所有记录,返回二维数组
     * @param $sql string 执行查询的SQL语句
     * @param $type string 匹配的类型  assoc,num,both
     */
    public function fetchAll($sql, $type='assoc')
    {
        $stmt=  $this->getPDOStatement($sql);
        $type=  $this->getFetchType($type);
        return $stmt->fetchAll($type);
    }

    /*
     * 获取一条记录
     */
    public function fetchRow($sql,$type='assoc')
    {
        $stmt=  $this->getPDOStatement($sql);
        $type=  $this->getFetchType($type);
        return $stmt->fetch($type);
    }

    /**
     * 获取第一行第一列的数据
     */
    public function fetchColumn($sql)
    {
        $stmt=  $this->getPDOStatement($sql);
        return $stmt->fetchColumn();
    }

    /*
     * 执行数据操作语句
     */
    public function exec($sql)
    {
        try{
            return $this->pdo->exec($sql);
        } catch (PDOException $ex) {
            $this->showException($ex);
        }
    }

    /*
     * 获取自动增长的编号
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /*
     * 共有的静态方法用来获取MyPDO的单例
     * @param array 链接数据库需要用到的参数
     */
    public static function getInstance($param=array())
    {
        if(!self::$instance instanceof self)
            self::$instance=new self($param);
        return self::$instance;
    }

    /**
     * 通过PDO防止SQL注入
     * @param $data
     * @return mixed
     */
    public function addQuote($data)
    {
        return $this->pdo->quote($data);
    }
}