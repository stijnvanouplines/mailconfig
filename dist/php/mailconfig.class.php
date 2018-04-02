<?php

class MailConfig
{
    /**
     * The array of configuration variables.
     *
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Method to get URI.
     *
     * @return string
     */
    protected function getUri() : string
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
        }
        else {
            if (isset($_SERVER['argv'])) {
                $uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['argv'][0];
            }
            elseif (isset($_SERVER['QUERY_STRING'])) {
                $uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];
            }
            else {
                $uri = $_SERVER['SCRIPT_NAME'];
            }
        }

        $uri = trim($uri, '/');

        return explode('?', $uri)[0] ?: '';
    }

    /**
     * Method to determine which template to use.
     *
     * @return string
     */
    public function determineTemplate(string $default = '') : string
    {
        return ! empty($this->getUri()) ? explode('?', $this->getUri())[0] : $default;
    }

    /**
     * Method to load the template file.
     *
     * @param string $template
     * @return string
     */
    public function loadTemplate(string $template = '') : string
    {
        $template = ! empty($template) ? $template : $this->determineTemplate();

        switch ($template) {
            case 'autoconfig':
                $filename = 'xml/autoconfig.xml';
                break;
            case 'mobileconfig':
                $filename = 'xml/mobileconfig.xml';
                break;
            default:
                $filename = 'xml/autodiscover.xml';
                break;
        }

        $file = file_get_contents(dirname(__DIR__) . '/' . $filename);
        $xml = $this->replaceVariables($file);

        return ($this->determineTemplate() == 'mobileconfig') ? $this->signMobileconfig($xml) : $xml;
    }

    /**
     * Method to replace variables in xml.
     *
     * @param string $xml
     * @return string
     */
    protected function replaceVariables(string $xml) : string
    {
        $xml = str_replace("%COMPANY_NAME%", $this->config['company_name'], $xml);
        $xml = str_replace("%COMPANY_URL%", $this->config['company_url'], $xml);

        $xml = str_replace("%IMAP_HOST%", $this->config['imap']['host'], $xml);
        $xml = str_replace("%IMAP_PORT%", $this->config['imap']['port'], $xml);
        $xml = str_replace("%IMAP_SOCKET%", $this->config['imap']['socket'], $xml);
        $xml = str_replace("%IMAP_SSL_ON%", (string) $this->isOnOrOff($this->config['imap']['socket'] == "SSL"), $xml);
        $xml = str_replace("%IMAP_SSL_TRUE%", (string) $this->isTrueOrFalse($this->config['imap']['socket'] == "SSL"), $xml);
        $xml = str_replace("%IMAP_DOMAIN_REQUIRED%", (string) $this->isOnOrOff($this->config['domain_required']), $xml);

        $xml = str_replace("%SMTP_HOST%", $this->config['smtp']['host'], $xml);
        $xml = str_replace("%SMTP_PORT%", $this->config['smtp']['port'], $xml);
        $xml = str_replace("%SMTP_SOCKET%", $this->config['smtp']['socket'], $xml);
        $xml = str_replace("%SMTP_SSL_ON%", (string) $this->isOnOrOff($this->config['smtp']['socket'] == "SSL"), $xml);
        $xml = str_replace("%SMTP_SSL_TRUE%", (string) $this->isTrueOrFalse($this->config['smtp']['socket'] == "SSL"), $xml);
        $xml = str_replace("%SMTP_DOMAIN_REQUIRED%", (string) $this->isOnOrOff($this->config['domain_required']), $xml);

        $xml = str_replace("%DOMAIN%", $this->config['domain'], $xml);
        $xml = str_replace("%TTL%", $this->config['ttl'], $xml);
        $xml = str_replace("%EMAIL%", (string) $this->getRequestedEmail(), $xml);
        $xml = str_replace("%UUID1%", (string) $this->generateUUID(), $xml);
        $xml = str_replace("%UUID2%", (string) $this->generateUUID(), $xml);
        $xml = str_replace("%REVERSE_DNS%", (string) $this->reverseDomain($this->config['domain']), $xml);

        return $xml;
    }

    /**
     * Method to sign the template.
     *
     * @param string $template
     * @return string
     */
    protected function signMobileconfig(string $template) : string
    {
        $cert = dirname(__DIR__) . '/' . ltrim($this->config['ssl']['cert'], '/');
        $key = dirname(__DIR__) . '/' . ltrim($this->config['ssl']['key'], '/');
        $ca = dirname(__DIR__) . '/' . ltrim($this->config['ssl']['ca'], '/');

        if (file_exists($cert) && file_exists($key) && file_exists($ca)) {
            return shell_exec('echo "'. addslashes($template) .'" | openssl smime -sign -signer "'. $cert .'" -inkey "'. $key .'" -certfile "'. $ca .'" -outform der -nodetach');
        } else {
            return $template;
        }
    }

    /**
     * Method to make true/false readable as on/off.
     *
     * @param bool $value
     * @return string
     */
    protected function isOnOrOff(bool $value) : string
    {
        return ($value === true) ? 'on' : 'off';
    }

    /**
     * Method to make true/false readable as true/false.
     *
     * @param bool $value
     * @return string
     */
    protected function isTrueOrFalse(bool $value) : string
    {
        return ($value === true) ? 'true' : 'false';
    }

    /**
     * Method to extract email address from url.
     *
     * @return string
     */
    public function extractEmailFromUrl() : string
    {
        $url = $_SERVER['REQUEST_URI'];
        
        preg_match("/[a-z0-9_\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i", $url, $email);

        return isset($email[0]) ? $email[0] : '';
    }

    /**
     * Method to get requested email address.
     *
     * @return string
     */
    public function getRequestedEmail() : string
    {
        $email = ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit']) ? $_POST['email'] : $this->extractEmailFromUrl();

        if (empty($email)) {
            $data = file_get_contents('php://input');
            preg_match("/\<EMailAddress\>(.*?)\<\/EMailAddress\>/", $data, $matches);
            $email = isset($matches[1]) ? $matches[1] : '';
        }

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Method to get mailconfig filename.
     *
     * @return string
     */
    public function getMobileconfigFilename() : string
    {
        $email = $this->getRequestedEmail();
        $email = str_replace(' ', '', $email);
        $email = preg_replace('/[^A-Za-z0-9\-]/', '', $email);

        return $email . '.mobileconfig';
    }

    /**
     * Method to generate a Universally Unique IDentifier (UUID).
     *
     * @return string
     */
    protected function generateUUID() : string
    {
		return rtrim(shell_exec("uuidgen"));
    }

    /**
     * Method to reverse domain name notation.
     *
     * @param string $domain
     * @return string
     */
    protected function reverseDomain(string $domain) : string
    {
        return implode('.', array_reverse(explode('.', $domain)));
    }

}