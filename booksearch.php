<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Listing 12-3</title>
    </head>
    <body>
        <h1>Query the Books Database</h1>
        <h3>Search for a Title</h3>
        <p>Procede and/or follow the entry with % if not a complete title.</p>
        <?php
        if (!$_POST) {
            //Enter Form Information
            ?>
            <form action = "<?= $_SERVER['PHP_SELF'] ?>" method = "post">
                <p>Book Title: <input type = "text" name = "title"> </p>
                <p><input type="submit" name = "submit" value="submit"</p>
            </form>
            <?php
        } else {
            // connect to the Book database
            //mysqli_connect() function opens a new connection to the MySQL server.
            $conn = mysqli_connect("localhost", "root", "", "mydb");
            if (!$conn) {
                echo "Couldnt connect." . mysqli_connect_error();
                //mysqli_connect_error() function returns the error description from the last connection error, if any
            }
            // Remove white space, check for blank, and remove special characters
            if (($title = trim($_POST['title'])) == '') {
                echo "Please enter a title.";
                ?>
                <meta http-equiv="Refresh" content="5; url = /MyProject/booksearch.php">
                <!-- Refreshes and redirects to the initial search query page.-->
                <?=
                $_POST['submit'] = NULL;
            } else {
                //Escape special characters in the title
                //mysqli_real_escape_string() function escapes special characters in a string for use in an SQL statement.
                $title = mysqli_real_escape_string($conn, $_POST['title']);
            }
            $query = "SELECT * FROM books where Title LIKE '$title'";
            if ($result = mysqli_query($conn, $query)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo $row['Title'] . " - " . $row['Author'] . " - " . $row['Publisher'] . " - $" . $row['Price'] . "<br />";
                    }
                } else {
                    echo "No records matching your query were found.";
                }
            }
            //Fetch rows from a result-set, then free the memory associated with the results.
            mysqli_free_result($result);
            mysqli_close($conn);
        }
        ?>
    </body>
</html>