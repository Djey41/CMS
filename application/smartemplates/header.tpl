<html>
<head>
    <title>{$smarty.session.title}</title>
    <link href="../../../../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header">
    <h1>{$smarty.session.name_pages}</h1>
    <form action="search.php" method="POST">
        <table>
            <tr>
                <td><input id="se" placeholder="Search" type="search" name="search" value="{*$smarty.session.search*}" /></td>
                <td><b><input type="submit" name="submit" value="Q" /></b></td>
            </tr>
        </table>
    </form>
</div>
<div id="main">