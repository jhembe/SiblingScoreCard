<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Import</title>
    <link rel="stylesheet" href="../style/bootstrap.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
            max-width: 400px;
            margin: 0 auto;
        }
        .custom-file-label {
            overflow: hidden;
        }
        .message {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Data Import</h1>
        <form action="import_process.php" method="POST" enctype="multipart/form-data">
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="excelFile" name="excelFile" accept=".xlsx, .xls">
                <label class="custom-file-label" for="customFile">Choose Excel file</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Import Data</button>
        </form>
        <div class="message mt-3">
            <?php
            if (isset($_GET['message'])) {
                echo $_GET['message'];
            }
            ?>
        </div>
    </div>
</body>
</html>
