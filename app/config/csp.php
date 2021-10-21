<?php
/**
 * Content Security Policy (CSP) Configuration File
 * 
 * 
 * This file contains CSP configuration for CSP Library.
 * The HTTP Content-Security-Policy response header allows web site administrators 
 * to control resources the user agent is allowed to load for a given page. 
 * With a few exceptions, policies mostly involve specifying server origins and script endpoints. 
 * This helps guard against cross-site scripting attacks (Cross-site_scripting).
 * 
 * For more information and guides, please visit this links below:
 *
 * 	- https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy
 * 	- https://content-security-policy.com/
 * 	- https://scotthelme.co.uk/content-security-policy-an-introduction/
 * 	- https://scotthelme.co.uk/csp-cheat-sheet/
 * 
 *
 * Valid value for 'source' (NOTICE THE SINGLE QUOTES) :
 * 	
 *  	- General Source : 'none' | 'self'
 * 	 	- Host Source : domain.example.com | *.example.com | https://example.com | http://*.example.com | example.com:443
 * 	 	- Scheme Source : http: | https: | data: | blob: | wss: | filesystem: | mediastream:
 *
 * Valid value for 'mode' (NOTICE THE SINGLE QUOTES) :
 * 		
 * 		'unsafe-inline' | 'unsafe-hashes' | 'unsafe-eval' | 'strict-dynamic' | 'report-sample'
 * 
 * Valid value for 'hash' (NOTICE THE SINGLE QUOTES) :
 *
 *		'<hash-algorithm>-<base64-value>'
 *		Example : 'sha256-OTeu7NEHDo6qutIWo0F2TmYrDhsKWCzrUgGoxxHGJ8o='
 *
 * Valid value for 'nonce' (NOTICE THE SINGLE QUOTES) :
 *
 * 		'nonce-<base64-value>'
 * 		Example : 'nonce-".NONCE."' (Use the NONCE constant to get NONCE VALUE)
 *
 * 
 * @package SIDOTA
 * @author Muhammad Ridwan Na'im
 * @version 5.x
 * @since  2018
 * 
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| HTTP Header Report-To
|--------------------------------------------------------------------------
|
| CSP report-to HTTP Header configuration.
| Set to your API REPORTING ENDPOINTS to activate this HTTP Header.
| 
| Example : '{"group":"default","max_age":31536000,"endpoints":[{"url":"https://report.com/"}],"include_subdomains":true}'
| Default : false
|
*/
$config['report']['report_to_header'] = false;

/*
|--------------------------------------------------------------------------
| Report CSP Directives
|--------------------------------------------------------------------------
|
| CSP report-to directive configuration.
|
| 'report_to'
| 	
|	This directive run in browser which supports CSP 3.
|	Report-To HTTP Header must be active and set to your API REPORTING
| 	ENDPOINTS to activate this directive.
| 
| 	Set your API REPORTING GROUP to activate this directive and set to false to deactivate.
| 	
| 	Example : 'default'
|
| 'report_uri'
|
|	This directive contains URL to report CSP Violation and will be deprecated soon.
|	But many browser still supports this directive. We recommend using this directive 
|	due to backwards compatibility. Leave empty to deactivate this directive.
|
*/
$config['report']['report_to'] 	= 'default';

$config['report']['report_uri'] = '';

/*
|--------------------------------------------------------------------------
| Default CSP Directives
|--------------------------------------------------------------------------
|
| Default CSP or CSP Standard Directives Configuration.
|
| 'block_all_mixed_contents' 
|
|	Activate this directive with set variable to true. It will block all mixed contents 
|	(Content which loaded by HTTP when you use HTTPS). 
|	This feature is DEPRECATED but some old browser still support this directive.
|
| 'upgrade_insecure_requests'
|	
|	Activate this directive with set variable to true. It will instructs 
|	user agents to treat all of a site's insecure URLs (those served over HTTP) 
|	as though they have been replaced with secure URLs (those served over HTTPS).
|
| 'base_uri'
|
|	This directive restricts the URLs which can be used in a document's <base> element. 
|	If this value is absent, then any URI is allowed. 
|	If this directive is absent, the user agent will use the value in the <base> element.
|
| 'frame_ancestors'
|
|	This directive specifies valid parents that may embed a page using 
|	<frame>, <iframe>, <object>, <embed>, or <applet>. Setting this directive to 'none' 
|	is similar to X-Frame-Options: deny (which is also supported in older browsers).
|
| 'default_src'
|
|	This directive serves as a fallback for the other CSP fetch directives. 
|	For each of the following directives that are absent, the user agent looks for the 
|	default-src directive and uses this value for it: 
|		
|		child-src | connect-src | font-src | frame-src | img-src | manifest-src 
|		media-src | object-src | prefetch-src | script-src | script-src-elem
|		script-src-attr | style-src | style-src-elem | style-src-attr | worker-src
|
|
*/
$config['request']['block_all_mixed_content'] 	= false;

$config['request']['upgrade_insecure_requests'] = false;

$config['default']['base_uri'] = array(
	'source'=> ["'self'"]
);

$config['default']['default_src'] = array(
	'source'=> ["'none'"],
	'mode' 	=> [],
	'hash' 	=> [],
	'nonce' => NULL
);

