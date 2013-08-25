Session-Handler
===============

Session Handling using Database

This is very usefull if you need to implement the session handling with database. Just implement the 
sessionHandler interface and provide the functions for your specific database. Here i have provided the MysqlHander
class which implements the handling using mysql. You can implement this for any database, you just have to pass the
Handler to the SessionHandler. See the __test__ for how it is used.
