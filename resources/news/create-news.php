<?php
	include_once '../../config/database.php';
	include_once '../../model/news.php';
	include_once '../../model/comments.php';

	// get database connection
	$database = new Database();
	$db = $database->getConnection();
	 
	// pass connection to objects
	$news = new News($db);
	$comments = new Comments($db);

	// set page headers
	$page_title = "Create News";
    $base_url = "../../";
	include_once "../../header.php";
?>
 
<div class='right-button-margin'>
    <a href='../../index.php' class='btn btn-default pull-right'>News List</a>
</div>

<?php 
if($_POST){
    // set news property values
    $news->title = $_POST['title'];
    $news->content = $_POST['content'];
 
    // create the news
    if($news->create()){
        echo "<div class='alert alert-success'>News was created.</div>";
    }
 
    // if unable to create the news, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create news.</div>";
    }
}
?>

<!-- HTML form for creating a news -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' class='form-control' required="required" /></td>
        </tr>
 
        <tr>
            <td>Content</td>
            <td><textarea name='content' class='form-control no-resize' rows="20" required="required" ></textarea></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary pull-right">Create</button>
            </td>
        </tr>
 
    </table>
</form>
 
<?php
	// footer
	include_once "../../footer.php";
?>