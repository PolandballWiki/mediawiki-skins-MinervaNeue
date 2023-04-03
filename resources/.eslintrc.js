'use strict';

module.exports = {
	root: true,
	extends: [
		'wikimedia/client',
		'wikimedia/jquery',
		'wikimedia/mediawiki'
	],
	env: {
		commonjs: true
	},
	globals: {
		require: 'readonly'
	},
	rules: {
		'no-restricted-properties': [
			'error',
			{
				property: 'mobileFrontend',
				message: 'Minerva should only make use of core code. Any code using mobileFrontend should be placed inside the MobileFrontend extension'
			},
			{
				property: 'define',
				message: 'The method `define` if used with mw.mobileFrontend is deprecated. Please use `module.exports`.'
			},
			{
				property: 'done',
				message: 'The method `done` if used with Deferred objects is incompatible with ES6 Promises. Please use `then`.'
			},
			{
				property: 'fail',
				message: 'The method `fail` if used with Deferred objects is incompatible with ES6 Promises. Please use `then`.'
			},
			{
				property: 'always',
				message: 'The method `always` if used with Deferred objects is incompatible with ES6 Promises. Please use `then`.'
			}
		],
		'object-property-newline': 'error',
		'mediawiki/class-doc': 'off',
		'no-use-before-define': 'off',
		'no-underscore-dangle': 'off',
		'jsdoc/no-undefined-types': 'off'
	},
	overrides: [ {
		files: [ '.eslintrc.js' ],
		extends: 'wikimedia/server',
		rules: {
			'compat/compat': 'off'
		}
	} ]
};
