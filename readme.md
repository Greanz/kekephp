
# KK PHP Framework

It's a simple yet powerful PHP framework for beginners, It helps one quickly begin developing a PHP application without hustle. (clone,add styles and libraries, add classes you're good to go)

This project is a replacement of frameworks such as codeigniter for those who are looking for something small yet lightweight.

## Requirements
PHP version 5.0 or above


## Features
- Simple routing
- Handles Mysql database


## Authors

- [@Greanz](https://www.github.com/Greanz) -  Developer at https://smsdeliveryapi.xyz


## Installation

Install the project with git

```git
  git clone https://github.com/Greanz/kkphpframework.git
```

## Run Locally

To deploy this project, assuming you're using localhost navigate to

```Natigate to
  http://localhost/projectFolder
```

### Database management
The project has a buit-in Database management file in library/mysql.php

To connect to Database create your mysql database use the configuration.json file to configure the database user

Make sure you have enabled database access by changing value of **useMysql** to true

#### Sample query

``$users = mysql::query("SELECT * FROM users");``

``mysql::delete('field','valueOnField','table','limit');``
## Usage/Examples
Use views/.../header.php to include your javascript, css and etc

To add new pages; Each page is controlled by a class, when user navigates to a page where it's class is not present the framework will raise an error ``class was not found`` and ``method was not found`` when a method is missing.

We will create a simple class to demonstrate how the framework works

**Note:** A class name should start with capital letter - **Users not users**
```php
/*
    Simple class to manage users
*/

class Users{

    function index() {
        echo "Am index file in the users route";
        loadView("home",[]); // Show user the view
    }

    function delete($id) {
        $delete = mysql::delete("user_id",$id,"users",1);
        echo (string) $delete;
    }

    function listUsers() {
        $all = mysql::querry("SELECT * FROM users");
        $data = [];
        $data['users',$all]; // Navigating data through classes and views
        loadView("listUsers",$data); // Show user the view
    }
    
}
```

```php
/*
    view for views/front/listUsers
*/

print_r($users);

# users is an extracted variable from class users in the method listUsers array $data
# Press your html here - enjoy

```


## Documentation

```
   How KKPHP Routing Works
```

__Navigating the routes; Assuming that user wants to delete file from the class users the link will look__
```
http://localhost/projectFolder/users/delete/1 

The above link will call a method siting in class Users called delete
```

**Other Examples**
```
http://localhost/projectFolder/users/listUsers - to view all users in the table
```
```
http://localhost/projectFolder/users/ - this calls index method in the class Users
```