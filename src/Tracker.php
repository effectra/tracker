<?php

declare(strict_types=1);

namespace Effectra\Tracker;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Tracker
 *
 * This class provides methods to extract information from the client's request.
 *
 * @package Effectra\Tracker
 */
class Tracker
{

    /**
     * Tracker constructor.
     *
     * @param ServerRequestInterface $request The server request.
     */
    public function __construct(protected ServerRequestInterface $request)
    {
    }

    /**
     * Get the client's IP address.
     *
     * @return string The client's IP address.
     */
    public function getIp(): string
    {
        $serverParams = $this->request->getServerParams();
        $remoteAddress = $serverParams['REMOTE_ADDR'] ?? null;

        if (isset($serverParams['HTTP_X_FORWARDED_FOR'])) {
            $forwardedFor = explode(',', $serverParams['HTTP_X_FORWARDED_FOR']);
            foreach ($forwardedFor as $ip) {
                $ip = trim($ip);
                if ($ip !== '') {
                    return $ip;
                }
            }
        }

        return $remoteAddress;
    }

    /**
     * Get the client's browser name and version.
     *
     * @return array The client's browser name and version.
     */
    public function getBrowser()
    {
        $userAgent = $this->getUserAgent();
        // Define patterns for common browsers
        $patterns = array(
            '/(MSIE|Trident).*?([\d.]+)/' => 'Internet Explorer',
            '/Firefox\/([\d.]+)/' => 'Firefox',
            '/OPR\/([\d.]+)/' => 'Opera',
            '/Chrome\/([\d.]+)/' => 'Chrome',
            '/Version\/([\d.]+).*?Safari/' => 'Safari',
        );
        $browserName = 'Unknown';
        $browserVersion = 'Unknown';

        foreach ($patterns as $pattern => $browser) {
            if (preg_match($pattern, $userAgent, $matches)) {
                $browserName = $browser;
                $browserVersion = $matches[1];
                break;
            }
        }
        return [
            'name' => $browserName,
            'version' => $browserVersion,
        ];
    }
    /**
     * Get the client's operating system name and version.
     *
     * @return array The client's operating system name and version.
     */
    public function getOs()
    {
        $userAgent = $this->getUserAgent();
        // Define patterns for operating systems
        $osPatterns = array(
            '/Windows NT 10/' => 'Windows 10',
            '/Windows NT 6\.3/' => 'Windows 8.1',
            '/Windows NT 6\.2/' => 'Windows 8',
            '/Windows NT 6\.1/' => 'Windows 7',
            '/Android (\d+\.\d+)/' => 'Android',
            '/iPhone OS (\d+)/' => 'iOS',
            '/iPad.*?OS (\d+)/' => 'iOS',
            '/Mac OS X (\d+)[._](\d+)/' => 'macOS',
            '/Linux/' => 'Linux',
        );
        $osName = 'Unknown';
        $osVersion = 'Unknown';

        // Search for operating system patterns in the user agent string
        foreach ($osPatterns as $osPattern => $os) {
            if (preg_match($osPattern, $userAgent, $matches)) {
                $osName = $os;
                $osVersion = isset($matches[1]) ? $matches[0] . '.' . $matches[1] : $matches[0];
                break;
            }
        }

        return [
            'name' => $osName,
            'version' => $osVersion,
        ];
    }
    /**
     * Get the client's device type.
     *
     * @return string The client's device type.
     */
    public function getDevice(): string
    {
        $userAgent = $this->getUserAgent();
        // Initialize the device variable
        $device = 'Unknown';

        // Define patterns for device types
        $devicePatterns = array(
            '/(iPhone|iPod|Android|Windows Phone)/' => 'Phone',
            '/iPad/' => 'Tablet',
            '/Windows/' => 'Desktop',
            '/Macintosh|Mac OS X/' => 'Mac',
            '/Linux/' => 'Linux',
        );

        // Search for device type patterns in the user agent string
        foreach ($devicePatterns as $devicePattern => $deviceType) {
            if (preg_match($devicePattern, $userAgent)) {
                $device = $deviceType;
                break;
            }
        }

        return $device;
    }
    /**
     * Get the client's user agent.
     *
     * @return string The client's user agent.
     */
    public function getUserAgent()
    {
        return $this->request->getHeaderLine('User-Agent');
    }
    /**
     * Get the accepted languages from the client's request.
     *
     * @return array The accepted languages.
     */
    public function getAcceptLangs()
    {
        $langs = [];
        $accept_lang = explode(",", $this->request->getHeaderLine('Accept-Language'));
        foreach ($accept_lang as $lang) {
            $langs[] = explode(';', $lang)[0] ?? $lang;
        }
        return $langs;
    }
    /**
     * Get the referer URL from the client's request.
     *
     * @return string The referer URL.
     */
    public function getReferer()
    {
        return $this->request->getHeaderLine('referer');
    }
    /**
     * Check if the client is using a phone device.
     *
     * @return bool Whether the client is using a phone device.
     */
    public function isPhone(): bool
    {
        $userAgent = $this->getUserAgent();
        // Define patterns for phone user agents
        $phonePatterns = array(
            '/iPhone/',
            '/iPod/',
            '/Android/',
            '/Windows Phone/',
        );

        // Check if any of the phone patterns match the user agent
        foreach ($phonePatterns as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Convert the client's information to an associative array.
     *
     * @return array The client's information as an array.
     */
    public function getAll(): array
    {
        return   [
            'os' => $this->getOs(),
            'device' => $this->getDevice(),
            'browser' => $this->getBrowser(),
            'accept_lang' => $this->getAcceptLangs(),
            'referer' => $this->getReferer(),
            'is_phone' => $this->isPhone(),
        ];
    }
}
