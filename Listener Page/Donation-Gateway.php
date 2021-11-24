<?php
session_start();

$mysqli = new mysqli("localhost", "root", '', "oson-v2");


if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
}
if (isset($_GET['idArtist']) and isset($_SESSION['id-listener'])) {
    $artistid = $_GET['idArtist'];
    $listenerid = $_SESSION['id-listener'];
}

if (!empty($_POST)) {
    $number =  $_POST['number'];
    $name =  $_POST['name'];
    $amount =  $_POST['amount'];
    $details = $number . '-' . $name ;
    $insert_donate = "INSERT INTO `donatetoartist`(`idListener`, `idArtist`, `Amount`, `CreditCardInformatio`) VALUES ('$listenerid', '$artistid', '$amount', '$details')";
    $result = $mysqli->query($insert_donate);
    if (!$result) {
        echo $mysqli->error;
        
    }else{
        header("Location: Listener-Main-Page.php");
    }
}
?>



<!DOCTYPE html>

<html>

<head>
    <link rel="Stylesheet" href="Donation-Gateway-Styling.css">
    <title>Donation Payment Gateway</title>
    <!--Bootstrap-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>

    <div class="row">
        <h1 class="Donation-Logo">O S O N</h1>
        <section class="Information-Section">
            <div class="container p-0">
                <div class="card px-4">
                    <form name="myform" method="POST">
                        <p class="h8 py-3">Payment Details</p>
                        <div class="row gx-3">
                            <div class="col-12">

                                <div class="d-flex flex-column">
                                    <p class="text mb-1">Card Number</p> <input name="number" class="form-control mb-3" type="text" placeholder="1234 5678 435678">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="d-flex flex-column">
                                    <p class="text mb-1">Expiry</p> <input name="exp" class="form-control mb-3" type="text" placeholder="MM/YYYY">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-column">
                                    <p class="text mb-1">CVV/CVC</p> <input name="cvv" class="form-control mb-3 pt-2 " type="password" placeholder="***">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-column">
                                    <img src="Visa-Logo.png" alt="Banking Company">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-column">
                                    <p class="text mb-1">Person Name</p> <input name="name" class="form-control mb-3" type="text" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-7" onclick="myform.submit()">
                                <div class="btn btn-primary mb-3"> <span class="ps-3">------></span> <span class="fas fa-arrow-right"></span> </div>
                            </div>

                            <div class="col-5 AmountContainer">
                                <input name="amount" type="text" placeholder="Amount" class="Amount">
                            </div>

                            <div class="col">
                                <div class="row gx-3">
                                    <img src="Visa-Logo.png" alt="Visa Logo">
                                </div>
                            </div>

                            <div class="col">
                                <div class="row gx-3">
                                    <img src="Mastercard-Logo.png" alt="Visa Logo">
                                </div>
                            </div>

                            <div class="col">
                                <div class="row gx-3">
                                    <img src="SCB-Logo.png" alt="Visa Logo">
                                </div>
                            </div>

                            <div class="col">
                                <div class="row gx-3">
                                    <img src="Kasikorn-Logo.png" alt="Visa Logo">
                                </div>
                            </div>

                            <div class="col">
                                <div class="row gx-3">
                                    <img src="Paypal-Logo.png" alt="Visa Logo">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>

</html>

<!--



                <div class="row">
            <div class="column-1">

            </div>

            <div class="column-2">
                <header class="Grid-Container">
                    <h2>
                        Payment Details
                    </h2>
                    <input type="radio" value="Remember-Information" id="Rmb-Info" name="Rmb-Info">
                    <label for="Rmb-Info">Remember Information</label>
                </header>
                
            </div>

            <div class="column-3">

            </div>
        </div>

-->