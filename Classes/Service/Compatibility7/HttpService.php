<?php

namespace R3H6\Error404page\Service\Compatibility7;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 3 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;

/**
 * HttpService
 */
class HttpService extends \R3H6\Error404page\Service\HttpService
{
    /**
     * {@inheritDoc}
     */
    public function readUrl($url)
    {
        $content = null;
        $url = $this->appendSignature($url);

        /** @var \TYPO3\CMS\Core\Http\HttpRequest $request */
        $request = $this->getHttpRequest($url);

        try {
             /** @var \HTTP_Request2_Response $response */
            $response = $request->send();
            if ($response->getStatus() !== 200) {
                throw new \RuntimeException($response->getReasonPhrase(), 1477079525);
            }
            $content = $response->getBody();
        } catch (\Exception $exception) {
            $this->getLogger()->debug('Could not read url "' . $url . '" ' . $exception->getMessage());
        }

        return $content;
    }

    /**
     * Creates a request object.
     *
     * @param  string $url
     * @return \TYPO3\CMS\Core\Http\HttpRequest
     */
    protected function getHttpRequest($url)
    {
        /** @var \TYPO3\CMS\Core\Http\HttpRequest $request */
        $request = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Http\\HttpRequest');
        $request->setUrl($url); // For testing purpose not set in constructor!

        $feCookieName = $GLOBALS['TYPO3_CONF_VARS']['FE']['cookieName'];

        // Forward cookies.
        $request->setCookieJar(true);
        if (isset($_COOKIE[$feCookieName]) && !empty($_COOKIE[$feCookieName])) {
            $request->addCookie($feCookieName, $_COOKIE[$feCookieName]);
        }

        // TYPO3 uses user-agent for authentification.
        $request->setHeader('user-agent', GeneralUtility::getIndpEnv('HTTP_USER_AGENT'));

        // Set basic authentication.
        if ($this->extensionConfiguration->has('basicAuthentication')) {
            $basicAuthentication = GeneralUtility::trimExplode(':', $this->extensionConfiguration->get('basicAuthentication'), true);
            $request->setAuth($basicAuthentication[0], $basicAuthentication[1]);
        }

        return $request;
    }
}
