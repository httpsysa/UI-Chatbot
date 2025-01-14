<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>CHATBOT - iTech</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    <h1>CHATBOT - iTech</h1>
    <p class="action"><a href="addform.php" class="btn btn-primary">Add New Data</a>
    <a href="index.php" class="btn btn-primary">Chat Now</a>
    <a href="view.php" class="btn btn-primary">View</a></p>
    <div class="wrapper">
        <div class="title"><i class="fa fa-users"></i> Simple Online Chatbot</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Hello there, How can I help you?</p>
                </div>
            </div>
        </div>
        <div class="typing-field">
            <div class="input-data">
                <input id="data" type="text" placeholder="Type something here.." required>
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            if (document.layers) {
                document.captureEvents(Event.KEYDOWN);
                }

                document.onkeydown = function (evt) {
                var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
                if (keyCode == 13) {
                    var input = $("#data").val();
                    if (input == '') {
                        $("#data").val('');
                        $("#data").focus();
                    } else {
                        $value = $("#data").val();
                        $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                        $(".form").append($msg);
                        $("#data").val('');
                        
                        // start ajax code
                        $.ajax({
                            url: 'message.php',
                            type: 'POST',
                            data: 'text='+$value,
                            success: function(result){
                                $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                                $(".form").append($replay);
                                // when chat goes down the scroll bar automatically comes to the bottom
                                $(".form").scrollTop($(".form")[0].scrollHeight);
                            }
                        });
                    }
                }
            };
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                
                $.ajax({
                    url: 'message.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $reply = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($reply);
                     
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>
    <footer>Chatbot iTech. 2024 All rights reserved.</footer>
</body>
</html>