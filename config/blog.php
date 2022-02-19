<?php

return [
	/*
	 * Configure settings related to the blog.
	 */

	// Can users register for accounts? Note that while disabling this removes the registration route completely, you can still log in by going to the /login route.
	'allowRegistrations' => true, // Default: true

	// Can users leave comments?
	'allowComments' => true, // Default: true

	// Do users have to verify their emails to post comments? Note: make sure that you have set up the mailer before enabling this!
	'requireVerifiedEmailForComments' => false, // Default: false

	// Should the site be in demo mode? (Do NOT use in production)
	'demoMode' => false, // Default: false

	// Should the Readme file be available as a '/readme route?
	'readme' => false, // Default: false

	// Enable ban feature?
	'bans' => true, // Default: true

	/**
	 * EasyMDE Text Editor
	 * 
	 * This is the default text editor used when creating and updating posts.
	 * 
	 * If you disable this, a normal HTML textarea will be used instead. It will still output markdown, but without the fancy editing and preview.
	 * 
	 * @see https://github.com/Ionaru/easy-markdown-editor
	 */

	'easyMDE' => [
		// Should EasyMDE be enabled?
		'enabled' => true, // Default: true

		// Customize the editor toolbar buttons
		'toolbar' => null, // Default: null (use default toolbar)

		// The toolbars available - note that the toolbar icons added are in addition to the default ones
		'toolbars' => [
			// The full suite
			'extended' => [
				'strikethrough', 'code', 'table', 'redo', 'heading', 'undo', 'heading-bigger', 'heading-smaller', 'heading-1', 'heading-2', 'heading-3', 'clean-block', 'horizontal-rule'
			],
			// Perfect for the developer
			'developer' => [
				'code'
			],
			'custom' => [
				// Write your own
			]
		]
	],

	/*
	 * Torchlight Syntax Highlight
	 * 
	 * Highly recommended if your blog uses a lot of code examples.
	 * 
	 * You need to register for an account with Torchlight to use this feature.
	 * Torchlight is free for Personal / Open Source Use.
	 * 
	 * Remember to set your API token in config/torchlight.php
	 * 
	 * @see https://torchlight.dev/
	 * @see https://torchlight.dev/docs
	 */

	'torchlight' => [
		// Should Torchlight be enabled?
		'enabled' => false, // Default: false
		// Should an attribution badge be automatically injected on posts that use it? (Required if on the free plan)
		'attribution' => true, // Default: true
	]

];
