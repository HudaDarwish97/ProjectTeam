var comments = [];
$(document).ready(function(){
    $( document ).ready(function() {
      $.get("fetch_comments.php", function(data, status){
        var text = "";

        for(i=0;i<data.length;i++){
            var comment = data[i];
            text+="<li> "+comment.user_name+' - '+comment.comment_text+" </li>";
        }
$("#comments_list").html(text);
       //alert("Data: " + text + "\nStatus: " + status);
      });
    });
  });

  $("#set_comment").submit(function() {
    var comment_text= $("#comment_text").val();

    $.ajax({
        type: "POST",
        url: "save_comment.php",
        data: "comment_text=" + comment_text,
        success: function(data) {
           alert("sucess");
        }

    });


});