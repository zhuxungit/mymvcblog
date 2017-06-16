<?php
namespace Model;

/**
 * 用户模型
 * @package Model
 */
class UserModel extends \Core\Model
{

    public function getRow($id)
    {
        $sql = "select * from user where id=$id";

        return $this->mypdo->fetchRow($sql);
    }
    /**
     * 查询数据库
     * @param $username 用户名
     * @param $password 密码
     * @return mixed
     */
    public function getUserinfo($username,$password){
        //防止SQL注入方法一
        // $username=addslashes($username);
        //通过PDO::quote的防止SQL注入
         $username = $this->mypdo->addQuote($username);
       return $this->mypdo->fetchRow("select * from user where username = $username and password= '".md5($password)."'");
    }


    /**
     * 查询数据库除了密码信息
     * @param $username 用户
     * @return mixed
     */
    public function getexceptpwd($id,$username){
        //防止SQL注入方法一
        // $username=addslashes($username);
        //通过PDO::quote的防止SQL注入
        $username = $this->mypdo->addQuote($username);
        return $this->mypdo->fetchRow("select * from user where username = $username and id= $id");
    }



    //判断用户是否存在
    public function isExistsByName($username)
    {
        $username = $this->mypdo->addQuote($username);
        return $this->mypdo->fetchColumn("select count(*) from user where username=$username");
    }

    //注册信息插入数据库
    public function insert($data)
    {

        $name=$data['name'];
        $pwd=$data['pwd'];
        $avatar=$data['avatar'];

       return $this->mypdo->exec("insert into user values (null,'$name','$pwd','$avatar','123','123','123')");
    }


    /**
     * 更新登录信息
     * @param $logincount
     * @param $lastlogintime
     * @param $lastloginip
     * @param $username
     * @return mixed
     */
    public function update($logincount,$lastlogintime,$lastloginip,$username)
    {

        $lastloginip = ip2long($lastloginip);
        $this->mypdo->exec("update user set login_count='$logincount', last_login_time='$lastlogintime' , last_login_ip='$lastloginip' where username='$username'");

        return $this->mypdo->fetchRow("select * from user where username = '$username' ");
    }

    /**
     * 获得所有文章数据
     * @return mixed
     */
    public function getAll($startpno,$pagesize)
    {
        $sql="select * from user limit $startpno,$pagesize";
        return $this->mypdo->fetchAll($sql);
    }

    /**
     * 获得所有文章数据个数
     * @return mixed
     */
    public function getCountAll()
    {
        $sql="select count(*) as num from user";
        return $this->mypdo->fetchAll($sql);
    }
//    /**
//     * 查询显示用户列表
//     */
//    public function userlist()
//    {
//
//        return $this->mypdo->fetchAll("select * from user");
//    }

    /**
     * 通过COOKIE获取用户信息
     */
    public function getUserByCookie()
    {
        if (isset($_COOKIE['id'])&&isset($_COOKIE['key'])) {
            $id  = $_COOKIE['id'];
            $key = $_COOKIE['key'];
            //通过id获取用户信息
            $info=$this->mypdo->fetchRow("select id,username from user where id=$id");

            if(md5(md5($info['id'].$info['username'].$GLOBALS['configs']['app']['key']))==$key){
                return $info;
            }
        }

        return null;
    }
    /**
     * 管理员添加用户
     */
    public function add_user($username,$password,$is_admin)
    {
//        echo "insert into user value(null,'$username','".md5($password)."')";
//        die();
        return $this->mypdo->exec("insert into user(username,password,is_admin) value('$username','".md5($password)."',$is_admin)");
    }

    /**
     *管理员更新用户信息（密码变更）
     */
    public function update_user($id,$username,$password,$is_admin)
    {
        $sql = "update user set username='$username',password='".md5($password)."',is_admin=$is_admin where id =$id";
        return $this->mypdo->exec("$sql");
    }
    /**
     *管理员更新用户信息（密码不变更）
     */
    public function update_user_no_psw($id,$username,$is_admin)
    {
        $sql = "update user set username='$username',is_admin=$is_admin where id =$id";
        return $this->mypdo->exec("$sql");
    }

    /**
     * 管理员删除用户
     */
    public function delete_user($id)
    {
        return $this->mypdo->exec("delete from user where id=$id");
    }

}