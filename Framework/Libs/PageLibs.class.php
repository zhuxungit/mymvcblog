<?php
namespace Libs;

class PageLibs
{
    //总记录数
    private $recordcount;
    //总页数
    private $pagecount;
    //当前页码
    private $pageno;
    //页码大小
    private $pagesize;
    //起始位置
    private $startno;

    public function __get($key)
    {
        return $this->$key;
    }

    public function __construct($recordcount,$pagesize)
    {
        $this->initParam($recordcount,$pagesize);
    }

    /**
     * //分页参数初始化
     * @param $recordcount
     * @param $pagesize
     */
    private function initParam($recordcount,$pagesize)
    {
        $this->recordcount=$recordcount;
        $this->pagesize  = $pagesize;
        $this->pagecount = ceil($this->recordcount/$this->pagesize);
        $this->pageno = isset($_GET['pageno'])?$_GET['pageno']:1;
        $this->pageno = min(max($this->pageno,1),$this->pagecount);
        $this->startno = ($this->pageno-1)*$this->pagesize;
    }

    /**
     * 拼接条件字符串
     * @param $condition
     * @return string
     */
    private function createURL($condition)
    {
        $url = 'index.php?p='.PLATFORM_NAME.'&c='.CONTROLLER_NAME.'&a='.ACTION_NAME;
        foreach ($condition as $k=>$v) {
            if(trim($v)==''){
                continue;
            }
            $url.="&$k=$v";
        }
        $url.="&pageno=";
        return $url;
    }

    public function show($condition=array())
    {
        $url = $this->createURL($condition);
        $str = '<span>共有'.$this->recordcount.'条记录，每页显示'.$this->pagesize.'条记录，当前是第'.$this->pageno.'页！</span>';
        $str.= '<a href="'.$url.'1'.'">首页</a>';
        $str.= '&nbsp;&nbsp;<a href="'.$url.($this->pageno-1).'">上一页</a>';
        for ($i=1;$i<=$this->pagecount;$i++) {
                $str.='&nbsp;&nbsp;<a href="'.$url.$i.'">'.$i;
        }
        $str.='&nbsp;&nbsp;<a href="'.$url.($this->pageno+1).'">下一页</a>';
        $str.='&nbsp;&nbsp;<a href="'.$url.($this->pagecount).'">尾页</a>';
        $str.='&nbsp;&nbsp;<select onchange="window.location.href=this.value">';
        for ($i=1;$i<=$this->pagecount;$i++) {
            if ($this->pageno==$i){
                $str.='<option value="'.$url.$i.'" selected>'.$i.'</option>';
            }else{
                $str.='<option value="'.$url.$i.'">'.$i.'</option>';
            }
        }
        $str.='</select>';
        $str.='&nbsp;&nbsp;<input type="text.xml" value='.$this->pageno.' id="go" style="width:48px">';
        $str.='&nbsp;&nbsp;<input type="button" value="跳转" onclick="';
        $str.='window.location.href=\''.$url.'\'+document.getElementById(\'go\').value">';
        return $str;
    }






}