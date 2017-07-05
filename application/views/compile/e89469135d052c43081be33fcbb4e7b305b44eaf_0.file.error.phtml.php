<?php
/* Smarty version 3.1.31, created on 2017-07-04 13:21:21
  from "/work/bcache/application/views/error/error.phtml" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_595b25d1e65641_41459054',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e89469135d052c43081be33fcbb4e7b305b44eaf' => 
    array (
      0 => '/work/bcache/application/views/error/error.phtml',
      1 => 1499076098,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_595b25d1e65641_41459054 (Smarty_Internal_Template $_smarty_tpl) {
echo '<?php
';?>echo "Error Msg:"  . $exception->getMessage();
<?php echo '?>';
}
}
