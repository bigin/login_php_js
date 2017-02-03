<?php
session_start();
include('config.php');
include('connect.php');
include('checkuser.php');
$ret = 0;
if(isset($_POST['name']) && !empty($_POST['name']))
    $ret = checkUser($db);
if(isset($_GET['logout']))
    logout();
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title>Login Form</title>
        <style type="text/css">
        body{text-align:center;font-family:"Helvetica Neue",Helvetica,FreeSans,Arial,Verdana,sans-serif;font-size:100%;
            -webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;color:#555;}
        section{max-width:400px;margin:auto;text-align:left;}
        fieldset{margin:40px 0;padding:20px;font-weight:bold;border:solid 1px #8e8e8e;border-top-color:#a3a3a3;
            border-left-color:#a3a3a3;border-radius:4px 4px 4px 4px;background:#fbfbf3;box-sizing:border-box}
        label{display:block;cursor:pointer;width:250px;font-weight:normal;margin-top:10px;padding-bottom:10px;}
        legend{font-size:1.5em;color:#555;font-weight:400}
        input{width:100%;border-radius:4px 4px 4px 4px;padding:11px 5px 11px;border:solid 1px #dbdbdb;
            border-top-color:#8e8e8e;
            border-left-color:#8e8e8e;font-size:0.8em;box-sizing:border-box}
        input[type=submit]{margin-top:10px;background:#369988;border:solid 1px #06312b;border-top-color: #066a64;
            border-left-color:#06635d;font-weight:bold;font-size:1em;color:#fff;padding:11px 20px 11px 20px;
            display:block;margin: 0;}
        input[type=submit]:hover{cursor:pointer;background:#37a594;}
        .errmess {color:red;}
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="sha1.js"></script>
    </head>
    <script>
    $(document).ready(function(){
        $("#send").click(function(){
            var name = $('form').find('input[name=name]');
            var pass = $('form').find('input[name=pass]');
            var hash = $('form').find('input[name=hash]');
            $.getJSON("getsalt.php?name=" + name.val(), function(data, status) {
                if(data.salt != undefined) {
                    console.log(data.salt.toString());
                    var hashed = Sha1.hash(Sha1.hash(pass.val()) + data.salt.toString());
                    hash.val(hashed);
                    pass.val('');
                    $('form').submit();
                }
            });
            return false;
        });
    });
    </script>
<body>
    <!-- Protected Section -->
<?php if(isset($_SESSION['auth']) && $_SESSION['auth'] == 1): ?>
    <p>You are logged-in [ <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?logout=1'; ?>">Logout</a> ]</p>

    <!-- Login form Section -->
<?php else:
    if(!$ret && isset($_SESSION['attempt']) && $_SESSION['attempt'] >= MAXIMUM_ATTEMPTS)
        echo '<p class="errmess">'.
            'Error: No more attempts allowed!<br />Delete your cookies and try again ...</p>';
    else if(isset($_POST['pass']) && !$ret && isset($_SESSION['attempt']))
        echo '<p class="errmess">'.
            'Error: Invalid user name or password!</p>';
    ?>
    <noscript><p class="errmess">Your browser does not support JavaScript!</p></noscript>
    <section>
        <form id="loginform" name="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <fieldset>
                <legend>Login Form</legend>
                <p><label for="name">Username</label>
                    <input id="name" class="index" name="name" type="text">
                    <label for="pass">Password</label>
                    <input id="pass" class="index" name="pass" type="password">
                    <input id="hash" type="hidden" name="hash"></p>
                <p><input id="send" type="submit" name="send" value="Login"></p>
            </fieldset>
        </form>
    </section>
<?php endif; ?>
</body>
</html>