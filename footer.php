	<div>
    <!-- /container -->

<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<script>
// JavaScript for deleting
$(document).on('click', '.delete-object', function(){
 
    var id = $(this).attr('delete-id');
    var model = $(this).attr('model');
 
    bootbox.confirm({
        message: "<h4>Are you sure?</h4>",
        buttons: {
            confirm: {
                label: '<span class="glyphicon glyphicon-ok"></span> Yes',
                className: 'btn-danger'
            },
            cancel: {
                label: '<span class="glyphicon glyphicon-remove"></span> No',
                className: 'btn-primary'
            }
        },
        callback: function (result) {
 
            if(result==true){
                $.post('<?php echo $base_url; ?>delete.php', {
                    object_id: id,
                    model: model
                }, function(data){
                    location.reload();
                }).fail(function($msg) {
                    alert('Unable to delete.');
                });
            }
        }
    });
 
    return false;
});
</script>

</body>
</html>