<?php

namespace Core;

class Logger
{
    protected static array $options = [
        'logFormat' => 'H:i:s d.m.Y'
    ];

    public string $logFile = TMP . "/error.log";

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
        $this->createLogFile();
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

        if (!empty($backtrace)) {
            $backtrace = array_shift($backtrace);
            $btLineLog = $this->variableNotAvailable($backtrace['line']);
            $btPathLog = $this->variableNotAvailable($backtrace['file']);
        } else {
            $btLineLog = 'N/A';
            $btPathLog = 'N/A';
        }

        $contextLog = json_encode($context);

        $this->message = sprintf(
            "[%s] | %s . %s : %s | [%s : %s] | %s",
            $time,
            $errorType,
            $this->logLevel,
            $message,
            $btPathLog,
            $btLineLog,
            $contextLog
        );

        $this->writeLog();
    }

    public function variableNotAvailable($variable): string
    {
        return empty($variable) ? 'N/A' : $variable;
    }

    public static function mistake(array $context = [], $message = '')
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $new = new Logger('static');
        $new->setMessage('NOTICE', $message, $backtrace, $context);
    }

    public function debug($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('DEBUG', $message, $backtrace, $context);
    }

    public function notice($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('NOTICE', $message, $backtrace, $context,);
    }

    public function info($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('INFO', $message, $backtrace, $context,);
    }

    public function warning($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('WARNING', $message, $backtrace, $context,);
    }

    public function error($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('ERROR', $message, $backtrace, $context,);
    }

    public function fatal($message, array $context = [])
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $this->setMessage('FATAL', $message, $backtrace, $context,);
    }
}

