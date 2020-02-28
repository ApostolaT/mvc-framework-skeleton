<?php


namespace Framework\Http;

const DEFAULT_MEMORY = 1 * 1024 * 1024;
const READ_MODE = "r+";

use Exception;
use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    private $stream = null;
    private $streamSize = null;
    private $isWritable = false;
    private $isReadable = false;
    private $isSeekable = false;

    public function __construct($handler, ?int $size = null)
    {
        $this->stream = $handler;
        $this->streamSize = $size;
        $this->isWritable = $this->isReadable = $this->isSeekable = true;
    }

    public static function createFromString(string $content): self
    {
        $stream = fopen(sprintf("php://temp/maxmemory:%s", DEFAULT_MEMORY), READ_MODE);
        fwrite($stream,$content);
        return new self($stream,strlen($content));
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        if(!isset($this->stream)) {
            return null;
        }

        $this->seek(0);
        return $this->read($this->streamSize);
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        fclose($this->stream);
        $this->detach();
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        if (!isset($this->stream)) {
            return null;
        }

        $result = $this->stream;
        unset($this->stream);

        $this->streamSize = null;
        $this->isReadable = $this->isWritable = $this->isSeekable = false;

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getSize()
    {
        if (!isset($this->stream)) {
            return null;
        }

        return $this->streamSize;
    }

    /**
     * @inheritDoc
     */
    public function tell()
    {
        if (!isset($this->stream)) {
            return null;
        }

        return ftell($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function eof()
    {
        if (!isset($this->stream)) {
            return false;
        }

        return ftell($this->stream) === $this->streamSize;
    }

    /**
     * @inheritDoc
     */
    public function isSeekable()
    {
        return $this->isSeekable;
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        if (!$this->isSeekable) {
            throw new Exception("Stream is not seekable");
        }

        fseek($this->stream, $offset, $whence);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        if (!$this->isSeekable) {
            throw new Exception("Stream is not seekable");
        }

        $this->seek(0);
    }

    /**
     * @inheritDoc
     */
    public function isWritable()
    {
        return $this->isWritable;
    }

    /**
     * @inheritDoc
     */
    public function write($string)
    {
        if (!$this->isWritable()) {
            throw new Exception("Trying to write into a non writable stream");
        }

        $x = fwrite($this->stream, $string);
        $this->streamSize += $x;
    }

    /**
     * @inheritDoc
     */
    public function isReadable()
    {
        return $this->isReadable;
    }

    /**
     * @inheritDoc
     */
    public function read($length)
    {
        if (!$this->isReadable()) {
            return false;
        }

        return fread($this->stream, $length);
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        if (!isset($this->stream)) {
            throw new Exception("in get Contents there is not set a stream");
        }

        return stream_get_contents($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        if (!isset($this->stream)) {
            throw new Exception("in getMetadata there is not set a stream");
        }

        $this->getMetadata();
    }
}