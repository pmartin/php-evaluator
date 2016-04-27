<html>
<head>
    <title>Evaluateur de code PHP</title>
    <style type="text/css">
        #code {
            min-width: 40em;
            min-height: 10em;
        }
    </style>
</head>
<body>
    <form method="post" action="eval.php">
        <p>
            PHP code to evaluate :
            <br>
            <textarea id="code" name="code"></textarea>
            <br>
            (Do not input <code>&lt;?php</code> nor <code>?&gt;</code> tags)
        </p>
        <p>
            <input type="submit">
        </p>
    </form>
</body>
</html>