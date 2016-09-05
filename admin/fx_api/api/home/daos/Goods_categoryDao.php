<?php

namespace api\home;

class Goods_categoryDao extends Dao {
    /*     * 执行自定义增删改语句 */

    public function all_status_1_menu() {
        $_sql = 'SELECT `title`,`big_ico`,`category_id`,`name`,cid,parent_id,level,`order`,`ico` FROM '
                . 'goods_category WHERE `status` =:status AND `level` <:level ORDER BY `order`';
        $_where = array('status' => \CategoryBig::up_status,
            'level' => \CategoryBig::offline_level);
        return $this->query($_sql, $_where);
    }

    public function getGoodsCategory($category_id, $level) {    //根据类目和等级获得商品cid， 
        switch ($level) {
            case '2':
                $sql = '(select cid, level from goods_category where cid=:id and level=2) union ';
                $sql.='(select cid, level from goods_category where parent_cid=:id and level=3 ) union ';
                $sql.='(select c.cid, c.level from goods_category as a inner join goods_category as b on a.cid=b.parent_cid inner join goods_category as c on b.cid=c.parent_cid where a.cid=:id)';

                $param=['id'=>$category_id];
                break;
            case '3':
                $sql = "select cid from goods_category where parent_cid=:pid or (level=3 and cid=:cid)";
                $param=['pid'=>$category_id, 'cid'=>$category_id];
                break;
            case '4':
                return [$category_id];                          
        }
        $cids=$this->query($sql, $param);
        if (!empty($cids)) {
            foreach ($cids as $key => $value) {
                $cids[$key]=$value['cid'];
            }
        }
        return $cids;
    }

