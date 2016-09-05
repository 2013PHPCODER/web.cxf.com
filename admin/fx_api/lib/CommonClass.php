<?php
/*
关键字替换，关键字高亮 
by 林澜叶  linlanye@sina.cn 2016/08/31 16:00

用法：
    $keyword=['关键词1',  '关键词2'..];
    $a=new LinMatch($keyword);
    $a->strictModel();      //严格模式，匹配区分大小写,默认不区分
    $a->strictModel('off');     //关闭严格模式
    高亮
    $before='<font style="color:red">';
    $after='</font>';
    $result=$a->highlight($str, $before, $after);
    替换
    $mask='*';
    $result=$a->mask($str, $mask);
*/
class LinMatch
{
    private  $strict=false;
    private  $keyword=[];


    public function __construct($keyword){
        if (!is_array($keyword) && !empty($keyword)) {
            $this->keyword=[$keyword];
        }else{
            $this->keyword=$keyword;
        }
    }


    public function strictModel($switch='on'){
        if ($switch == 'off') {
             $this->strict=false;
        }else{
            $this->strict=true;
        }
    }

    public function highlight($str, $before='', $after=''){     //对关键字进行高亮
        $len=strlen($str);
        $arr=$this->createSign($str, $len);

        if ($arr === null ) {
            return $str;
        }

        $return_str='';
        for ($i=0; $i < $len; $i++) { 
            if ($arr[$i] > 0) {                     //如果有匹配占位符号,则用关键词加替换符替代
                $current=$arr[$i];                  //当前的匹配记号
                while ( $current==$arr[$i]) {           //跳过当前匹配
                    $i++;
                    if ($i === $len) {              //注意最后一位可能溢出
                        break;
                    }
                }
                $return_str.=$before. $this->keyword[$current-1]. $after;                   //高亮处理
                $i--;                                   //此处必须减1，因为i已经调到下一位了
            }else{
                $return_str.=$str[$i];
            }   
        }       
        reset($this->keyword);              //复原keyword指针
        return $return_str;
    }


    public function mask($str, $mask=''){
        $len=strlen($str);
        $arr=$this->createSign($str, $len);

        if ($arr === null ) {
            return $str;
        }

        $return_str='';
        for ($i=0; $i < $len; $i++) { 
            if ($arr[$i] > 0) {                     //如果有匹配占位符号,则用关键词加替换符替代
                $current=$arr[$i];                  //当前的匹配记号
                while ( $current==$arr[$i]) {           //跳过当前匹配
                    $i++;
                    if ($i === $len) {              //注意最后一位可能溢出
                        break;
                    }               
                }
                $return_str.=$mask;                 //高亮处理
                $i--;                                   //此处必须减1，因为i已经调到下一位了
            }else{
                $return_str.=$str[$i];
            }   

        }           
        reset($this->keyword);              //复原keyword指针
        return $return_str;
    }

    private function createSign(&$str, $len){                //创建标记数组

        if (empty($this->keyword)) {                // 关键字为空直接返回null
            return null;
        }
        //1初始化标记数组
        $len=strlen($str);
        $arr=[];
        for ($i=0; $i < $len; $i++) { 
            $arr[$i]=0;
        }
        //2对关键词进行匹配,生成匹配数组
        $n=count($this->keyword);                           //n为关键字数量

        for ($y=0; $y < $n; $y++) { 
            $key=(string) current($this->keyword);
            next($this->keyword);
            $len_key=strlen($key);                      //当前关键字的长度
            $j=0;                                       //已匹配到的关键字中的位置


            for ($i=0; $i <$len ; $i++) { 

                if ($arr[$i] !== 0) {               //遇上已被标记的位则跳到下一位
                    continue;
                }
                $j=$j >= $len_key? 0: $j;               //如果j大于关键字长度，说明已经匹配完一次，j复原，
                
                // var_dump($key);
                // echo "$str[$i]和$key[$j]";
                // echo '<br>';
                if ($this->compare($str[$i], $key[$j]) ) {              //当前位匹配到,不区分大小写
                    $arr[$i]=$y+1;                              //匹配上的标记,和当前的关键字所在关键字数组的位置有关
                    $j++;

                    continue;
                }else{                  //当前位未匹配                    
                    if ($j < $len_key) {                    //已经匹配到的只是部分，所以清除标记,回滚到0
                        for ($k=$i-$j; $k <$i ; $k++) {     
                            $arr[$k]=0;                 
                        }
                        $j=0;               //j需从0开始
                    }
                }
            }
        }

        return $arr;
    }

