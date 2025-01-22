<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QueriesDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = $_POST['query'];

    // Sanitize input to prevent SQL injection
    $userInput = $conn->real_escape_string($userInput);

    // Query the database for a matching reply
    $sql = "SELECT Reply FROM faq WHERE Query = '$userInput'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['Reply'];
    } else {
        echo "I’m a so sorry, I do not recognize your message and I am unable to respond to that. For further assistance, please send an email to support@airbnb.com. Thank you";
    }

    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Villa Chatbot</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* General styling */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        /* Chatbox container */
        .chatbox {
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
            background-color: #ffffff;
        }

        /* Header styling */
        .chatbox-header {
            background-color: #ff0000;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-weight: bold;
        }

        /* Chat messages area */
        .chatbox-messages {
            padding: 10px;
            background-color: #ffffff;
            height: 400px;
            overflow-y: auto;
        }

        .chatbox-message {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .chatbox-message.user {
            justify-content: flex-end;
        }

        .chatbox-avatar {
            width: 30px;
            height: 30px;
            background-color: #ff0000;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chatbox-bubble {
            padding: 10px 15px;
            border-radius: 15px;
            max-width: 70%;
            font-size: 14px;
            word-wrap: break-word;
        }

        .chatbox-bubble.bot {
            background-color: #ffcccc;
            color: #000;
        }

        .chatbox-bubble.user {
            background-color: #e6e6e6;
            color: #000;
        }

        /* Input area */
        .chatbox-input {
            display: flex;
            border-top: 1px solid #ddd;
        }

        .chatbox-input input {
            flex: 1;
            padding: 10px;
            border: none;
            outline: none;
            font-size: 14px;
        }

        .chatbox-input button {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .chatbox-input button:hover {
            background-color: #cc0000;
        }

        /* Responsive design */
        @media screen and (max-width: 600px) {
            .chatbox {
                width: 90%;
            }

            .chatbox-messages {
                height: 300px;
            }
        }

        /* Footer */
        footer {
            background: rgb(238,174,174);
            background: -moz-radial-gradient(circle, rgba(238,174,174,1) 0%, rgba(255,255,255,1) 100%);
            background: -webkit-radial-gradient(circle, rgba(238,174,174,1) 0%, rgba(255,255,255,1) 100%);
            background: radial-gradient(circle, rgba(238,174,174,1) 0%, rgba(255,255,255,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#eeaeae",endColorstr="#ffffff",GradientType=1);
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: static;
            bottom: 0;
        }

        .header-area {
            position: sticky;
            top: 0;
            background: rgb(238,174,174);
            background: -moz-radial-gradient(circle, rgba(238,174,174,1) 0%, rgba(255,255,255,1) 100%);
            background: -webkit-radial-gradient(circle, rgba(238,174,174,1) 0%, rgba(255,255,255,1) 100%);
            background: radial-gradient(circle, rgba(238,174,174,1) 0%, rgba(255,255,255,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#eeaeae",endColorstr="#ffffff",GradientType=1);
            z-index: 1000;
            width: 100%;
            border-bottom: 1px solid #f0f0f0;
            padding: 10px 0;
        }

        .main-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #cc0000;
            
        }

        .nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .nav li {
            margin: 0 10px;
        }

        .nav li a {
            text-decoration: none;
            font-size: 16px;
            color: black;
            padding: 8px 16px;
            transition: color 0.3s ease;
        }

        .nav li a.active {
            color: #cc0000;
        }

        .nav li a:hover {
            color: #671414;
        }

        .nav li:last-child a {
            background-color: #cc0000 ;
            color: white;
            border-radius: 20px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav li:last-child a i {
            margin-right: 8px;
        }

        .menu-trigger {
            display: none;
        }

        @media (max-width: 768px) {
            .main-nav {
                flex-direction: column;
                align-items: flex-start;
            }

            .menu-trigger {
                display: block;
                margin-bottom: 10px;
            }

            .nav {
                flex-direction: column;
                width: 100%;
            }

            .nav li {
                width: 100%;
                text-align: left;
            }

            .nav li:last-child a {
                width: auto;
            }
        }


        .btn-primary {
            color:rgb(136, 96, 96);
            background-color:white;
        }

        .btn-primary:hover {
            background-color: #eea5a5;
            border-color: hsl(0, 72%, 80%);
        }

    </style>
</head>

<body>

    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <a href="index.html" class="logo">
                            <h1>Villa</h1>
                        </a>
                        <ul class="nav">
                            <li><a href="index.html" class="active"><strong>Home</strong></a></li>
                            <li><a href="properties.html">Properties</a></li>
                            <li><a href="property-details.html">Details</a></li>
                            <li><a href="chatbot.php"><i class="fa fa-comments"></i> Chat With Us</a></li>
                        </ul>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <h1>Welcome to Villa Chatbot</h1>
    <p><i class="fa fa-users"></i> Ask General Questions Here!</p>

    <div class="chatbox">
        <div class="chatbox-header">Villa Chatbot</div>
        <div class="chatbox-messages">
            <div class="chatbox-message bot">
                <div class="chatbox-avatar"></div>
                <div class="chatbox-bubble bot">Hi, Welcome to Villa Chat!</div>
            </div>
        </div>
        <div class="chatbox-input">
            <input id="data" type="text" placeholder="Type something here..." required>
            <button id="send-btn">Send</button>
        </div>
    </div>


    <p><a href="admin.php" class="btn btn-primary">Click here to login as Admin!</a></p>


    <footer>Villa Chatbot. 2025 All rights reserved.</footer>

    <script>
        $(document).ready(function () {
            function scrollToBottom() {
                const chatMessages = $('.chatbox-messages')[0];
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            $('#data').on('keydown', function (e) {
                if (e.key === 'Enter') {
                    $('#send-btn').click();
                }
            });

            $('#send-btn').on('click', function () {
                const input = $('#data').val().trim();
                if (input === '') return;

                const userMessage = `<div class="chatbox-message user">
                <div class="chatbox-bubble user">${input}</div>
            </div>`;
                $('.chatbox-messages').append(userMessage);
                $('#data').val('');

                $.ajax({
                    url: 'chatbot.php',
                    type: 'POST',
                    data: { query: input },
                    success: function (response) {
                        const botReply = `<div class="chatbox-message bot">
                <div class="chatbox-avatar"></div>
                <div class="chatbox-bubble bot">${response}</div>
            </div>`;
                        $('.chatbox-messages').append(botReply);
                        scrollToBottom();
                    }
                });
            });
        });
    </script>

</body>
</html>