<?php
	include_once '../../config/database.php';
	include_once '../../model/news.php';
	include_once '../../model/comments.php';

    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

	// get database connection
	$database = new Database();
	$db = $database->getConnection();
	 
	// pass connection to objects
	$news = new News($db);
	$comments = new Comments($db);

	// set page headers
	$page_title = "Comment List";
    $base_url = "../../";
	include_once "../../header.php";

    // page given in URL parameter, default page is one
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
     
    // set number of records per page
    $records_per_page = 5;
     
    // calculate for the query LIMIT clause
    $from_record_num = ($records_per_page * $page) - $records_per_page;

    // query comments
    $stmt = $comments->readAll($from_record_num, $records_per_page);
    $record_count = $stmt->rowCount();
?>

<div class='right-button-margin'>
    <a href='../../index.php' class='btn btn-default pull-right'>News List</a>
    <a href='create-comment.php?id=<?php echo $id; ?>' class='btn btn-default pull-right'>Create Comment</a>
</div>

<?php 
    // tell the user there are no Comments
    if($record_count == 0){
        echo "<div class='alert alert-info'>No Comments found.</div>";
    }else{
?>

<!-- display the comments if there are any -->
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <th>Content</th>
        <th>Created</th>
        <th>Actions</th>
    </tr>
    <?php
        
        if($record_count>0){
     
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
     
                extract($row);
     
                echo "<tr>";
                    echo "<td>{$content}</td>";
                    echo "<td>{$created_at}</td>";
                    echo "<td>";
                        // delete button
                        echo "<a delete-id='{$id}' model='Comments' class='btn btn-danger delete-object'>
                            <span class='glyphicon glyphicon-remove'></span> 
                        </a>";
                    echo "</td>";
     
                echo "</tr>";
            }
        }
    ?>
</table>

<?php
        $page_url = "resources/comments/comment-list.php?";
        // count all products in the database to calculate total pages
        $total_rows = $comments->countAll();
        // paging buttons here
        include_once '../../pagination.php';
    }
	// footer
	include_once "../../footer.php";
?>