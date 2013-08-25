<?php
/**
 * Defines the interface that must be implemented for a db session handling
 * class
 */
interface SessionDBInterface {
     
  /**
    * Read the data corresponding to the $sessionId from the session database
    * 
    * @param type $sessionId Id of the session to which data must be read
    * @return string|boolean
    */
   public function readSessionData($sessionId);

   /**
    * Writes the given session data to the session database.
    * 
    * @param type $sessionId
    * @param type $sessionData
    * @return boolean
    */
   public function writeSessionData($sessionId, $sessionData);

   /**
    * Deletes the session data for the given sessionId from the database.
    * 
    * @param type $sessionId
    * @return boolean
    */
   public function deleteSessionData($sessionId);

   /**
    * Check if a session for the current $sessionId exists.
    * 
    * @param type $sessionId
    * @return boolean
    */
   public function checkSession($sessionId);
}
?>