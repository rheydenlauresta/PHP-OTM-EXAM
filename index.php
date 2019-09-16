<?php
	include_once 'config/database.php';
	include_once 'model/news.php';
	include_once 'model/comments.php';

	// get database connection
	$database = new Database();
	$db = $database->getConnection();
	 
	// pass connection to objects
	$news = new News($db);
	$comments = new Comments($db);

	// set page headers
    $page_title = "News List";
	$base_url = "";
	include_once "header.php";

    // page given in URL parameter, default page is one
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
     
    // set number of records per page
    $records_per_page = 5;
     
    // calculate for the query LIMIT clause
    $from_record_num = ($records_per_page * $page) - $records_per_page;

    // query news
    $stmt = $news->readAll($from_record_num, $records_per_page);
    $record_count = $stmt->rowCount();
?>

<div class='right-button-margin'>
    <a href='resources/news/create-news.php' class='btn btn-default pull-right'>Create News</a>
</div>

<?php 
    // tell the user there are no news
    if($record_count == 0){
        echo "<div class='alert alert-info'>No News found.</div>";
    }else{
?>

<!-- display the news if there are any -->
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Created</th>
        <th>Actions</th>
    </tr>
    <?php
        
        if($record_count>0){
     
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
     
                extract($row);
     
                echo "<tr>";
                    echo "<td>{$title}</td>";
                    echo "<td>{$content}</td>";
                    echo "<td>{$created_at}</td>";
                    echo "<td>";
                        // read and delete buttons
                        echo "<a href='resources/comments/comment-list.php?id={$id}' class='btn btn-primary left-margin'>
                            <span class='glyphicon glyphicon-comment'></span> 
                        </a>
                         
                        <a delete-id='{$id}' model='News' class='btn btn-danger delete-object'>
                            <span class='glyphicon glyphicon-remove'></span> 
                        </a>";
                    echo "</td>";
     
                echo "</tr>";
            }
        }
    ?>
</table>

<?php
        $page_url = "index.php?";
        // count all products in the database to calculate total pages
        $total_rows = $news->countAll();

        // paging buttons here
        include_once 'pagination.php';
    }
	// footer
	include_once "footer.php";
?>