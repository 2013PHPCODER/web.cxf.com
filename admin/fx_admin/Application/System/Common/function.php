<?php
/*
**读取扩展配置 
* by 林澜叶
*/
class Config {

    /**
     * @param array $config     存储配置文件的数组
     * @param string $file    配置文件名
     */
    private static $config = [];
    private static $file;

    /**
     * 获取或设置配置文件，获取型如：config::file('key')； 设置类型如config::file(['key'=>'value'])
     */
    public static function __callStatic($file, $arg) {
        $arg = $arg[0];                   //只接受单参数;
        $file = strtolower($file);

        if (!isset(self::$config[$file])) {         //判断是否载人配置
            self::$config[$file] = include('/../Conf/' . $file . '.config.php');
        }


        if (is_array($arg)) {         //设置配置,支持批量设置
            foreach ($arg as $key => $value) {
                self::set($key, $value, $file);
            }
        } else {                      //获取配置
            return self::get($arg, $file);
        }
    }

    public static function getDefault($name){       //获取默认配置
        $file='default';
        if (!isset(self::$config[$file])) {         //判断是否载人配置
            self::$config[$file] = include('/../Conf/config.php');
        } 
        if (is_array($name)) {         //设置配置,支持批量设置
            foreach ($name as $key => $value) {
                self::set($key, $value, $file);
            }
        } else {                      //获取配置
            return self::get($name, $file);
        }           
    }

    /**
     * 返回已加载的全部配置
     */
    public static function getAll() {
        return self::$config;
    }

    /**
     * 设置配置，可链式设置
     */
    private static function set($key, $value, $file) {
        $nodes = explode('.', $key);

        self::recursiveSet(self::$config[$file], $nodes, $value);
    }

    /**
     * 设置链式调用的配置量
     * @param array $conf   某个配置文件的内容
     * @param array $nodes    链式调用配置的节点
     */
    private static function recursiveSet(&$conf, &$nodes, &$value) {
        $k = current($nodes);
        if (next($nodes)) {   //递归进入最底层节点
            $conf[$k] = self::recursiveSet($conf[$k], $nodes, $value);
        } else {
            $conf[$k] = $value;  //进入最底层节点后，赋值
        }
        return $conf;
    }

    /**
     * 设置配置，可链式设置，支持批量设置
     */
    private static function get($key, $file) {
        if (is_null($key)) {           //没有设置key时候返回全部
            return self::$config[$file];
        }
        $nodes = explode('.', $key);
        return self::recursiveGet(self::$config[$file], $nodes);
    }

    /**
     * 获取链式调用的配置量
     * @param array $conf   某个配置文件的内容
     * @param array $nodes    链式调用配置的数组
     * @return mixed
     */
    private static function recursiveGet(&$conf, &$nodes) {
        $k = current($nodes);
        if (isset($conf[$k])) {     //节点有配置  
            if (next($nodes)) {    //如果还需调用子节点，否则返回当前节点配置
                return self::recursiveGet($conf[$k], $nodes);
            }
            return $conf[$k];
        } else {                           //节点没有配置信息
            return null;
        }
    }
}
// 获取默认配置
function Config($key=null){   
    return Config::getDefault($key);   
}


function PWD($pwd){		//加密密码
		return md5(C('SALT_PWD').$pwd);
}

function showAdminSelfAuth($ownAuth){               //显示管理员自己的权限
    $auth=C('AUTH_SETTING');
    foreach ($auth as $k => $v) {
        $module=explode('|', $k);
        $ownModule=isset($ownAuth[$module[0]]);
        if ($ownModule) {                                               //具有权限才写入
            $r[$module[0]]=['name'=>$module[1], 'list'=>[] ];               
        }

        foreach ($v as $k2 => $v2) {
            $control=explode('|', $k2);
            $ownControl=isset($ownAuth[$module[0]][$control[0]]);
            if ($ownControl) {
                $r[$module[0]]['list'][$control[0]]=['name'=>$control[1], 'list'=>[] ];
            }
            
            
            foreach ($v2 as $k3 => $v3) {
                $action=explode('|', $v3);
                $ownAction=isset($ownAuth[$module[0]][$control[0]][$action[0]]) || $ownAuth[$module[0]][$control[0]] ==='*';        //拥有控制器的所有权限;
                // dump($ownAuth[$module[0]]);
                $ownAction=($ownModule && $ownControl && $ownAction) ? true: null;                     //生成是否具有权限的显示
                if ($ownAction) {
                    $r[$module[0]]['list'][$control[0]]['list'][$action[0]]=['name'=>$action[1]  ];
                }
                
            }
        }
    }
    return $r;
}


function showAuth($ownAuth){            //显示员工权限列表
    $auth=C('AUTH_SETTING');
    foreach ($auth as $k => $v) {
        $module=explode('|', $k);
        $r[$module[0]]=['name'=>$module[1], 'list'=>[] ];               //处理数据
        $ownModule=isset($ownAuth[$module[0]]);

        foreach ($v as $k2 => $v2) {
            $control=explode('|', $k2);
            $r[$module[0]]['list'][$control[0]]=['name'=>$control[1], 'list'=>[] ];
            $ownControl=isset($ownAuth[$module[0]][$control[0]]);


            foreach ($v2 as $k3 => $v3) {
                $action=explode('|', $v3);
                $ownAction=isset($ownAuth[$module[0]][$control[0]][$action[0]]) || $ownAuth[$module[0]][$control[0]] ==='*';        //拥有控制器的所有权限        
                $checked=($ownModule && $ownControl && $ownAction) ? 'checked=""': null;                     //生成是否具有权限的选中状态
                $r[$module[0]]['list'][$control[0]]['list'][$action[0]]=['name'=>$action[1], 'value'=>$action[0], 'checked'=>$checked ];
            }
        }
    }
    return $r;
}