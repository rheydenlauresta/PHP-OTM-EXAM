<?php
// check if value was posted
if($_POST){
 
    // include database and object file
    include_once 'config/database.php';
    include_once 'model/news.php';
    include_once 'model/comments.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // prepare model object
    $model = new $_POST['model']($db);

    // set model id to be deleted
    $model->id = $_POST['object_id'];
     
    // delete the model
    if($model->delete()){
        echo "Object was deleted.";
    }
     
    // if unable to delete the model
    else{
        echo "Unable to delete object.";
    }
}
