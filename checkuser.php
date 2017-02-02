<?php
function checkUser($db)
{
    if(isset($_SESSION['attempt']) && $_SESSION['attempt'] >= MAXIMUM_ATTEMPTS)
        return false;
    if(!isset($_POST['name']) || empty($_POST['name']))
        return false;
    if(strlen($_POST['name']) < MINIMUM_NAME || strlen($_POST['name']) > MAXIMUM_NAME)
        return false;
    if(!isset($_COOKIE[session_name()]))
        return false;

    $_SESSION['attempt'] = !isset($_SESSION['attempt']) ? 0 : $_SESSION['attempt']++;

    $stmt = $db->prepare("SELECT
                                 `salt`, `user_pass`, `user_pepper`, `a_date`
                             FROM
                                 ".AUTH_TABLE.", ".USERS_TABLE."
                            WHERE
                                 ".AUTH_TABLE.".user_name = ?
                              AND
                                 ".USERS_TABLE.".user_name = ?
                              AND
                                 (t_point > DATE_SUB(NOW(),INTERVAL 1 MINUTE))");

    try
    {
        $stmt->execute(array($_POST['name'], $_POST['name']));
    } catch(PDOException $e)
    {
        echo $e->getMessage();
        return false;
    }
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(empty($result))
        return false;

    $stmt = $db->prepare("DELETE FROM `".AUTH_TABLE."` WHERE user_name = ?");

    try
    {
        $stmt->execute(array($_POST['name']));
    } catch(PDOException $e)
    {
        echo $e->getMessage();
        return false;
    }
    $affected_rows = $stmt->rowCount();

    if(sha1($result['user_pass'].$result['salt']) != $_POST['hash'])
        return false;

    // Login successful
    $stmt = $db->prepare("UPDATE
                                 ".USERS_TABLE."
                             SET
                                 last_login=NOW()
                           WHERE
                                 user_name = ?");

    try
    {
        $stmt->execute(array($_POST['name']));
    } catch(PDOException $e)
    {
        echo $e->getMessage();
        return false;
    }
    $_SESSION['auth'] = 1;
    unset($_SESSION['attempt']);
    return true;
}

function logout(){session_destroy();session_unset();unset($_SESSION);}
