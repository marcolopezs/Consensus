$('.editors').each(function(){
    CKEDITOR.replace( $(this).attr('id'),{
        customConfig: '/js/ckeditor-config.js'
    });
});