/*
|--------------------------------------------------------------------------
| Scripting CSP Directives
|--------------------------------------------------------------------------
|
| 'script_src'
|
|	This directive specifies valid sources for JavaScript. Includes not only URLs 
|	loaded directly into <script> elements, but also things like inline script,
|	event handlers (onclick) and XSLT stylesheets which can trigger script execution.
|
| 'style_src'
|
|	This directive specifies valid sources for stylesheets.
|
| 'object_src'
|
|	This directive specifies valid sources for the <object>, <embed>, and <applet> elements.
|
| 'worker_src'
|
|	This directive specifies valid sources for Worker, SharedWorker, or ServiceWorker scripts.
|
*/
$config['scripting']['script_src'] 	= array(
	'source'=> [BASE_URL."/_/", "https://unpkg.com/sweetalert2@7.24.1/"],
	'mode' 	=> ["'unsafe-eval'", "'unsafe-inline'", "'report-sample'"],
	'hash' 	=> [],
	'nonce' => "'nonce-".NONCE."'"
);

$config['scripting']['style_src'] 	= array(
	'source'=> [BASE_URL."/_/", "https://fonts.googleapis.com/css", "https://unpkg.com/sweetalert2@7.24.1/"],
	'mode' 	=> ["'unsafe-inline'", "'report-sample'"],
	'hash' 	=> [],
	'nonce' => NULL
);

$config['scripting']['object_src'] 	= array(
	'source'=> ["'none'"],
	'mode' 	=> [],
	'hash' 	=> [],
	'nonce' => NULL
);

$config['scripting']['worker_src'] 	= array(
	'source'=> ["'self'"],
	'mode' 	=> [],
	'hash' 	=> [],
	'nonce' => NULL
);

/*
|--------------------------------------------------------------------------
| Scripting Directives for CSP 3
|--------------------------------------------------------------------------
| 
| These directives use for CSP 3. Activating this directives will replace 
| script-src directive except 'unsafe-eval'. 
| 
|
|	$config['scripting']['script_src_attr'] = array(
|		'source'=> ["'none'"],
|		'mode' 	=> [],
|		'hash' 	=> [],
|		'nonce' => NULL
|	);
|
|	$config['scripting']['script_src_elem'] = array(
|		'source'=> ["'none'"],
|		'mode' 	=> [],
|		'hash' 	=> [],
|		'nonce' => NULL
|	);
|
| These directives use for CSP 3. Activating this directives will replace 
| style-src directive. 
|
|
|	$config['scripting']['style_src_attr'] = array(
|		'source'=> ["'none'"],
|		'mode' 	=> [],
|		'hash' 	=> [],
|		'nonce' => NULL
|	);
|
|	$config['scripting']['style_src_elem'] = array(
|		'source'=> ["'none'"],
|		'mode' 	=> [],
|		'hash' 	=> [],
|		'nonce' => NULL
|	);
|
*/

/*
|--------------------------------------------------------------------------
| Frame CSP Directives
|--------------------------------------------------------------------------
|
| 'frame_src'
|
|	This directive specifies valid sources for nested browsing contexts 
|	loading using elements such as <frame> and <iframe>.
|
| 'child_src'
|
|	This directive defines the valid sources for web workers and nested browsing contexts 
|	loaded using elements such as <frame> and <iframe>.
|
| 'frame_ancestors'
|
|	This directive specifies valid parents that may embed a page using 
|	<frame>, <iframe>, <object>, <embed>, or <applet>. Setting this directive to 'none' 
|	is similar to X-Frame-Options: deny (which is also supported in older browsers).
|
|
*/
$config['frame']['frame_src'] = array(
	'source'=> ["'none'"]
);

$config['frame']['child_src'] = array(
	'source'=> ["'none'"]
);

$config['frame']['frame_ancestors'] = array(
	'source'=> ["'self'"]
);

/*
|--------------------------------------------------------------------------
| Content CSP Directives
|--------------------------------------------------------------------------
|
| 'img_src'
|
|	This directive specifies valid sources of images and favicons.
|
| 'font_src'
|
|	This directive specifies valid sources of web fonts.
|
| 'connect_src'
|
|	This directive restricts the URLs which can be loaded using script interfaces. 
|	The APIs that are restricted are:
|
|	- <a> ping,
|	- WindowOrWorkerGlobalScope.fetch,
|	- XMLHttpRequest,
|	- WebSocket,
|	- EventSource, and
|	- Navigator.sendBeacon().
|
| 'manifest_src'
|
|	This directive specifies which manifest can be applied to the resource.
|
| 'media_src'
|
|	This directive specifies valid sources for loading media using the <audio> and <video> elements.
|
| 'prefetch_src'
|
|	This directive specifies valid resources that may be prefetched or prerendered.
|
*/
$config['content']['img_src'] 	= array(
	'source'=> [
		"data:",
		BASE_URL."/_/",
		"https://www.gstatic.com/images/",
		"https://images.unsplash.com"
	],
);

$config['content']['font_src'] 	= array(
	'source'=> [
		BASE_URL."/_/fonts/",
		BASE_URL."/_/vendors/",
		"https://fonts.gstatic.com/s/nunito/",
		"data:"
	],
);

$config['content']['connect_src']= array(
	'source'=> ["'self'"]
);

$config['content']['manifest_src'] = array(
	'source'=> ["'none'"],
);

$config['content']['media_src'] = array(
	'source'=> ["'self'"]
);

$config['content']['prefetch_src'] = array(
	'source'=> ["'none'"]
);

/*
|--------------------------------------------------------------------------
| Other CSP Directives
|--------------------------------------------------------------------------
|
| 'navigate_to'
|
|	 This directive restricts the URLs to which a document can initiate 
|	navigations by any means including <form> (if form-action is not specified), 
|	<a>, window.location, window.open, etc. 
|
|	This is an enforcement on what navigations this document initiates 
|	not on what this document is allowed to navigate to.
|
| 'form_action'
|
|	This directive restricts the URLs which can be used as the target of 
|	a form submissions from a given context.
|
*/
$config['other']['navigate_to'] = array(
	'source'=> ["'self'"]
);

$config['other']['form_action'] = array(
	'source'=> ["'self'"]
);