    private function compare($str1, $str2){
        if ($this->strict) {            //严格模式
            return $str1 === $str2 ? true: false;
        }else{
            return strcasecmp($str1, $str2) === 0 ? true : false;
        }
    }


}



class Sphinx{
    public $instance=null;
    public $keyword;
    public $sort;
    public $index;
    public $result;
    private $words;     //分词结果

    public function __construct($keyword='', $sort='@id', $page=1){
        $this->init();                                       
        $this->keyword=$keyword;
        $this->sort='@weight DESC ,'.$sort;                      //拼接字符串
        $this->page($page);                         //分页
        $this->sort();

    }
    public function filterCategory($ids=[], $attr='goods_category'){            //商品类目
        !is_array($ids) && $ids=[$ids];
        $this->instance->setFilter($attr, $ids);
    }

    public function filterPrice($min, $max, $attr='price'){              //价格范围
        $this->instance->setFilterFloatRange($attr, $min, $max);
    }
    public function search($index='goods_main, goods_sub'){
        $this->index=$index;
        $this->result=$this->instance->Query($this->keyword, $index);           //查出结果
        $this->words=isset($this->result['words'])? $this->result['words']: '' ;
        if (isset($this->instance->error) && !empty($this->instance->error) or isset($this->instance->_error) && !empty($this->instance->_error) ) {
            myerror(\StatusCode::msgSearchFail, '搜索服务器连接异常');
        }
        $ids='';
        $ids_array=[];
        if (isset($this->result['matches']) && is_array($this->result['matches'])) {
            foreach ($this->result['matches'] as &$v) {
                $ids=$ids. $v['id']. ',';
                $ids_array[]=$v['id'];
            }
            $ids=rtrim($ids, ',');          //去掉最右逗号
        }
        $words=!empty($this->result['words'])? array_keys($this->result['words']): '';

        return ['total'=>$this->result['total'], 'ids'=>$ids, 'words'=>$words];
    }

    private function sort(){
        $this->instance->SetSortMode(SPH_SORT_EXTENDED, $this->sort);         //排序 
    }

    private function page($page){
        $per_page=Config('page_num');                      //设置分页
        $current_item=($page-1)*$per_page;
        $this->instance->SetLimits($current_item, $per_page);

    }

    /*
    高亮显示
    $arr 目标数组，$attr, 高亮的属性值
    */
    public function build($result=[], $attr, $opt=''){
        $opt=[
            "before_match"=>"<font style='font-weight:bold;color:#f00'>",
            "after_match"=>"</font>",
        ];
        
        // if (!empty($result)) {
        //     foreach ($result as $key => $v) {
        //         // dump($v);
        //         $goods_name[]=$v[$attr];

        //     }
        //     dump($goods_name);
        //     $goods_name=$this->instance->buildExcerpts($goods_name, $this->index, $this->keyword, $opt);
        //     foreach ($result as $key => &$v) {
        //         $v[$attr][$key]=$goods_name[$key];
        //     }
        // }
        // dump($result);


        // assert(is_array($arr));
        // assert(is_string($attr));

        // foreach ($arr as &$v) {
        //     foreach ($this->words as $k => $v2) {
        //         $start=stripos($v[$attr], $k);
        //         $old=substr($v[$attr], $start, strlen($k));             //拿到原始字符串，区分大小写的

        //         $new=$opt['before_match']. $old. $opt['after_match'];    
        //         dump($new);
        //         dump($v[$attr]);
        //         dump($k);
        //         $v[$attr]=str_ireplace($k, $new, $v[$attr]);                        //替换原始字符串，
        //         // $v[$attr]=preg_replace($pattern, $new, $v[$attr]);              

        //     }
        // }

    }
    private function init(){
        if ($debug=Config('debug')) {
            $conf=Config::sphinx('debug');
            import('Sphinxapi');                    //非linux环境
        }else{
            $conf=Config::sphinx('produce');
        }
        $this->instance=new SphinxClient(); 
        $this->instance->SetServer($conf['host'], $conf['port']);   
        $this->instance->SetArrayResult(true);       
        $this->instance->SetMatchMode(SPH_MATCH_ANY); 
        if (isset($this->instance->error)) {
            myerror(\StatusCode::msgSearchFail, '搜索服务器异常');
        }
    } 


}

/**
* 
*/
class debug{
    
    private static $timeArr;

