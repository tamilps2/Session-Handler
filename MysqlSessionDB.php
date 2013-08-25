<?php
/**
 * MySql specific Session DB class.
 * Implements the SessionDBInterface.
 */
class MysqlSessionDB implements SessionDBInterface {
  
  /**
   * The database connection holder
   */
  private $dbConnection;
  
  /**
   * Stores the database connection.
   * 
   * @param type $mysqlConnection
   */
  public function __construct($mysqlConnection) {
    $this->dbConnection = $mysqlConnection;
  }
  
  /**
   * Read the data corresponding to the $sessionId from the session database
   * 
   * @param type $sessionId Id of the session to which data must be read
   * @return string|boolean
   */
  public function readSessionData($sessionId) {
    $sessionDataQuery = "SELECT `data` 
                         FROM `hbsession` 
                         WHERE `id` = ?";
    $sessionData = $this->dbConnection->prepare(
                                $sessionDataQuery);
    if ($sessionData !== false) {
      $sessionData->bind_param('s', $sessionId);
      if ($sessionData->execute() !== false) {
        $data = '';
        $sessionData->bind_result($data);
        $sessionData->fetch();
        return $data;
      }
      $sessionData->close();
    } else {
      if (HB_SessionHandler::SHOW_ERROR) {
        echo $sessionData->error;
      }
      return false;
    }
  }

   /**
    * Writes the given session data to the session database.
    * 
    * @param type $sessionId
    * @param type $sessionData
    * @return boolean
    */
  public function writeSessionData($sessionId, $sessionData) {
    $storeDataQuery = "REPLACE INTO 
                       `hbsession` (`id`, `data`, `last_access`)
                       VALUES(?, ?, ?)";
    $storeData = $this->dbConnection->prepare($storeDataQuery);

    if ($storeData !== false) {
      $storeData->bind_param('sss', $sessionId, $sessionData, 
                            $this->accessTime);
      if ($storeData->execute() !== false) {
        if ($storeData->affected_rows > 0) {
          return true;
        }
      } else {
        if (HB_SessionHandler::SHOW_ERROR) {
          echo $storeData->error;
        }
      }
      $storeData->close();
    } else {
      if (HB_SessionHandler::SHOW_ERROR) {
        echo $storeData->error;
      }
    }
  }

   /**
    * Deletes the session data for the given sessionId from the database.
    * 
    * @param type $sessionId
    * @return boolean
    */
  public function deleteSessionData($sessionId) {
    $deleteSessionQuery = "DELETE 
                           FROM `hbsession` 
                           WHERE `id` = ?";
    $deleteSession = $this->dbConnection->prepare($deleteSessionQuery);

    if ($deleteSession !== false) {
      $deleteSession->bind_param('s', $sessionId);
      if ($deleteSession->execute() !== false) {
        return true;
      }
      $deleteSession->close();
    } else {
      if (HB_SessionHandler::SHOW_ERROR) {
        echo $deleteSession->error;
      }
    }
  }

   /**
    * Check if a session for the current $sessionId exists.
    * 
    * @param type $sessionId
    * @return boolean
    */
  public function checkSession($sessionId) {
    $sessionCheckQuery = "SELECT `id`
                        FROM `hbsession`
                        WHERE `id` = ? 
                        LIMIT 1";
    $sessionCheck = $this->dbConnection->prepare(
                                $sessionCheckQuery);
    if ($sessionCheck !== false) {
      $sessionCheck->bind_param('s', $sessionId);
      $sessionCheck->execute();
      // If greater than 0, session exists
      if ($sessionCheck->affected_rows > 0) {
        return true;
      } else {
        return false;
      }
      $sessionCheck->close();
    } else {
      if (HB_SessionHandler::SHOW_ERROR) {
        echo $sessionCheck->error;
      }
      return false;
    }
  }
  
  /**
   * Closes the dbConnection
   */
  public function close() {
    $this->dbConnection->close();
  }
}
?>