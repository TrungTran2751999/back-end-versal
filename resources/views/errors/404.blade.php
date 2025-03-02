<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>loading...</h1>
</body>
<script>
    localStorage.setItem("PreUrl", window.location.pathname + window.location.search);
    window.location.href = "/";
</script>
</html>