    public static function time($flag='begin'){
        
        switch ($flag) {
            case 'end':
                $time=explode(' ', microtime());

                $m=round(($time[0]-self::$timeArr['time'][0]),6);
                $s=$time[1]-self::$timeArr['time'][1];
                self::$timeArr['time']=round(($s+$m), 6).'s';

                self::$timeArr['memory']=round( (memory_get_usage()-self::$timeArr['memory'])/1024/1024, 2).'Mb';
                // self::$timeArr['peak']=round( (memory_get_usage()-self::$timeArr['peak'])/1024/1024, 2).'Mb';
                dump(self::$timeArr);
                return self::$timeArr;    
                break;
            
            default:
                self::$timeArr['time']=explode(' ', microtime());
                self::$timeArr['memory']=memory_get_usage();
                break;
        }

    }

}


/* * 要检查的输入参数* */

class InputCheckName {
    const UserName = '用户名';
    const PassWord = '用户密码';
    const CurrentPage = '当前页码';
    const GoodsId = '商品ID';
    const UserId = '用户ID';
    const SuplierId = '供货商ID';
    const ClassId = '商品小类';
    const ItemId = '商品ID';
    const OldPassWord = '旧密码';
    const NewPassWord = '新密码';
    const UserNick = '用户昵称';
    const Mobile = '电话号码';
    const Email = '电子邮箱';
    const Address = '用户地址';
    const QQ = 'QQ号码';
    const CategoryId = '类目ID';
    const SortType = '排序类型';
    const Humen = '人气';
    const Sales = '销量';
    const IsNew = '新款';
    const Price = '价格';
    const Search = '搜索内容';
    const NoticeId = '公告ID';

}

/**
 * 检查类型
 * * */
class CheckType {

    const Email = 'Email';
    const Idcard = 'IdCard';
    const Int = 'Int';
    const Float = 'Float';

}

/*
 * 查询类型
 *  */

class QueryType {

    const In = 'In';
    const NotIn = 'NotIn';
    const Eq = 'Eq';
    const Range = 'Range';
    const Maybe = 'Maybe'; //等于Or
    const Like = 'Like';
    const Is = 'Is';
    const PlusThan = 'PlusThan'; //大于
    const LessThan = 'LessThan'; //小于

}

/*
 * 广告商品
 */

class AdverGoods {

    const NewGoods = 1;  //新款
    const VisitGoods = 2; //爆款
    const SpecialMoney = 3; // 特价商品
    const ClearGoods = 4;  //清仓商品
    const RecommandGoods = 5; //特推商品

}

class SearchTitle {

    const HumenHigh = 1;
    const HumenLow = 2;

}

// /* 事物处理 */

// class TranType {
//     const delete = 1;
//     const update = 2;
//     const create = 3;
// }
// /*流量卡类型
//  */
// class CardType{
//     const jichu=1;
//     const biaozhun=2;
//     const zhuanye=3;
//     const haohua=4;
//     const zungui=5;
//     const zhizun=6;
// }
// /*充值资金类型*/
// class PayMoneyType{
//     const BuyCard=1; //购买流量卡
//     const Alipay=2;  //支付宝充值
//     const CaifuTong=3;  //财付通充值
//     const Kami=4;  //卡密充值
// }



// class Common {
//     /* 获取购买流量卡，明细 */

//     static function GetByCardRemark($type) {
//         $remark = "";
//         switch ($type) {
//             CASE CardType::jichu:
//                 $remark = format("购买基础版流量卡，获得{0}个流量点.", JICHU_POINT);
//                 break;
//             CASE CardType::biaozhun:
//                 $remark = format("购买标准流量卡，获得{0}个流量点.", BIAOZHUN_POINT);
//                 break;
//             CASE CardType::zhuanye:
//                 $remark = format("购买专业版流量卡，获得{0}个流量点.", ZHUANYE_POINT);
//                 break;
//             CASE CardType::haohua:
//                 $remark = format("购买豪华版流量卡，获得{0}个流量点.", HAOHUA_POINT);
//                 break;
//             CASE CardType::zungui:
//                 $remark = format("购买尊贵版流量卡，获得{0}个流量点.", ZUNGUI_POINT);
//                 break;
//             CASE CardType::zhizun:
//                 $remark = format("购买至尊版流量卡，获得{0}个流量点.", ZHIZUN_POINT);
//                 break;
//         }
//         return $remark;
//     }

//     static function GetPointByCardType($type) {
        
//     }

//     /*** 获取当前时间,精确到毫秒级* */

//     static function getCurrentDate() {
//         $t = microtime(true);
//         $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
//         return date('Y-m-d H:i:s:' . $micro, $t);
//     }

