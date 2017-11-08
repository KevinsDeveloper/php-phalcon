<?php

/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    Kevin
 * @time      2017/10/21 0021 上午 11:17
 */
class Tree
{
    /**
     * @desc
     * @var string
     */
    private static $instance = null;

    /**
     * @desc
     * @var string
     */
    public $defTree = ['tree_lt' => 0, 'tree_rt' => 1, 'tree_rank' => 0];

    /**
     * @desc
     * @access public
     * @param  object $model model对象
     */
    private function __construct()
    {

    }

    /**
     * @desc   单例模式
     * @access public
     * @return array
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @desc   获取树 左值、右值、id
     * @access public
     * @param  int $pid
     * @return array
     */
    public function getTreeInfo($p_data)
    {
        if (!is_array($p_data)) return $this->defTree;
        $this->defTree['tree_lt'] = $p_data['tree_lt'] + 1;
        $this->defTree['tree_rt'] = $p_data['tree_rt'] + 1;
        $this->defTree['tree_rank'] = $p_data['tree_rank'];
        return $this->defTree;
    }

    /**
     * @desc   添加树
     * @access public
     * @param  int $tree_lt 左值
     * @param  int $tree_rt 右值
     * @param  int $tree_rank
     * @return array
     */
    public function addTree($table, $tree)
    {
        $sql = [];
        $sql[] = "UPDATE " . $table . " SET tree_rt=tree_rt+2 WHERE tree_rt>=" . $tree['tree_rt'] . " AND tree_rank=" . $tree['tree_rank'];
        $sql[] = "UPDATE " . $table . " SET tree_lt=tree_lt+1, tree_rt=tree_rt+1 WHERE tree_lt>" . $tree['tree_lt'] . " AND tree_rank=" . $tree['tree_rank'];
        return $sql;
    }

    /**
     * @desc   修改树
     * @access public
     * @param  int $tree_lt 左值
     * @param  int $tree_rt 右值
     * @param  int $tree_rank
     * @return array
     */
    public function updateTree($newPid, $oldTree, $newTree)
    {
        $sql = [];
        if ($oldTree['tree_rank'] != $newPid) {
            // 从旧树中删除
            $sql[] = "UPDATE " . $table . " SET tree_lt=tree_lt-1, tree_rt=tree_rt-1 WHERE tree_lt>" . $oldTree['tree_lt'] . " AND tree_rank=" . $oldTree['tree_rank'];
            $sql[] = "UPDATE " . $table . " SET tree_rt=tree_rt-2 WHERE tree_rt>=" . $oldTree['tree_rt'] . " AND tree_rank=" . $oldTree['tree_rank'];

            // 从新树中新增节点
            if ($newPid > 0) {
                $sql[] = "UPDATE " . $table . " SET tree_rt=tree_rt+2 WHERE tree_rt>=" . $newTree['tree_rt'] . " AND tree_rank=" . $newTree['tree_rank'];
                $sql[] = "UPDATE " . $table . " SET tree_lt=tree_lt+1, tree_rt=tree_rt+1 WHERE tree_lt>" . $newTree['tree_lt'] . " AND tree_rank=" . $newTree['tree_rank'];
            }
        }
    }

    /**
     * @desc   删除树
     * @access public
     * @param  int $tree_lt 左值
     * @param  int $tree_rt 右值
     * @param  int $tree_rank
     * @return array
     */
    public function delTree($table, $tree)
    {
        $sql = [];
        $sql[] = "UPDATE " . $table . " SET tree_lt=tree_lt-1, tree_rt=tree_rt-1 WHERE tree_lt>" . $tree['tree_lt'] . " AND tree_rank=" . $tree['tree_rank'];
        $sql[] = "UPDATE " . $table . " SET tree_rt=tree_rt-2 WHERE tree_rt>=" . $tree['tree_rt'] . " AND tree_rank=" . $tree['tree_rank'];
        return $sql;
    }
}

?>