    public function get_index_category1($model) {    //根据类目获得商品cid
        die();
        $sql = "select name,cid,level,category_id,parent_id from goods_category where status =:status";
        $_where = array('status' => 1);
        $arr = $this->query($sql, $_where); // $this->getList($model, array("name","category_id","cid","level"));
        $result = array();
        if (!empty($arr) && count($arr) > 0) {
            if (!empty($arr) && count($arr) > 0) {
                foreach ($arr as $key => $value) {
                    $item = array();
                    switch ($value["name"]) {
                        case "女装":
                            // array_push($item, array("name" => "女装", "child" => get_child_by_parentid($arr, $value["category_id"])));
                            $result["时尚服饰"]["女装"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "男装":
                            $result["时尚服饰"]["男装"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "童装":
                            $result["时尚服饰"]["童装"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "男鞋":
                            $result["经典鞋靴"]["男鞋"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "女鞋":
                            $result["经典鞋靴"]["女鞋"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "童鞋":
                            $result["经典鞋靴"]["童鞋"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "服饰配件":
                            $result["服饰箱包"]["服饰配件"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                        case "箱包":
                            $result["服饰箱包"]["箱包"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "彩妆/香水/美妆工具":
                            $result["美妆日化"]["彩妆/香水/美妆工具"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "户外/登山/野营/旅行用品":
                            $result["运动户外"]["户外/登山/野营/旅行用品"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "运动/瑜伽/健身/球迷用品":
                            $result["运动户外"]["运动/瑜伽/健身/球迷用品"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "体育/健身/运动装":
                            $result["运动户外"]["体育/健身/运动装"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "家居饰品":

                            $result["家居家电"]["家居饰品"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "居家日用":
                            $result["家居家电"]["居家日用"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "生活电器":
                            $result["家居家电"]["生活电器"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "3C数码配件":
                            $result["数码3C/其他"]["3C数码配件"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                        case "软件":
                            $result["数码3C/其他"]["软件"][] = $this->get_child_by_parentid($arr, $value["category_id"]);
                            break;
                    }
                }
            }
        }

        return array($result);
    }

    function get_index_category_test() {
        $sql = "select name,cid,level,category_id,parent_id,ico,big_ico from goods_category where status =:status";
        $_where = array('status' => 1);
        $arr = $this->query($sql, $_where); // $this->getList($model, array("name","category_id","cid","level"));
        //$result = array("时尚服饰" => array(), "经典靴鞋" => array(), "服饰箱包" => array(), "美妆日化" => array(), "运动户外" => array(), "家居家电" => array(), "数码3C/其他" => array());

        $result = array(array("name" => "时尚服饰", "small_ico" => "", "child" => array("女装", "男装", "童装")), array("name" => "经典鞋靴", "child" => array("男鞋", "女鞋", "童鞋")),
            array("name" => "服饰箱包", "small_ico" => "", "child" => array("服饰配件", "箱包")), array("name" => "美妆日化", "child" => array("彩妆/香水/美妆工具")),
            array("name" => "运动户外", "small_ico" => "", "child" => array("户外/登山/野营/旅行用品", "运动/瑜伽/健身/球迷用品", "体育/健身/运动装")),
            array("name" => "家居家电", "small_ico" => "", "child" => array("家居饰品", "居家日用", "生活电器")),
            array("name" => "数码3C/其他", "small_ico" => "", "child" => array("3C数码配件", "软件"))
        );

        $fushi = array();
        $xiezi = array();
        $bag = array();
        $meizhuang = array();
        $active = array();
        $jiadian = array();
        $shuma = array();


        if (!empty($arr) && count($arr) > 0) {
            if (!empty($arr) && count($arr) > 0) {
                $end = array();
                foreach ($arr as $key => $value) {
                    $n_arr = $this->check_category($value["name"], $result);
                    if (!empty($n_arr) && count($n_arr) > 0) {
                        $f_name = $n_arr[0];
                        $s_name = $n_arr[1];

                        $item = array("title" => $s_name, "cid" => $value["cid"], "small_pic" => $value["ico"], "big_pic" => $value["big_ico"], "category_id" => $value["category_id"], "child" => $this->get_child_by_parentid($arr, $value["category_id"]));
                        switch ($value["name"]) {
                            case "男装":
                            case "女装":
                            case "童装":
                                array_push($fushi, $item);
                                break;
                            case "男鞋":
                            case "女鞋":
                            case "童鞋":
                                array_push($xiezi, $item);
                                break;
                            case "服饰配件":
                            case "箱包":
                                array_push($bag, $item);
                                break;
                            case "彩妆/香水/美妆工具":
                                array_push($meizhuang, $item);
                                break;
                            case "户外/登山/野营/旅行用品":
                            case "运动/瑜伽/健身/球迷用品":
                            case "体育/健身/运动装":
                                array_push($active, $item);
                                break;
                            case "家居饰品":
                            case "居家日用":
                            case "生活电器":
                                array_push($jiadian, $item);
                                break;
                            case "3C数码配件":
                            case "软件":
                                array_push($shuma, $item);
                                break;
                        }
                    }
                }

                $end_rr = array(array("name" => "时尚服饰", "small_ico" => "http://maihoho.b0.upaiyun.com//top/4767611874612256003.png", "child" => $fushi), array("name" => "经典鞋靴", "small_ico" => "http://maihoho.b0.upaiyun.com//top/5563290782232140502.png", "child" => $xiezi),
                    array("name" => "服饰箱包", "small_ico" => "http://maihoho.b0.upaiyun.com//top/5254653058894076997.png", "child" => $bag), array("name" => "美妆日化", "small_ico" => "http://maihoho.b0.upaiyun.com//top/5354140102692184636.png", "child" => $meizhuang),
                    array("name" => "运动户外", "small_ico" => "http://maihoho.b0.upaiyun.com//top/5686280459101638662.png", "child" => $active),
                    array("name" => "家居家电", "small_ico" => "http://maihoho.b0.upaiyun.com//top/4793348533829127281.png", "child" => $jiadian),
                    array("name" => "数码3C/其他", "small_ico" => "http://maihoho.b0.upaiyun.com//top/4656431305505557949.png", "child" => $shuma)
                );

                die(json_encode($end_rr));
            }
        }
    }

    function get_search_category() {
        $sql = "select name,cid,level,category_id,parent_id,parent_cid,ico,big_ico from goods_category where has_goods=:has_goods and status <> :sta";
        $where_arr = array("has_goods" => \category_has_goods::yes, "sta" => \category_status::is_not);
        $arr = $this->query($sql, $where_arr); // $this->getList($model, array("name","category_id","cid","level"));
        $parent_arr = array();
        $middle_arr = array();

        if (is_array($arr) && count($arr) > 0) {
            foreach ($arr as $key => $value) {
                if ($value["level"] == 1) {
                    $parent_arr[] = $value;
                } else {
                    $middle_arr[] = $value;
                }
            }
        }
        static $result_arr = array();
        foreach ($parent_arr as $key => $value) {
            $child = array();
            $result_arr = $this->deep_check_category($middle_arr, $value["cid"]);
            if (count($result_arr) > 0 && count($result_arr[0]) > 0) {
                foreach ($result_arr as $c_v) {
                    array_push($child, $c_v);
                }
            }
            if (count($result_arr) > 0) {
                while (count($result_arr) > 0) {
                    $pid = $result_arr[0]["cid"];
                    $result_arr = $this->deep_check_category($middle_arr, $pid);

                    if (count($result_arr) > 0 && count($result_arr[0]) > 0) {
                        foreach ($result_arr as $c_v) {
                            array_push($child, $c_v);
                        }
                    }
                }
            }

            $value["child"] = $child;
            $value["name_en"] = "sufficient stock";
            $parent_arr[$key] = $value;
        }

        die(json_encode($parent_arr));
    }

    function deep_check_category($middle_arr, $id) {
        $cc = array();
        if (count($middle_arr) > 0) {
            foreach ($middle_arr as $key => $value) {
                if ($value["parent_cid"] == $id) {
                    array_push($cc, $value);
                }
            }
        }
        return $cc;
    }

    function get_category_by($arr, $child) {
        foreach ($arr as $key => $value) {
            if (isset($value) && array_key_exists("child", $value)) {
                
            }
        }
    }

    function check_category($name) {
        //  $arr = array("时尚服饰" => array("女鞋", "男鞋", "童装"), "经典鞋靴" => array("男鞋", "女鞋", "童鞋"), "服饰箱包" => array("服饰配件", "箱包"), "美妆日化" => array("彩妆/香水/美妆工具"), "运动户外" => array("户外/登山/野营/旅行用品", "运动/瑜伽/健身/球迷用品", "体育/健身/运
//动装"), "家居家电" => array("家居饰品", "居家日用", "生活电器"), "数码3C/其他" => array("3C数码配件", "软件"));

        $arr = array(array(array("name" => "时尚服饰", "child" => array("女装", "男装", "童装"))), array(array("name" => "经典鞋靴", "child" => array("男鞋", "女鞋", "童鞋"))),
            array(array("name" => "服饰箱包", "child" => array("服饰配件", "箱包"))), array(array("name" => "美妆日化", "child" => array("彩妆/香水/美妆工具"))),
            array(array("name" => "运动户外", "child" => array("户外/登山/野营/旅行用品", "运动/瑜伽/健身/球迷用品", "体育/健身/运动装"))),
            array(array("name" => "家居家电", "child" => array("家居饰品", "居家日用", "生活电器"))),
            array(array("name" => "数码3C/其他", "child" => array("3C数码配件", "软件")))
        );

        foreach ($arr as $key => $value) {
            if (in_array($name, $value[0]["child"])) {
                return array($value[0]["name"], $name);
            }
        }
        return "";
    }

    function get_child_by_parentid($arr, $parentid) {
        $result = array();
        foreach ($arr as $key => $va) {
            if ($va["parent_id"] == $parentid) {
                $result[] = $va;
            }
        }

        return $result;
    }

    function check_category_test($name, $arr) {
        //  $arr = array("时尚服饰" => array("女鞋", "男鞋", "童装"), "经典鞋靴" => array("男鞋", "女鞋", "童鞋"), "服饰箱包" => array("服饰配件", "箱包"), "美妆日化" => array("彩妆/香水/美妆工具"), "运动户外" => array("户外/登山/野营/旅行用品", "运动/瑜伽/健身/球迷用品", "体育/健身/运
//动装"), "家居家电" => array("家居饰品", "居家日用", "生活电器"), "数码3C/其他" => array("3C数码配件", "软件"));


        foreach ($arr as $key => $value) {
            if (isset($value) && array_key_exists("child", $value)) {
                if (in_array($name, $value["child"])) {
                    return array($value["name"], $name);
                }
            }
        }
        return "";
    }

}
