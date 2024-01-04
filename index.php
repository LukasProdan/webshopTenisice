<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web-shop Tenisice</title>
    <link rel="stylesheet" href="stil.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 

</head>

<body>
    <div class="w3-container">
        <h1>Web shop - Tenisice</h1>    
        <h3>Dobrodošli!</h3>
        <?php
            $server = "ucka.veleri.hr";
            $database = "lprodan";
            $username = "lprodan";
            $password = "11";

            $conn = mysqli_connect($server, $username, $password, $database);

            // Zadani upit za dohvaćanje svih redaka iz tablice 'tenisice'
            $query = "SELECT * FROM tenisice";

            // Filtriranje po marki
            if (isset($_GET['brand']) && !empty($_GET['brand'])) {
                $brand = mysqli_real_escape_string($conn, $_GET['brand']);
                $query .= " WHERE marka = '$brand'";
            }

            // Filtriranje po veličini
            if (isset($_GET['size']) && !empty($_GET['size'])) {
                $size = mysqli_real_escape_string($conn, $_GET['size']);
                $query .= isset($_GET['velicina']) ? " AND velicina = '$size'" : " WHERE velicina = '$size'";
            }

            // Sortiranje po cijeni
            if (isset($_GET['sort']) && $_GET['sort'] == 'asc') {
                $query .= " ORDER BY cijena ASC";
            } elseif (isset($_GET['sort']) && $_GET['sort'] == 'desc') {
                $query .= " ORDER BY cijena DESC";
            }

            $res = mysqli_query($conn, $query);
        ?>

        <!-- Prikaz opcija za filtriranje i sortiranje u HTML-u -->
    <div>
    <form action="" method="GET">
        <label for="brand">Filtriraj po marki:</label>
        <input type="text" name="brand" id="brand" placeholder="Unesite marku">
            <br>
        <label for="size">Filtriraj po veličini:</label>
        <input type="text" name="size" id="size" placeholder="Unesite veličinu">
            <br>
        <label for="sort">Sortiraj po cijeni:</label>
        <select name="sort" id="sort">
            <option value="asc">Od najniže do najviše</option>
            <option value="desc">Od najviše do najniže</option>
        </select>
            <br>
        <input type="submit" value="Primijeni filtre">
    
    </form>
    </div>

        <div>
            <h4>Popis tenisica:<h4>
            <table class="w3-table-all">
                <tr class="w3-blue">
                    <th>Marka</th>
                    <th>Ime</th>
                    <th>Veličina</th>
                    <th>Cijena</th>
                    <th>Slika</th>
                    <th>Dostupnost</th>
                </tr>
                <?php
                    while($row = mysqli_fetch_array($res)){
                        echo "<tr>";
                        echo "<td>".$row['marka']."</td>";
                        echo "<td>".$row['ime']."</td>";
                        echo "<td>".$row['velicina']."</td>";
                        echo "<td>".$row['cijena']."</td>";
                        echo "<td><img src='".$row['slika'].
                        "' width='100px' alt='".$row['ime']."'></td>";
                        echo "<td>".$row['dostupnost']."</td>";
                        echo "</tr>";
                    }
                    mysqli_close($conn);
                ?>
                
            </table>
            
        </div>
        </div>
    
</body>
</html>