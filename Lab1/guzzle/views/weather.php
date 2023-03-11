<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body style="background: linear-gradient(#ECF2FF,
#E3DFFD,
#E5D1FA,
#FFF4D2) ;background-attachment: fixed;">
    <section class="container mt-4 text-center mx-auto">
        <h1 class="mb-4">Weather</h1>
        <form method="post" action="index.php">
            <select class="form-select w-75 mx-auto mb-5" name="city" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <?php
                foreach ($egyptianCities as $city) {
                    echo '<option value=' . $city['id'] . '>' . $city['country'] . '>>' . $city['name'] . '</option>';
                }
                ?>
            </select>
            <input id="submit" name="submit" type="submit" value="Get Weather" class="btn text-white fw-bold  mt-5"style="background-color:#A3C7D6"/>
        </form>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>