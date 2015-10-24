        </div>
        <!-- /#wrapper -->
        
        <script>
            var BASE_HREF = "<?=url('/')?>";
            var BASE_HREF_ADMIN = "<?=url('/')?>/admin";
            var controllerSettings = {};
            window.FileAPI = {
                debug: false,
                staticPath: '<?=url('/')?>/assets/js/FileAPI/' 
            };			
        </script>        
        <script src='<?=elixir("js/admin-sb2.js");?>'></script>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script src='<?=elixir("js/admin.js");?>'></script>
    </body>
</html>