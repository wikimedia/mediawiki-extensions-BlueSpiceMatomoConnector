<?php

namespace BlueSpice\MatomoConnector\Hook\BlueSpicePrivacyCookieConsentProviderGetGroups;

use BlueSpice\Privacy\Hook\BlueSpicePrivacyCookieConsentProviderGetGroups;

class AddMatomoCookieGroup extends BlueSpicePrivacyCookieConsentProviderGetGroups {

	/**
	 * @return bool
	 */
	protected function skipProcessing() {
		if (
			!$this->getConfig()->get( 'MatomoConnectorBaseUrl' ) ||
			!$this->getConfig()->get( 'MatomoBlueSpicePrivacyIntegration' )
		) {
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	protected function doProcess() {
		$baseUrl = $this->getConfig()->get( 'MatomoConnectorBaseUrl' );
		$baseUrl = rtrim( $baseUrl, '/' );
		$this->groups['matomo'] = [
			'label' => 'bs-matomoconnector-privacy-cookie-group',
			'desc' => 'bs-matomoconnector-privacy-cookie-group-desc',
			'type' => 'opt-out',
			'cookies' => [],
			'jsCallback' => [
				'module' => 'ext.bluespice.matomoConnector.privacy',
				'args' => [
					'url' => "$baseUrl/index.php?module=API&method=AjaxOptOut"
				],
				'callback' => 'BsMatomoConnector.privacy.onSaveCookiePreferences'
			]
		];

		return true;
	}
}
