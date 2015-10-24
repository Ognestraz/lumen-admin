controllerSettings.video = {
    dataTable: {
        ajax: '/admin/video/data',
        columns: [
            {data: "id"},
            {data: "preview"},
            {data: "name"},
            {data: "url"},
            {data: null}
        ],
        responsive: true,
        createdRow: function (row, data, index) {
            if (data.act === '0') {
                $(row).addClass('disabled');
            }
            
            preview = $('td', row).eq(1);
            preview.html('').append('<a href="' + data.url + '" class="btn btn-xs btn-default" rel="prettyPhoto">\n\
                <img src="' + data.preview + '" width="120" height="80" />\n\
                </a>');
            
            td = $('td', row).eq(4);
            $(row).addClass('js-item');
            td.html('').append('<a href="' + BASE_HREF_ADMIN + '/video/' + data.id + '/edit" class="js-ajax btn btn-xs btn-default" data-target="#page-wrapper">edit</a>')
                .append('<a href="' + BASE_HREF_ADMIN + '/video/act/' + data.id + '" class="js-ajax act btn btn-xs btn-default">act</a>')
                .append('<a href="' + BASE_HREF_ADMIN + '/video/' + data.id + '" class="js-ajax delete btn btn-xs btn-danger">Delete</a>');
            initPrettyPhoto($(row));
        }
    }
};