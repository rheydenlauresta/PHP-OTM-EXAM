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
	$page_title = "Create Comment";
    $base_url = "../../";
	include_once "../../header.php";
?>
 
<div class='right-button-margin'>
    <a href='comment-list.php?id=<?php echo $_GET["id"]?>' class='btn btn-default pull-right'>Comment List</a>
</div>

<?php 
if($_POST){
    // set comments property values
    $comments->news_id = $_POST['news_id'];
    $comments->content = $_POST['content'];
 
    // create the comments
    if($comments->create()){
        echo "<div class='alert alert-success'>Comment was created.</div>";
    }
 
    // if unable to create the comments, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create comments.</div>";
    }
}
?>

<!-- HTML form for creating a comments -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$_GET['id'];?>" method="post">
 
    <input type='hidden' name='news_id' value="<?php echo $_GET['id']; ?>"/>
    <table class='table table-hover table-responsive table-bordered'>

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