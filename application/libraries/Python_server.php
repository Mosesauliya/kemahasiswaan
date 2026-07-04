<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Python_server {
    
    private $python_script_path;
    private $python_exe;
    private $server_url = 'http://localhost:5000';
    private $log_file;
    
    public function __construct() {
        // Path ke ai_engine.py
        $this->python_script_path = FCPATH . 'ai_engine.py';
        
        // Log file
        $log_dir = defined('APPPATH') ? APPPATH . 'logs/' : __DIR__ . '/../../logs/';
        if (!is_dir($log_dir)) {
            @mkdir($log_dir, 0777, true);
        }
        $this->log_file = $log_dir . 'python_server.log';
        
        // Detect Python executable untuk Windows
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Test apakah python command tersedia
            $test = @shell_exec("python --version 2>&1");
            if ($test && stripos($test, 'python') !== false) {
                $this->python_exe = 'python';
            } else {
                // Fallback ke path absolut
                $this->python_exe = 'C:\Users\monar\AppData\Local\Programs\Python\Python313\python.exe';
            }
        } else {
            $this->python_exe = 'python3';
        }
        
        $this->_log("Python_server initialized");
        $this->_log("Script: {$this->python_script_path}");
        $this->_log("Python: {$this->python_exe}");
    }
    
    /**
     * Simple logging
     */
    private function _log($message) {
        $timestamp = date('Y-m-d H:i:s');
        $log = "[{$timestamp}] {$message}\n";
        @file_put_contents($this->log_file, $log, FILE_APPEND);
        
        // Also log to CI if available
        if (function_exists('log_message')) {
            log_message('info', "Python: {$message}");
        }
    }
    
    /**
     * Check if server is running
     */
    public function is_running() {
        $ch = curl_init($this->server_url . '/health');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        
        $response = @curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return ($http_code == 200);
    }
    
    /**
     * Start Python server
     */
    public function start() {
        $this->_log("=== START ATTEMPT ===");
        
        // Already running?
        if ($this->is_running()) {
            $this->_log("Already running");
            return true;
        }
        
        // File exists?
        if (!file_exists($this->python_script_path)) {
            $this->_log("ERROR: Script not found: {$this->python_script_path}");
            return false;
        }
        
        $this->_log("Starting server...");
        
        // Windows command
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $script = str_replace('/', '\\', $this->python_script_path);
            
            // Method 1: PowerShell (most reliable)
            $ps_cmd = "Start-Process -FilePath '{$this->python_exe}' -ArgumentList '{$script}' -WindowStyle Hidden";
            $command = "powershell -Command \"{$ps_cmd}\"";
            
            $this->_log("Executing: {$command}");
            
            // Execute with output capture
            $output = [];
            $return = 0;
            exec($command . " 2>&1", $output, $return);
            
            $this->_log("Return code: {$return}");
            if (!empty($output)) {
                $this->_log("Output: " . implode(" | ", $output));
            }
            
            // Fallback method if PowerShell fails
            if ($return !== 0) {
                $this->_log("PowerShell failed, trying START command");
                $cmd2 = "start /B \"Python AI\" \"{$this->python_exe}\" \"{$script}\"";
                $this->_log("Executing: {$cmd2}");
                @pclose(@popen($cmd2, 'r'));
            }
        } else {
            // Linux/Mac
            $command = "nohup {$this->python_exe} '{$this->python_script_path}' > /dev/null 2>&1 &";
            $this->_log("Executing: {$command}");
            @shell_exec($command);
        }
        
        // Wait for startup
        $this->_log("Waiting 5 seconds for startup...");
        sleep(5);
        
        // Verify with retries
        $attempts = 3;
        for ($i = 1; $i <= $attempts; $i++) {
            $this->_log("Verification attempt {$i}/{$attempts}");
            if ($this->is_running()) {
                $this->_log("SUCCESS: Server started!");
                return true;
            }
            if ($i < $attempts) {
                sleep(2);
            }
        }
        
        $this->_log("FAILED: Server did not start");
        return false;
    }
    
    /**
     * Stop server
     */
    public function stop() {
        $this->_log("=== STOP ATTEMPT ===");
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Kill by port
            $cmd = 'for /f "tokens=5" %a in (\'netstat -aon ^| find ":5000" ^| find "LISTENING"\') do taskkill /F /PID %a';
            @exec($cmd);
        } else {
            @exec("pkill -f ai_engine.py");
        }
        
        $this->_log("Stop command executed");
        return true;
    }
    
    /**
     * Restart server
     */
    public function restart() {
        $this->stop();
        sleep(2);
        return $this->start();
    }
    
    /**
     * Ensure running - auto start if needed
     */
    public function ensure_running() {
        if (!$this->is_running()) {
            $this->_log("Not running, auto-starting...");
            return $this->start();
        }
        return true;
    }
    
    /**
     * Get status
     */
    public function get_status() {
        $running = $this->is_running();
        
        return [
            'running' => $running,
            'url' => $this->server_url,
            'script' => $this->python_script_path,
            'python_exe' => $this->python_exe,
            'status_text' => $running ? 'Online' : 'Offline',
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
}