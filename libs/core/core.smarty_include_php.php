<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * called for included php files within templates
 *
 * @param string $smarty_file
 * @param string $smarty_assign variable to assign the included template's
 *               output into
 * @param boolean $smarty_once uses include_once if this is true
 * @param array $smarty_include_vars associative array of vars from
 *              {include file="blah" var=$var}
 */    

// 	$file, $assign, $once, $_smarty_include_vars	 		  
		 
function smarty_core_smarty_include_php($params, &$this)
{
	$_params = array('resource_name' => $params['smarty_file']);
	require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.get_php_resource.php');
	smarty_core_get_php_resource($_params, $this);
	$_smarty_resource_type = $_params['resource_type'];
	$_smarty_php_resource = $_params['php_resource'];

    extract($params['smarty_include_vars'], EXTR_PREFIX_SAME, 'include_php_');

    if (!empty($params['smarty_assign'])) {
        ob_start();
        if ($_smarty_resource_type == 'file') {
            if($params['smarty_once']) {
                include_once($_smarty_php_resource);
            } else {
                include($_smarty_php_resource);                    
            }
        } else {
            eval($_smarty_php_resource);
        }
        $this->assign($params['smarty_assign'], ob_get_contents());
        ob_end_clean();
    } else {
        if ($_smarty_resource_type == 'file') {
            if($params['smarty_once']) {
                include_once($_smarty_php_resource);
            } else {
                include($_smarty_php_resource);                    
            }
        } else {
            eval($_smarty_php_resource);
        }
    }
}


/* vim: set expandtab: */

?>
