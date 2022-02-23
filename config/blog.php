<?php

return [
	/*
	 * Configure settings related to the blog.
	 */

	// Should tags be enabled? Tip: you can customize the name in the en\blog.php lang file, for example, in case you want to call them categories.
	'withTags' => env('BLOGKIT_TAGS_ENABLED', true), // Default: true

	// Should tags be shown on the post card component? Feel free to disable this to reduce clutter.
	'showTagsOnPostCard' => env('BLOGKIT_TAGS_ENABLED_ON_CARDS', true), // Default: true

	// Should the updated at time be shown on edited posts?
	'showUpdatedAt' => true, // Default: true

	// Can users register for accounts? Note that while disabling this removes the registration route completely, you can still log in by going to the /login route.
	'allowRegistrations' => env('BLOGKIT_REGISTRATIONS_ENABLED', true), // Default: true

	// Can users leave comments?
	'allowComments' => env('BLOGKIT_COMMENTS_ENABLED', true), // Default: true

	// Do users have to verify their emails to post comments? Note: make sure that you have set up the mailer before enabling this!
	'requireVerifiedEmailForComments' => env('BLOGKIT_COMMENTS_VERIFY_EMAIL', false), // Default: false

	// Should the site be in demo mode? (Do NOT use in production)
	'demoMode' => env('BLOGKIT_DEMO_MODE', false), // Default: false

	// Should the Readme file be available as a '/readme route?
	'readme' => false, // Default: false

	// Enable ban feature?
	'bans' => env('BLOGKIT_BANS_ENABLED', true), // Default: true

	/**
	 * Content License
	 * 
	 * What license should your blog posts be published under?
	 * 
	 * In the spirit of free and open source you can keep this as the default Creative Commons,
	 * or you can set it to something other, such as "All Rights Reserved"
	 * 
	 * In the future you will be able to override this on a post-by-post basis
	 */
	'contentLicense' => [
		'enabled' => true, // Should the content license feature be enabled?
		'name' => 'CC BY-SA 4.0', // The name of the license
		'link' => 'http://creativecommons.org/licenses/by-sa/4.0/' // Link to the license text
	],

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
		'enabled' => env('BLOGKIT_EASYMDE_ENABLED', true), // Default: true

		// Customize the editor toolbar buttons
		'toolbar' => env('BLOGKIT_EASYMDE_TOOLBAR', null), // Default: null (use default toolbar)

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
		'enabled' => env('BLOGKIT_TORCHLIGHT_ENABLED', false), // Default: false
		// Should an attribution badge be automatically injected on posts that use it? (Required if on the free plan)
		'attribution' => true, // Default: true
	]

];
