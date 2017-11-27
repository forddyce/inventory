<?php

return [
	'withdrawAdminFee'	=>	5, // in percent
	'bonusDirect' => 50, // purchase point, in USD
	'bonus'	=>	[
		'calculation' => [ // in percent
			'cash'	=>	70,
			'promotion'	=>	30
		],
	],
	'countries' => [
		'Cambodia' => [
			'currency'	=>	'KHR',
			'buy'	=>	'5100.00',
			'sell'	=>	'4000.00',
			'banks'	=>	[
				'Public Bank',
				'MayBank',
				'ACLEDA Bank'
			]
		],
		'Indonesia'	=>	[
			'currency'	=>	'IDR',
			'buy'	=>	'14000.00',
			'sell'	=>	'11500.00',
			'banks'	=>	[
				'BCA Bank',
				'Mandiri Bank'
			]
		],
		'Philippines'	=>	[
			'currency'	=>	'PHP',
			'buy'	=>	'48.00',
			'sell'	=>	'41.00',
			'banks'	=>	[
				'RCBC Bank',
				'BPI Bank',
				'Metro Bank',
				'BDO Bank',
				'Land Bank of the Phillipines',
				'PNB Phillipines'
			]
		],
		'Thailand'	=>	[
			'currency'	=>	'THB',
			'buy'	=>	'40.00',
			'sell'	=>	'32.00',
			'banks'	=>	[
				'TMB Bank',
				'Krungsri Bank',
				'Kasikom',
				'Siam Commercial Bank',
				'Siam City Bank',
				'Bangkok Bank'
			]
		],
		'Vietnam'	=>	[
			'currency'	=>	'VND',
			'buy'	=>	'25000.00',
			'sell'	=>	'21000.00',
			'banks'	=>	[
				'ABC Asia Pacific',
				'VietComBank',
				'BIDV Bank'
			]
		],
		'China'	=>	[
			'currency'	=>	'CNY',
			'buy'	=>	'7.00',
			'sell'	=>	'6.00',
			'banks'	=>	[
				'ICBC Bank (工商银行)',
				'CMB Bank (招商银行)',
				'Bank of China (中国银行)',
				'ABC Bank (农业银行)'
			]
		],
		'Singapore'	=>	[
			'currency'	=>	'SGD',
			'buy'	=>	'1.60',
			'sell'	=>	'1.30',
			'banks'	=>	[
				'UOB Bank'
			]
		],
		'Malaysia'	=>	[
			'currency'	=>	'MYR',
			'buy'	=>	'4.50',
			'sell'	=>	'4.00',
			'banks'	=>	[
				'Maybank',
				'Public Bank',
				'CIMB Bank',
				'RHB Bank'
			]
		],
		'Taiwan'	=>	[
			'currency'	=>	'TWD',
			'buy'	=>	'35.00',
			'sell'	=>	'30.00',
			'banks'	=>	[
				'CTBC Bank (中国信托商业银行)',
				'Bank of Taiwan (台湾银行)',
				'Esun Bank (玉山银行)'
			]
		],
	]
];