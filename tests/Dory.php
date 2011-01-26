<?php    

require_once("pork/class.dbobject.php");
require_once("pork/class.dbconnection.php");
require_once("pork/class.settings.php");

class Category extends dbObject
{
    function __construct($ID=false)
    {
        $this->__setupDatabase('Category', 
        array('idCategory' => 'ID',    
            'strName' => 'Name'),
            'idCategory',    // primary table key 
            $ID);   
        $this->addRelation('Posts', 'Category_has_Posts'); 
    }
}

class Comments extends dbObject
{
    function __construct($ID=false)
    {
        $this->__setupDatabase('Comments', // database table
        array('idComments' => 'ID',    
            'strName' => 'Poster',	// Poster Name
            'strEMail' => 'PosterEmail',// Poster Emai ID
            'strComment' => 'Comment',	// Actual comment
            'idPosts' => 'PostId'),// Post ID for which this comment
            'idComments', // primary table key 
            $ID);    // value of primary key to init with (can be false for new empty object / row)
        $this->addRelation('Posts'); // define a many:many relation to Post through Reaction
    }
}


class Posts extends dbObject
{
    function __construct($ID=false)
    {
        $this->__setupDatabase('Posts', // database table
        array('idPosts' => 'ID',    
            'ID_User' => 'Author',	
            'strFile' => 'File',
            'datTimeCreated' => 'Created',
            'idUserRole' => 'UserRole',
            'datTimeModified' => 'Modified',
            'isPublished' => 'isPublished',
            'iViews' => 'ViewCount',
            'strTitle' => 'Title'),
            'idPosts', // primary table key 
            $ID);    // value of primary key to init with (can be false for new empty object / row)
        $this->addRelation('Category', 'Category_has_Posts'); 
        $this->addRelation('Comments');
        $this->addRelation('Users');
        $this->addRelation('UserRole'); 
    }
}


class Category_has_Posts extends dbObject
{
    function __construct($ID=false)
    {
        $this->__setupDatabase('Category_has_Posts', // database table
        array('Id' => 'ID',    // database field => mapped object property
            'idCategory' => 'CategoryId',
            'idPosts' => 'PostId'),
            'Id', // primary table key 
            $ID);    // value of primary key to init with (can be false for new empty object / row)
        $this->addRelation('Posts');// define a 1:1 relation to Blog
        $this->addRelation('Category'); // define a 1:1 relation to Tags
    }
} 

/* END OF CONTENT LAYER OBJECT DEF */

class Users extends dbObject
{
    function __construct($ID=false)
    {
        $this->__setupDatabase('Users', // database table
        array('ID_User' => 'ID',    
            'email' => 'Email',	
            'idUserRole' => 'UserRole',
            'strUsername' => 'Username',	
            'strPassword' => 'Password'),	
            'ID_User', // Primary Again
            $ID);    
        $this->addRelation('UserRole'); 
        $this->addRelation('Posts');
        $this->addRelation('UserURLs'); 
    }
}

class UserRole extends dbObject
{
    function __construct($ID=false)
    {
        $this->__setupDatabase('UserRole', // database table
        array('idUserRole' => 'ID',    
            'Role' => 'Role'),
            'idUserRole', // Primary Again
            $ID);    
        $this->addRelation('Users'); 
        $this->addRelation('Posts');
    }
}

class UserURLs extends dbObject
{
    function __construct($ID=false)
    {
        $this->__setupDatabase('UserURLs', // database table
        array('idUserURLs' => 'ID',  
            'strUrl' => 'URL',	  
            'ID_User' => 'User'),
            'idUserURLs', // Primary Again
            $ID);    
        $this->addRelation('Users'); 
    }
}

?>
