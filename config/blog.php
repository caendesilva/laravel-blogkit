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
