CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'Full';
    config.resize_minWidth = 610;
    config.resize_maxWidth = 760;
    config.resize_minHeight = 150;
    config.resize_maxHeight = 700;

    //config.resize_enabled = false;
    config.toolbar_Full =
    [
        ['Source'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord'],
        [/*'Undo','Redo','-',*/'Find','Replace','-','RemoveFormat'],



        ['NumberedList','BulletedList'],
        ['Link','Unlink','Anchor'],
        ['Image','Flash','Table','HorizontalRule','SpecialChar'],
        '/',
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Bold','Italic','Underline','Strike','-','Format','Font','FontSize'],
        ['TextColor','BGColor'],
        //['Maximize', 'ShowBlocks']
    ];

};
