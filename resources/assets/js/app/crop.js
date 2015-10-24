var x1, y1, x2, y2, crop = 'crop/';
var jcrop_api;
var jcropActive;
var zoom = 1;

function showCoords(c){
   
        x1 = Math.round(c.x * zoom); 
        jcropActive.find('input[name="x1"]').val(x1);		
        y1 = Math.round(c.y * zoom); 
        jcropActive.find('input[name="y1"]').val(y1);		
        x2 = Math.round(c.x2 * zoom); 
        jcropActive.find('input[name="x2"]').val(x2);		
        y2 = Math.round(c.y2 * zoom); 
        jcropActive.find('input[name="y2"]').val(y2);

        jcropActive.find('input[name="w"]').val(c.w);
        jcropActive.find('input[name="h"]').val(c.h);

        if(c.w > 0 && c.h > 0){
                jcropActive.find('button.crop').show();
        }else{
                jcropActive.find('button.crop').hide();
        }

}

function cropInit(panel) {

    if (panel) {

        jcropActive = panel.hasClass('image-crop-holder') ? panel : panel.find('.image-crop-holder');
        jcropIs = jcropActive.find('.target-image-crop');
        width = 460;

        $('.target-image-crop').load(function(){
            // удаляем атрибуты width и height
            $(this).removeAttr("width")
                   .removeAttr("height")
                   .css({ width: "", height: "" });

            // получаем заветные цифры
            var width_natural  = $(this).width();
            var height_natural  = $(this).height();

            zoom = width_natural > width ? (width_natural / width) : 1;

            $(this).width(zoom > 1 ? width : width_natural);
            $(this).height(zoom > 1 ? Math.round(height_natural / zoom) : height_natural);
            inBlock($('#tab-site-load'), $('#tab-site'));
            
        });


        if (jcropIs.length) {

            jcropIs.Jcrop({		
                    onChange:   showCoords,
                    onSelect:   showCoords
            },function(){		
                    jcrop_api = this;		
            });    

        }
    
    }

}

jQuery(function($){             

    $('button.release').click(function(e) {		
		release();
    });   

    $(document).on("change", ".ar_lock", function(e) {
        
        if($(this).val()) {
                                            
            t = $(this).val().split('/');
            jcrop_api.setOptions({aspectRatio: t[0]/t[1]});

        } else {

            jcrop_api.setOptions({aspectRatio: 0});

        }

        jcrop_api.focus();        
      
    });
    
    $(document).on("change", ".size_lock", function(e) {
        
        jcrop_api.setOptions(this.checked? {
                minSize: [ 80, 80 ],
                maxSize: [ 350, 350 ]
        }: {
                minSize: [ 0, 0 ],
                maxSize: [ 0, 0 ]
        });
        jcrop_api.focus();      
        
    });

});

function release(){
	jcrop_api.release();
	jcropActive.find('button.crop').hide();
}

jQuery(function($){
    
        $(document).on("click", "button.original", function(e) {
            
            var id = jcropActive.find('.target-image-crop').data('id');
            
            jcropActive.find('input[name="source"]').val('');
            
            jcropActive.find('.target-image-crop').remove();
            jcropActive.find('.jcrop-holder').remove();
            jcropActive.find('.image-crop').append('<img class="target-image-crop" src="'+$(this).data('src')+'" data-id="' + id + '">');            
            cropInit(jcropActive);
            
            return false;
            
        });
        
        $(document).on("click", "button.crop", function(e) {
            
            var img = jcropActive.find('.target-image-crop').attr('src');
            var id = jcropActive.find('.target-image-crop').data('id');
            var variant = jcropActive.find('input[name="variant"]').val();
            var source = jcropActive.find('input[name="source"]').val() || 'original';
            var revariation = jcropActive.find('input[name="revariation"]').prop('checked') ? 1 : 0;
            var settings = jcropActive.find('input[name="settings"]').prop('checked') ? 1 : 0;
            var _token = $('input[name="_token"]').val();

            var x1 = jcropActive.find('input[name="x1"]').val();
            var y1 = jcropActive.find('input[name="y1"]').val();
            var x2 = jcropActive.find('input[name="x2"]').val();
            var y2 = jcropActive.find('input[name="y2"]').val();

            $.ajax({
                type: "PUT",
                url: BASE_HREF_ADMIN + '/image/' + id,
                dataType: 'json',
                data: {
                    _token: _token,
                    make: 'crop',
                    variant: variant,
                    source: source,
                    revariation: revariation,
                    settings: settings,
                    x1: x1,
                    x2: x2,
                    y1: y1,
                    y2: y2,
                    img: img,
                    crop: crop
                },
                success: function(response){ 

                    jcropActive.find('.target-image-crop').remove();
                    jcropActive.find('.jcrop-holder').remove();
                    jcropActive.find('.image-crop').append('<img class="target-image-crop" src="'+response.data.image+'" data-id="' + id + '">');
                    cropInit(jcropActive);

                }
           });                

           return false;             
            
        });

});