 <?php
/**
 * 树处理
 * 江南
 * 2014-7-03
 */
class Tree
{    
	//生成树结构的数据结构
	public static function getTreeData($arr, $parentColumnName='pid') {
		
		$temp = $tree = array();
		foreach($arr as $k => $v){
			$temp[$v['id']] = $v;
		}
		//引用构造树
		foreach($arr as $k => $v){
			if(isset($temp[$v[$parentColumnName]])){	
				$temp[$v[$parentColumnName]]['children'][] = &$temp[$v['id']];
			}else{
				$tree[] = &$temp[$v['id']];
			}
		}
		return $tree;
	}

    /**
     * select树结构html代码生成
     * @param array $tree
	 * @param int $selectid		默认选中的ID
     */
     public static function selectTreeHtml(&$tree, $selectid = 1, &$step = '', $html = ''){
		if(empty($tree) || !is_array($tree)) return '';
		//生成select代码
		foreach($tree as $v){
			$selected = '';
			if($v['id'] == $selectid) {
				$selected = 'selected';
			}
			$html .= "<option value=\"{$v['id']}\" {$selected}>{$step}{$v['classname']}</option>";
			if(isset($v['children'])){
				$step .= '&nbsp;&nbsp;&nbsp;&nbsp;';		
				$html = self::selectTreeHtml($v['children'], $selectid, $step, $html);		
			}else{
				$step = '';
			}
		}
		return $html;
	}
}
