<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Видео - <a href="<?=url('/')."/admin/video/create"?>" class="js-ajax btn btn-primary btn-xs" data-target="#page-wrapper">Добавить</a>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover dataTable" id="dataTables-example" data-controller="video">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Preview</th>
                            <th>Name</th>
                            <th>Url</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>