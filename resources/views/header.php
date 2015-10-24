<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>SB Admin 2 - Bootstrap Admin Theme</title>
        <link rel='stylesheet' href='<?=elixir("css/bootstrap.css");?>' type='text/css' media='all' />
        <link rel='stylesheet' href='<?=elixir("css/admin.css");?>' type='text/css' media='all' />
        <script type='text/javascript'> var _token = '<?=csrf_token();?>';</script>
    </head>
    <body>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?=view('admin::topmenu')?>
                <?=view('admin::leftmenu')?>
            </nav>