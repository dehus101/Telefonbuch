<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gowun+Dodum&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Gowun Dodum', sans-serif;
            background-color: #EAEDF8;
            margin: 0;
        }

    
        .main {
            display: block;
        }

        .menu {
            background-color: teal;
            
            padding-top: 120px;
            
        }

        .menu a {
            text-decoration: none;
            color: white;
            padding: 8px;
            display: center;
           
        }

        .menu img {
            margin-right: 8px;
            background-color: #teal;
        }

        .menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .content {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px;
    padding: 20px;
}

        .menubar {
            background-color: white;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 80px;
            box-shadow: 2px 2px 2px black;
            padding-left: 50px;
            display: flex;
            justify-content: space-between;
        }

        .avatar {
            border-radius: 10%;
            background-color: darkkhaki;
            padding: 16px;
            width: 10px;
            height: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 8px;
        }

        .myname {
            display: flex;
            align-items: center;
            margin-right: 50px;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.05);
            margin-bottom: 16px;
            border-radius: 8px;
            padding: 8px;
            padding-left: 64px;
            position: relative;
        }

        .profile-picture {
            width: 48px;
            height: 48px;
            border-radius: 10%;
            border: 2px solid white;
            position: absolute;
            left: 8px;
        }

        .phonebtn {
            background-color: #999900;
            padding: 2px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            position: absolute;
            top: 0px;
            right: 0px;
        }

        .phonebtn:hover {
            background-color: teal;
        }

        .deletebtn {
            background-color: red;
            padding: 4px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            position: absolute;
            bottom: 0px;
            right: 0px;
        }

        .phonebtn:hover {
            background-color: #26d026;
        }

        .deletebtn:hover {
            background-color: #FF3333;
        }
    </style>
</head>

<body>
    <div class="menubar">
        <h1>Addressbuch</h1>

        <div class="myname">
            <div class="avatar">D</div>Dennis Husser
        </div>
    </div>
    <div class="main">
        <div class="menu">
            <a href="index.php?page=start"><img src="img/house.svg"> Start</a>
            <a href="index.php?page=contacts"><img src="img/book.svg"> Kontakte</a>
            <a href="index.php?page=addcontact"><img src="img/add.svg"> Kontakt hinzufügen</a>
            <a href="index.php?page=legal"><img src="img/copyright.svg"> Impressum</a>
        </div>





        <div class="content">


            <?php
            $headline = 'Herzlich willkommen';
            $contacts = [];

            if (file_exists('contacts.txt')) {
                $text = file_get_contents('contacts.txt', true);
                $contacts = json_decode($text, true);
            }


            if (isset($_POST['name']) && isset($_POST['phone'])) {
                echo 'Kontakt <b>' . $_POST['name'] . '</b> wurde hinzugefügt';
                $newContact = [
                    'name' => $_POST['name'],
                    'phone' => $_POST['phone']
                ];
                array_push($contacts, $newContact);
                file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT));
            }

            if ($_GET['page'] == 'delete') {
                $headline = 'Kontakt gelöscht';
            }

            if ($_GET['page'] == 'contacts') {
                $headline = 'Deine Kontakte';
            }

            if ($_GET['page'] == 'addcontact') {
                $headline = 'Kontakt hinzufügen';
            }

            if ($_GET['page'] == 'legal') {
                $headline = 'Impressum';
            }

            echo '<h1>' . $headline . '</h1>';


            if ($_GET['page'] == 'delete') {
                echo '<p>Dein Kontakt wurde gelöscht</p>';
                $index = $_GET['delete']; 
                unset($contacts[$index]); 
                file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT));
            
            } else if ($_GET['page'] == 'contacts') {
                echo "
                    <p>Auf dieser Seite hast du einen Überblick über deine <b>Kontakte</b></p>
                ";

                foreach ($contacts as $index=>$row) {
                    $name = $row['name'];
                    $phone = $row['phone'];
                
                    echo "
                    <div class='card'>
                        <img class='profile-picture' src='img/profile.svg'>
                        <b>$name</b><br>
                        $phone

                        <a class='phonebtn' href='tel:$phone'>Anrufen</a>
                        <a class='deletebtn' href='?page=delete&delete=$index'>Löschen</a>
                    </div>
                    ";
                }

            } else if ($_GET['page'] == 'legal') {
                echo "
                    Hier kommt das Impressum hin
                ";
            } 
             else if ($_GET['page'] == 'addcontact') {
                echo "
                    <div>
                        Auf dieser Seite kannst du einen weiteren Kontakt hinzufügen
                    </div>
                    <form action='?page=contacts' method='POST'>
                        <div>
                            <input type='text' placeholder='Name eingeben' name='name' required>
                        </div>
                        <div>
                            <input  placeholder='Nummer eingeben' type='tel' id='phone' name='phone' required> 
                        </div>
                        <button type='Submit'>Absenden</button>
                    </form>
                ";
            } else {
                echo 'Du bist auf der Startseite!';
            }
            ?>
        </div>
    </div>

    
</body>

</html>