//     static function getUserId() {
//         $userID = _get("userId");
//         if (empty($userID)) {
//             return "请重新登录后操作.";
//         } else {
//             $userDalDal = new UserDal();
//             $whereDal = array(QueryType::Eq => array("UserID" => $userID));
//             $userDalList = $userDalDal->QueryByWhere($whereDal, NULL, NULL, array("UserID", "UserName", "PassWord", "Email", "RealName", "CONVERT(varchar(50), Birthday, 23) as Birthday", "IDCard", "Mobile", "QQ", "CONVERT(varchar(100), RegDate, 20) as RegDate", "CONVERT(varchar(100), LastLoginTime, 20) as LastLoginTime", "LastLoginIP", "Convert(decimal(18,2),Money) as Money", "Convert(decimal(18,2),Point) as Point", "shopName", "TotalVisitNum", "TotalClickNum"));
//             if (!empty($userDalList) && is_array($userDalList)) {
//                 return $userDalList;
//             } else {
//                 return "请重新登录后操作.";
//             }
//         }
//     }

//     /* 记录日志 */

//     static function WriteLog($value) {
//         $path = BASE_PATH . "log/" . date('ymd', time()) . ".txt";
//         $dirname = dirname($path);
//         if (!is_dir($dirname)) {
//             mkdir($dirname, 0755, true);
//         }
//         $myfile = fopen($path, "a") or die("Unable to open file!");
//         fwrite($myfile, date('y-m-d h:i:s', time()) . ":" . $value . "\r\n");
//         fclose($myfile);
//     }

//     /* 获取请求参数 */

//     static function Request() {
//         $arr = array();
//         $method = $_SERVER['REQUEST_METHOD'];
//         switch ($method) {
//             case 'PUT':
//                 do_something_with_put($request);
//                 break;
//             case 'POST':
//                 $data = file_get_contents('php://input', 'r');
//                 $arr = json_decode($data, TRUE);
//                 break;
//             case 'GET':
//                 parse_str($_SERVER["QUERY_STRING"], $arr);
//                 break;
//             case 'HEAD':
//                 do_something_with_head($request);
//                 break;
//             case 'DELETE':
//                 do_something_with_delete($request);
//                 break;
//             case 'OPTIONS':
//                 do_something_with_options($request);
//                 break;
//             default:
//                 handle_error($request);
//                 break;
//         }
//         return $arr;
//     }

// }
// class Cookie {
//    /**
//      * 解密已经加密了的cookie
//      * 
//      * @param string $encryptedText
//      * @return string
//      */
//     private static function _decrypt($encryptedText)
//     {
//         //$key = Config::get('secret_key');
//         $key= SECRET_KEY;
//         $cryptText = base64_decode($encryptedText);
//         $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
//         $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
//         $decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cryptText, MCRYPT_MODE_ECB, $iv);
//         return trim($decryptText);
//     }
 
//     /**
//      * 加密cookie
//      *
//      * @param string $plainText
//      * @return string
//      */
//     private static function _encrypt($plainText)
//     {
//         //$key = Config::get('secret_key');
//         $key=$key= SECRET_KEY;
//         $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
//         $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
//         $encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plainText, MCRYPT_MODE_ECB, $iv);
//         return trim(base64_encode($encryptText));
//     }
     
//     *
//      * 删除cookie
//      * 
//      * @param array $args
//      * @return boolean
     
//     public static function del($args)
//     {
//         $name = $args['name'];
//         $domain = isset($args['domain']) ? $args['domain'] : null;
//         return isset($_COOKIE[$name]) ? setcookie($name, '', time() - 86400, '/', $domain) : true;
//     }
     
//     /**
//      * 得到指定cookie的值
//      * 
//      * @param string $name
//      */
//     public static function get($name)
//     {
//         return isset($_COOKIE[$name]) ? self::_decrypt($_COOKIE[$name]) : null;
//     }
     
//     /**
//      * 设置cookie
//      *
//      * @param array $args
//      * @return boolean
//      */
//     public static function set($args,$isEncrypt=FALSE)
//     {
//         $name = $args['name'];
//         $value= $isEncrypt ? self::_encrypt($args['value']):$args['value'];
//         $expire = isset($args['expire']) ? $args['expire'] : null;
//         $path = isset($args['path']) ? $args['path'] : '/';
//         $domain = isset($args['domain']) ? $args['domain'] : null;
//         $secure = isset($args['secure']) ? $args['secure'] : 0;
//         return setcookie($name, $value, $expire, $path, $domain, $secure);
//     }
// }



