<?php
include (__dir__ . '/MysqlSessionDB.php');
/**
 * This class implements the session storage mechanism.
 * @implement SessionHandlerInterface
 */
class SessionHandler implements SessionHandlerInterface {
        
    /**
     * The accessTime of the session
     */
    public $accessTime;
    
    /**
     * Holds the instance that handles the sessiondb functionality.
     */
    private $sessiondb;
    
    /**
     * Errors are displayed when this is set to true.
     */
    const SHOW_ERROR = true;
    
    /**
     * Assings the database Connection.
     * Start the session.
     * 
     */
    public function __construct($sessiondb) {
      $this->sessiondb = $sessiondb;
      $this->accessTime = time();
    }
    
    /**
     * Executed when the session is started automatically, or
     * manually with session_start();
     * 
     * @param type $savePath
     * @param type $sessionId
     * @return boolean
     */
    public function open($savePath, $sessionName) {
      $savePath = '';
      $sessionName = '';
      return true;
    }
	
    /**
     * Reads the session data if one exists for the given sessionId,
     * else returns a empty data.
     * 
     * @param type $sessionId - The session id to read.
     * @return string
     */
    public function read($sessionId) {
      $data = $this->sessiondb->readSessionData($sessionId);
      if ($data !== false) {
        return $data;
      }
      return '';
    }
	
    /**
     * Used to save the session and close.
     * close() is called after this function executes.
     * 
     * @param type $sessionId Id of the current session
     * @param type $sessionData serialized session data
     * @return boolean
     */
    public function write($sessionId, $sessionData) {
      $this->sessiondb->writeSessionData($sessionId, $sessionData);
    }
	
    /**
     * The garbage collector callback is invoked internally by PHP periodically
     * in order to purge old session data. The frequency is controlled by 
     * session.gc_probability and session.gc_divisor. The value of lifetime 
     * which is passed to this callback can be set in session.gc_maxlifetime. 
     * Return value should be TRUE for success, FALSE
     * 
     * @param string $maxLifeTime
     * @return boolean
     */
    public function gc($maxLifeTime) {
      $maxLifeTime = '';
      return true;
    }
	
    /**
     * Closes the session.
     * Called after the write method is called.
     * @return boolean
     */
    public function close() {
      $this->sessiondb->close();
      return true;
    }
	
    /**
     * Removes all the data corresponding to the $sessionId.
     * 
     * @param type $sessionId
     * @return boolean
     */
    public function destroy($sessionId) {
      if ($this->sessiondb->deleteSessionData($sessionId) !== false) {
        return true;
      }
      return false;
    }
}
?>