controllerSettings.file = {
    dataTable: {
        ajax: '/admin/file/data',
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "path"},
            {data: "description"},
            {data: null}
        ],
        responsive: true,
        createdRow: function (row, data, index) {
            
            if (data.act === '0') {
                $(row).addClass('disabled');
            }            
            
            td = $('td', row).eq(4);
            $(row).addClass('js-item');
            td.html('').append('<a href="/admin/file/' + data.id + '" class="btn btn-xs btn-default">show</a>')
                .append('<a href="' + BASE_HREF_ADMIN + '/file/' + data.id + '/edit" class="js-ajax btn btn-xs btn-default" data-target="#page-wrapper">edit</a>')
                .append('<a href="' + BASE_HREF_ADMIN + '/file/act/' + data.id + '" class="js-ajax act btn btn-xs btn-default">act</a>')
                .append('<a href="' + BASE_HREF_ADMIN + '/file/' + data.id + '" class="js-ajax delete btn btn-xs btn-danger">Delete</a>');
        }
    }
};