<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha;

use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Configuration
{
    public const DEFAULT_JS_PATH = 'EXT:friendlycaptcha_official/Resources/Public/JavaScript/lib/widget-0.9.12.min.js';

    protected string $siteKey = '';
    protected string $siteSecretKey = '';
    protected string $puzzleUrl = '';
    protected string $verifyUrl = '';
    protected string $jsPath = '';

    public function __construct(Site $site = null)
    {
        if ($site === null) {
            $site = $GLOBALS['TYPO3_REQUEST']->getAttribute('site');
        }
        if ($site === null) {
            return;
        }
        $siteConfiguration = $site->getConfiguration();
        $this->siteKey = trim($siteConfiguration['friendlycaptcha_site_key'] ?? '');
        $this->siteSecretKey = trim($siteConfiguration['friendlycaptcha_secret_key'] ?? '');
        $this->puzzleUrl = trim($siteConfiguration['friendlycaptcha_puzzle_url'] ?? '');
        $this->verifyUrl = trim($siteConfiguration['friendlycaptcha_verify_url'] ?? '');
        $this->jsPath = trim($siteConfiguration['friendlycaptcha_js_path'] ?? '');
    }

    public function isEnabled(): bool
    {
        return $this->siteKey !== '' && $this->siteSecretKey !== '' && $this->puzzleUrl !== '' && $this->verifyUrl !== '';
    }

    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    public function getSiteSecretKey(): string
    {
        return $this->siteSecretKey;
    }

    public function getPuzzleUrl(): string
    {
        return $this->puzzleUrl;
    }

    public function getVerifyUrl(): string
    {
        return $this->verifyUrl;
    }

    public function getFirstVerifyUrl(): string
    {
        $urls = GeneralUtility::trimExplode(',', $this->verifyUrl, true);
        return $urls[0] ?? '';
    }

    public function getJsPath(): string
    {
        return $this->jsPath ?: self::DEFAULT_JS_PATH;
    }
}
