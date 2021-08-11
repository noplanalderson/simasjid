<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CSP_Header {

	public $config = [];

	protected $_CI;

	public function __construct()
	{
		include APPPATH . 'config/csp.php';

		$this->config = $config;

		$this->_CI =& get_instance();
	}

	protected function _reportURI()
	{
		$reportURI 	= false;
		$reportTo 	= false;

		if(!empty($this->config['report']['report_to_header'])) {
			$this->_CI->output->set_header('Report-To: '. $this->config['report']['report_to_header']);
		}

		if(!empty($this->config['report']['report_to_header']) && $this->config['report']['report_to_header'] !== false) {
			$reportTo = 'report-to '.$this->config['report']['report_to'].';';
		}

		if(!empty($this->config['report']['report_uri']) && $this->config['report']['report_uri'] !== false) {
			$reportURI = 'report-uri '.$this->config['report']['report_uri'].';';
		}

		return $reportURI . ' ' . $reportTo;
	}

	protected function _defaultDirective()
	{
		$generals = [];

		foreach ($this->config['default'] as $key => $directive) {
			if(is_array($directive) && array_key_exists('source', $directive)) {
				$generals[] = $this->_csp($key, $directive);
			}
		}

		$block_all_mixed_content = ($this->config['request']['block_all_mixed_content'] === true) ? 'block-all-mixed-content;' : null;

		$upgrade_insecure_requests = ($this->config['request']['upgrade_insecure_requests'] === true) ? 'upgrade-insecure-requests;' : null;

		return $block_all_mixed_content . ' ' . $upgrade_insecure_requests . ' ' . implode(' ', $generals);
	}

	protected function _scriptingDirective()
	{
		$scriptings = [];

		foreach ($this->config['scripting'] as $key => $directive) {
			if(is_array($directive) && array_key_exists('source', $directive)) {
				$scriptings[] = $this->_csp($key, $directive);
			}
		}

		return implode(' ', $scriptings);
	}

	protected function _frameDirective()
	{
		$frames = [];

		foreach ($this->config['frame'] as $key => $directive) {
			if(is_array($directive) && array_key_exists('source', $directive)) {
				$frames[] = $this->_csp($key, $directive);
			}
		}

		return implode(' ', $frames);
	}

	protected function _contentDirective()
	{
		$contents = [];

		foreach ($this->config['content'] as $key => $directive) {

			if(is_array($directive) && array_key_exists('source', $directive)) {
				$contents[] = $this->_csp($key, $directive);
			}
		}

		return implode(' ', $contents);
	}

	protected function _otherDirective()
	{
		$others = [];

		foreach ($this->config['other'] as $key => $directive) {

			if(is_array($directive) && array_key_exists('source', $directive)) {
				$others[] = $this->_csp($key, $directive);
			}
		}
		
		return implode(' ', $others);
	}

	protected function _csp($key, $directive)
	{
		$wildcard 	= in_array("*", $directive['source']) ? "*" : false;
		$none 		= in_array("'none'", $directive['source']) ? "'none'" : false;
		$modes 		= NULL;
		$hashes 	= NULL;
		$nonce 		= NULL;

		if($wildcard === false && $none === false) {
			$sources = implode(' ', $directive['source']);
		}
		elseif($wildcard !== false) {
			$sources = "*";
		}
		else {
			$sources = "'none'";
		}

		if(array_key_exists('mode', $directive) == true) {
			$modes 	= ($none === false) ? implode(' ', $directive['mode']) : NULL;
		}

		if(array_key_exists('hash', $directive) == true) {
			$hashes = ($none === false && $wildcard === false) ? implode(' ', $directive['hash']) : NULL;
		}

		if(array_key_exists('nonce', $directive) == true) {
			$nonce 	= ($none === false && $wildcard === false) ? $directive['nonce'] : NULL;
		}

		return str_replace('_', '-', $key) . ' ' . $modes . ' ' .  $hashes . ' ' . $nonce . ' ' . $sources . ';';
	}

	public function generateCSP()
	{
		$report 	= $this->_reportURI();
		$default 	= $this->_defaultDirective();
		$scripting 	= $this->_scriptingDirective();
		$frame 		= $this->_frameDirective();
		$content 	= $this->_contentDirective();
		$other 		= $this->_otherDirective();

		$this->_CI->output->set_header('Content-Security-Policy: ' . $default . ' ' . $scripting . ' ' . $frame . ' ' . $content . ' ' . $other . ' ' . $report);
	}
}