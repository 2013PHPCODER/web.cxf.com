<?php
/*
*验证码配置
*/

return [

/*根据需要场景添加*/
	'target'=>[					//验证码的使用场景，根据需要在此处增加,健名为场景，键值为数据库实际存储的值
		'fx_registe'=>1,
		'gh_registe'=>2,
                'change_pwd'=>3,
	],
	'default'=>[					//默认配置
		'wrong_times'=>5,			//运行错误次数，默认5次，超过后失效
		'timespan'=>2,				//下次发送时间，默认1分钟
		'expire'=>600,				//过期时间，默认10分钟
	],

	'fx_registe'=>[					//针对fx_registe场景的特殊配置，没有设置的属性将以default为准
		'expire'=>300,				//fx_register场景过期时间为5分钟，	
	],
/*根据需要场景添加*/



/*邮件的相关设置*/
	'email'=>[						//发送验证码的邮件服务器
		'qq'=>[
			'host'=>'smtp.exmail.qq.com',
			'account'=>'sudongpo@mycxf.com',
			'pwd'=>'Abc123456',
		],
		'163'=>[
			'host'=>'smtp.ym.163.com',
			'account'=>'admin@5icxf.com',
			'pwd'=>'Cxf123456',
		],
		'default'=>[					//默认使用的发送邮箱
			'host'=>'smtp.ym.163.com',
			'account'=>'admin@5icxf.com',
			'pwd'=>'Cxf123456',
			'template'=>[										//内容模板
				'verify'=>'您的验证码是{}，请于10分钟内完成验证。</br>创想范',
			],
		],
	],

];