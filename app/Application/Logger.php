<?php

namespace App\Application;

class Logger
{
    protected static array $options = [
        'logFormat' => 'H:i:s d.m.Y'
    ];

    public string $logFile = ROOT . "/tmp/error.log";

    public string $logLevel;

    public $file; // resource

    public string $message;

    public function __construct($logLevel = 'prefix')
    {
        $this->logLevel = $logLevel;
        $this->createLogFile();
    }

    public function setLogFile($logFile)
    {
        $this->logFile = $logFile;
    }

    public function getLogFile($logFile)
    {
        return $this->logFile;
    }


    public function createLogFile(): void
    {
        if (!file_exists(ROOT . '/tmp')) {
            mkdir(ROOT . '/tmp', 0777, true);
        }

        if (!file_exists($this->logFile)) {
            try {
                fopen($this->logFile, 'w');
            } catch (\Exception $e) {
                throw new \Exception("Не могу создать {$this->logFile}");
            }
        }
    }

    public function writeLog()
    {
        if (!is_resource($this->file)) {
            $this->openLogFile();
        }

        fwrite($this->file, $this->getMessage() . PHP_EOL);

        $this->closeLogFile();
    }

    public function closeLogFile()
    {
        if ($this->file) {
            fclose($this->file);
        }
    }

    private function openLogFile(): void
    {
        $openFile = $this->logFile;
        try {
            $this->file = fopen($openFile, 'a');
        } catch (\Exception $e) {
            throw new \Exception("Не могу открыть {$openFile}");
        }
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $errorType, string $message, array $backtrace, array $context = [])
    {
        $time = date(self::$options['logFormat']);

        $backtrace = array_shift($backtrace);
        $btLine = $backtrace['line'];
        $btLineLog = is_null($btLine) ? 'N/A' : $btLine;

        $btPath = $backtrace['file'];
        $btPathLog = is_null($btPath) ? 'N/A' : $btPath;

        $context = json_encode($context);
        $contextLog = empty($args['context']) ? '' : "{$context}";

        $this->message = sprintf(
            "[%s] | %s . %s : %s | [%s : %s] | [%s]",
            $time,
            $errorType,
            $this->logLevel,
            $message,
            $btPathLog,
            $btLineLog,
            $contextLog
        );
    }

    public function debug($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('DEBUG', $message, $backtrace, $context);
        $this->writeLog();
    }

    public function notice($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('NOTICE', $message, $backtrace, $context,);
        $this->writeLog();
    }

    public function info($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('INFO', $message, $backtrace, $context,);
        $this->writeLog();
    }

    public function warning($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('WARNING', $message, $backtrace, $context,);
        $this->writeLog();
    }

    public function error($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('ERROR', $message, $backtrace, $context,);
        $this->writeLog();
    }

    public function fatal($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('FATAL', $message, $backtrace, $context,);
        $this->writeLog();
    }

    //-------------------------------------------------
    //Абсолютный путь в относительный URL ?
    public function absToRelPath($pathToConvert)
    {
        $pathAbs = str_replace(['/', '\\'], '/', $pathToConvert);
        $documentRoot = str_replace(['/', '\\'], '/', $_SERVER['DOCUMENT_ROOT']);
        return $_SERVER['SERVER_NAME'] . str_replace($documentRoot, '', $pathAbs);
    }
}

