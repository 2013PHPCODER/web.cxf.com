<?php

return array(
    'view_filter' => array('Behavior\TokenBuildBehavior'),
    'app_begin' => array('Behavior\CheckLangBehavior'),
    'LANG_SWITCH_ON' => true,
    'LANG_AUTO_DETECT' => true,
    'LANG_LIST' => 'zh-cn',
    'VAR_LANGUAGE' => 'l',
);