<?php


namespace Framework\Http;


use Psr\Http\Message\UriInterface;

const PORTS = [
    "http" => 80,
    "https" => 443,
    "ftp" => "21"
];

class URI implements UriInterface
{
    private $scheme = null;
    private $userName = null;
    private $userPassword = null;
    private $host = null;
    private $port = null;
    private $path = null;
    private $query = null;
    private $fragment = null;

    public function __construct(
        string $scheme,
        string $host,
        int $port,
        string $path,
        string $query,
        string $fragment = "",
        string $userPassword = "",
        string $userName = ""
    )
    {
        $this->scheme = $scheme;
        $this->userName = $userName;
        $this->userPassword = $userPassword;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    public static function createFromGlobals(): self
    {
        $scheme = $_SERVER["REQUEST_SCHEME"];
        $host = $_SERVER["HTTP_HOST"];
        $port = $_SERVER["SERVER_PORT"];
        $path = explode("?", $_SERVER["REQUEST_URI"])[0];
        $query = $_SERVER["QUERY_STRING"];

        return new self($scheme, $host, $port, $path, $query);
    }
    /**
     * @inheritDoc
     */
    public function getScheme()
    {
        if (!$this->scheme) {
            return "";
        }

        return strtolower($this->scheme);
    }

    /**
     * @inheritDoc
     */
    public function getAuthority()
    {
        if (!$this->getHost()) {
            return "";
        }

        $authority = $this->getHost();

        if ($this->getUserInfo()) {
            $authority = $this->getUserInfo()."@".$authority;
        }

        if ($this->getPort()) {
            $authority .= $this->getPort();
        }

        return $authority;
    }

    /**
     * @inheritDoc
     */
    public function getUserInfo()
    {
        if (!$this->userName) {
            return "";
        }

        $userInfo = "";
        $userInfo .= $this->userName;
        if (!$this->userPassword)  {
            return $userInfo;
        }

        return $userInfo.":".$this->userPassword;
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {
        if (!$this->host) return "";
        return strtolower($this->host);
    }

    /**
     * @inheritDoc
     */
    public function getPort()
    {
        if (!$this->getScheme()) {
            return null;
        }

        if(!$this->port) {
            return null;
        }

        return $this->port;
    }

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        if (!$this->path) {
            return "";
        }
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getQuery()
    {
        if (!$this->query) {
            return "";
        }
        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public function getFragment()
    {
        if (!$this->fragment) {
            return "";
        }
        return $this->fragment;
    }

    /**
     * @inheritDoc
     */
    public function withScheme($scheme)
    {
        $uri = clone $this;
        $uri->scheme = $scheme;
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withUserInfo($user, $password = null)
    {
        $uri = clone $this;
        $uri->userName = $user;
        $uri->userPassword = $password;
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withHost($host)
    {
        $uri = clone $this;
        $uri->host = $host;
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withPort($port)
    {
        $uri = clone $this;
        $uri->port = $port;
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withPath($path)
    {
        $uri = clone $this;
        $uri->path = $path;
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withQuery($query)
    {
        $uri = clone $this;
        $uri->query = $query;
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withFragment($fragment)
    {
        $uri = clone $this;
        $uri->fragment = $fragment;
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $uri = "";
        if (empty($this->getScheme())) $uri .= $this->getScheme().":";
        if (empty($this->getAuthority())) $uri .= "//".$this->getAuthority();
        if (empty($this->getPath()))
            $uri .= ($this->getPath()[0] == '/') ? $this->getPath() : "/".$this->getPath();
        if (empty($this->getQuery())) $uri .= "?".$this->getQuery();
        if (empty($this->getFragment())) $uri .= "#".$this->getFragment();

        return $uri;
    }
}